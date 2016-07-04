<?php

class pluginTwitterCards extends Plugin {

	private function getImage($content)
	{
		$dom = new DOMDocument();
		$dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$content);
		$finder = new DomXPath($dom);

		// $images = $finder->query("//img[contains(@class, 'bludit-img-opengraph')]");

		// if($images->length==0) {
		// 	$images = $finder->query("//img");
		// }
			$images = $finder->query("//img");

		if($images->length>0)
		{
			// First image from the list
			$image = $images->item(0);
			// Get value from attribute src
			$imgSrc = $image->getAttribute('src');
			// Returns the image src
			return $imgSrc;
		}

		return false;
	}

	public function init()
	{
	    $this->dbFields = array(
	        'twitter-username'=>"@siteowner's twitter name",
	        'twitter-card-type-post'=>'summary',
	        'twitter-card-type-page'=>'summary_large_image'
	    );
	}
	
	public function form()
	{
	    global $Language;
	    $html  = '<div>';
	    $html .= '<label for="twitter-username">'.$Language->get('twitterusername').'</label>';
	    $html .= '<input type="text" name="twitter-username" value="'.$this->getDbField('twitter-username').'" />';
	    $html .= '<div class="tip">'.$Language->get("complete-this-field-with-the-twitter-sites-owner-username").'</div>';

	    $html .= '<label for="twitter-card-type-post">'.$Language->get('twittercardtypepost').'</label>';
	    $html .= '<input type="text" name="twitter-card-type-post" value="'.$this->getDbField('twitter-card-type-post').'" />';
	    $html .= '<div class="tip">'.$Language->get("complete-this-field-with-the-twitter-card-type-for-page").'</div>';

	    $html .= '<label for="twitter-card-type-page">'.$Language->get('twittercardtypepage').'</label>';
	    $html .= '<input type="text" name="twitter-card-type-page" value="'.$this->getDbField('twitter-card-type-page').'" />';
	    $html .= '<div class="tip">'.$Language->get("complete-this-field-with-the-twitter-card-type-for-page").'</div>';

	    $html .= '</div>';
	    return $html;
	}


	public function siteHead()
	{
		global $Url, $Site;
		global $Post, $Page, $posts, $dbUsers;

		$admin = $dbUsers->getDb( 'admin' );

		$twcd = array(
			'locale'	=>$Site->locale(),
			'type'		=>'summary',
			'site'		=> $this->getDbField('twitter-username'),
			'creator'	=> '',
			'title'		=>$Site->title(),
			'description'	=>$Site->description(),
			'url'		=>$Site->url(),
			'image'		=> '',
			'siteName'	=>$Site->title()
		);

		switch($Url->whereAmI())
		{
			case 'post':
				$twcd['type']		= $this->getDbField('twitter-card-type-post');
				$twcd['site']		= $this->getDbField('twitter-username'); // admin's twitter username
				$twcd['creator']		= $dbUsers->getDb( $Post->username() )['lastName']; //author's twitter username
				$twcd['title']		= mb_substr($Post->title(), 0, 70, "UTF-8").' | '.$twcd['title'];
				$twcd['description']	= mb_substr($Post->description(), 0, 200, "UTF-8");
				$twcd['url']		= $Post->permalink(true);
				$twcd['image'] 		= $Post->coverImage(false);

				$content = $Post->content();
				break;

			case 'page':
				$twcd['type']		= $this->getDbField('twitter-card-type-page');
				$twcd['site']		= $this->getDbField('twitter-username'); // admin's twitter username
				$twcd['creator']	= $dbUsers->getDb( $Page->username() )['lastName']; //author's twitter username
				$twcd['title']		= mb_substr($Page->title(), 0, 70, "UTF-8").' | '.$twcd['title'];
				$twcd['description']	= mb_substr($Page->description(), 0, 200, "UTF-8");
				$twcd['url']		= $Page->permalink(true);
				$twcd['image'] 		= $Page->coverImage(false);

				$content = $Page->content();
				break;

			default:
				$content = isset($posts[0])?$posts[0]->content():'';
				break;
		}

		$html  = PHP_EOL.'<!-- Twitter Cards -->'.PHP_EOL;
		$html .= '<meta property="twitter:card" content="'.$twcd['type'].'">'.PHP_EOL;
		$html .= '<meta property="twitter:site" content="'.$twcd['site'].'">'.PHP_EOL; // twitter usernames
		$html .= '<meta property="twitter:creator" content="'.$twcd['creator'].'">'.PHP_EOL; // twitter usernames
		$html .= '<meta property="twitter:title" content="'.$twcd['title'].'">'.PHP_EOL;
		$html .= '<meta property="twitter:description" content="'.$twcd['description'].'">'.PHP_EOL;

		$domain = trim($Site->domain(),'/');
		$urlImage = $domain.HTML_PATH_UPLOADS;

		if($twcd['image']===false)
		{
			// Get the image from the content
			$src = $this->getImage( $content );
			if($src!==false) {
				$html .= '<meta property="twitter:image" content="'.$urlImage.str_replace(HTML_PATH_UPLOADS,'',$src).'">'.PHP_EOL;
			}
		}
		else
		{
			$html .= '<meta property="twitter:image" content="'.$urlImage.$twcd['image'].'">'.PHP_EOL;
		}

		return $html;
	}
}
