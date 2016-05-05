<?php

class pluginAddToAny extends Plugin {

	private $disable;
	
	private function a2acode()
	{
		$ret  = '<!-- AddToAny BEGIN -->
			<div class="a2a-social" style="margin:20px 0px;">
				<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
					<a class="a2a_button_facebook"></a>
					<a class="a2a_button_twitter"></a>
					<a class="a2a_button_google_plus"></a>
					<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
				</div>
			</div>
			<!-- AddToAny END -->';
	
		if ( $this->getDbField('enableMinifyURL') ) {
			$ret .='<script type="text/javascript">
				var a2a_config = a2a_config || {};
				a2a_config.track_links = "googl";
				</script>';
		};
	
		return $ret;
	}
	
	public function init()
	{
		$this->dbFields = array(
			'enablePages'=>false,
			'enablePosts'=>true,
			'enableDefaultHomePage'=>false,
			'enableMinifyURL'=>false
		);
	}

	function __construct()
	{
		parent::__construct();

		global $Url;

		// Disable the plugin IF ...
		$this->disable = false;

		if( (!$this->getDbField('enablePosts')) && ($Url->whereAmI()=='post') ) {
			$this->disable = true;
		}
		elseif( (!$this->getDbField('enablePages')) && ($Url->whereAmI()=='page') ) {
			$this->disable = true;
		}
		elseif( !$this->getDbField('enableDefaultHomePage') && ($Url->whereAmI()=='page') )
		{
			global $Page;
			global $Site;
			if( $Site->homePage()==$Page->key() ) {
				$this->disable = true;
			}
		}
		elseif( ($Url->whereAmI()!='post') && ($Url->whereAmI()!='page') ) {
			$this->disable = true;
		}
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input name="enablePages" id="jsenablePages" type="checkbox" value="true" '.($this->getDbField('enablePages')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('enable-addtoany-on-pages').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="true" '.($this->getDbField('enablePosts')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('enable-addtoany-on-posts').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enableDefaultHomePage" id="jsenableDefaultHomePage" type="checkbox" value="true" '.($this->getDbField('enableDefaultHomePage')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenableDefaultHomePage">'.$Language->get('enable-addtoany-on-default-home-page').'</label>';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<input name="enableMinifyURL" id="jsenableMinifyURL" type="checkbox" value="true" '.($this->getDbField('enableMinifyURL')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenableMinifyURL">'.$Language->get('enable-google-url-shortener').'</label>';
		$html .= '</div>';

		return $html;
	}
	
	public function postEnd()
	{
		if( $this->disable ) {
			return false;
		}
		return $this->a2acode();
	}

	public function pageEnd()
	{
		if( $this->disable ) {
			return false;
		}
		return $this->a2acode();
	}
  
	public function siteHead()
	{
		if( $this->disable ) {
			return false;
		}

    $html = '<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>';
    
		return $html;
	}
	

  // Some themes don't like it in siteBodyEnd
  
  /* public function siteBodyEnd()
	{
		if( $this->disable ) {
			return false;
		}

		$html = '<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>';

		return $html;
	} */
}
