<?php

class pluginAddToAny extends Plugin {

	private $disable;

	public function init()
	{
		$this->dbFields = array(
			'enablePages'=>false,
			'enablePosts'=>true,
			'enableDefaultHomePage'=>false
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
		$html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('Enable AddToAny on pages').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="true" '.($this->getDbField('enablePosts')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('Enable AddToAny on posts').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enableDefaultHomePage" id="jsenableDefaultHomePage" type="checkbox" value="true" '.($this->getDbField('enableDefaultHomePage')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenableDefaultHomePage">'.$Language->get('Enable AddToAny on default home page').'</label>';
		$html .= '</div>';

		return $html;
	}

	public function postEnd()
	{
		if( $this->disable ) {
			return false;
		}

		$html  = '<!-- AddToAny BEGIN -->
    <div class="a2a-social" style="margin:20px 0px;">
    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
    <a class="a2a_button_facebook"></a>
    <a class="a2a_button_twitter"></a>
    <a class="a2a_button_google_plus"></a>
    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
    </div>
    </div>
    <!-- AddToAny END -->';
		return $html;
	}

	public function pageEnd()
	{
		if( $this->disable ) {
			return false;
		}

		$html  = '<!-- AddToAny BEGIN -->
    <div class="a2a-social" style="margin:20px 0px;">
    <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
    <a class="a2a_button_facebook"></a>
    <a class="a2a_button_twitter"></a>
    <a class="a2a_button_google_plus"></a>
    <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
    </div>
    </div>
    <!-- AddToAny END -->';
		return $html;
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
