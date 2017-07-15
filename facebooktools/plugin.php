<?php


class pluginFacebookTools extends Plugin {


	public function init()
	{
		$this->dbFields = array(
			'facebook-app-id'=>'',
			'facebook-site-url'=>'',
			'coverImage' => '',
			'facebook-social-comments' => false,
		);
	}
	
	public function form()
	{
		global $Language;

		
		$html  = '<div>';
		$html .= '<label for="facebook-app-id">'.$Language->get('Facebook App ID').'</label>';
		$html .= '<input id="facebook-app-id" type="text" name="facebook-app-id" value="'.$this->getDbField('facebook-app-id').'">';
		$html .= '<div class="tip">'.$Language->get('complete-this-field-with-the-facebook-app-id').'</div>';
		$html .= '</div>';
		$html .= '<div>';		
		$html .= '<input name="facebook-social-comments" id="facebook-social-comments" type="checkbox" value="'.($this->getDbField('facebook-social-comments') ? 'true' : 'false').'" '.($this->getDbField('facebook-social-comments')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="facebook-social-comments">'.$Language->get('enable-facebook-social-comments').'</label>';
		$html .= '</div>';
		
		echo '<div class="tip">'.$Language->get('complete-this-field-with-the-facebook-share-image').'</div>';
		echo '<style>#cover-image-thumbnail {height:249px;background-size:contain;} </style>';
		echo '<div style="width:476px; height:249px;" >';
		HTML::bluditCoverImage($this->getDbField('coverImage'));
		echo '</div >';
		
		// --- BLUDIT IMAGES V8 ---
		HTML::bluditImagesV8();
		
		return $html;
	}

    public function siteHead() {
		global $Site,$Url,$Post;
        echo '<meta property="og:url" content="'.DOMAIN.$Url->uri().'" />';
        echo '<meta property="og:type" content="article" />';
		/*
		if(!Text::isEmpty($this->getDbField('facebook-app-id'))) {
			echo '<meta property="og:app_id" content="'.$this->getDbField('facebook-app-id').'" />';
		}
		*/
        if($Url->whereAmI()=='post') {
			echo '<meta property="og:title" content="'.$Post->title().'" />';
			echo '<meta property="og:description" content="'.$Post->description().'" />';
			if($Post->coverImage()){
				echo '<meta property="og:image" content="'.DOMAIN.$Post->coverImage().'" />';
			} else {
				echo '<meta property="og:image" content="'.DOMAIN.HTML_PATH_UPLOADS.$this->getDbField('coverImage').'" />';
			}
        } else {
			echo '<meta property="og:title" content="'.$Site->title().'" />';
			echo '<meta property="og:description" content="'.$Site->description().'" />';
			echo '<meta property="og:image" content="'.DOMAIN.HTML_PATH_UPLOADS.$this->getDbField('coverImage').'" />';
		}
    }
	
	public function siteBodyBegin() {
		global $Url;
		
		if(Text::isEmpty($this->getDbField('facebook-app-id'))) {
			return false;
		}
		
		$html = PHP_EOL.'<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.9&appId='.$this->getDbField('facebook-app-id').'";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, "script", "facebook-jssdk"));</script>'.PHP_EOL;
		
		return $html;
	}
	
	public function siteSidebar() {
		
	}
	
	/*
		Adding Facebook Social Plugin Comments to the end of a post
	*/
	public function postEnd() {
		global $Url;
		
		if(!($this->getDbField('facebook-social-comments')) || !($Url->whereAmI()=='post')) {
			return false;
		}
		
		$html = PHP_EOL.'<div class="fb-comments" data-href="'.DOMAIN.$Url->uri().'" data-numposts="5"></div>'.PHP_EOL;
		return $html;
	}
}

?>