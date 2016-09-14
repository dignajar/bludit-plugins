<?php

class pluginAds4U extends Plugin {

	private $enable;
	
        private function ads4u()
        {
                $ret  = '<!-- Ads4U BEGIN -->'.PHP_EOL;
		$ret .= Sanitize::htmlDecode($this->getDbField('ads4uCode')).PHP_EOL;
		$ret .= '<!-- Ads4U END -->'.PHP_EOL;

                return $ret;
        }

	public function init()
	{
		$this->dbFields = array(
                        'enablePages'=>0,
                        'enablePosts'=>0,
			'ads4uCode'=>''
		);
	}

        function __construct()
        {
                parent::__construct();

                global $Url;

                $this->enable = false;

		if( $this->getDbField('ads4uCode') != '' ) {
                	if( $this->getDbField('enablePosts') && ($Url->whereAmI()=='post') ) {
                        	$this->enable = true;
                	}
                	elseif( $this->getDbField('enablePages') && ($Url->whereAmI()=='page') ) {
                        	$this->enable = true;
                	}
		}
        }

	public function form()
	{
		global $Language;

                $html = '<div>';
                $html .= '<input type="hidden" name="enablePages" value="0">';
                $html .= '<input name="enablePages" id="jsenablePages" type="checkbox" value="1" '.($this->getDbField('enablePages')?'checked':'').'>';
                $html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('Enable Ads4U on pages').'</label>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<input type="hidden" name="enablePosts" value="0">';
                $html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="1" '.($this->getDbField('enablePosts')?'checked':'').'>';
                $html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('Enable Ads4U on posts').'</label>';
                $html .= '</div>';

		$html .= '<div>';
		$html .= '<label for="jsads4uCode">'.$Language->get('ads4u-html-code').'</label>';
		$html .= '<textarea id="jsads4uCode" type="text" name="ads4uCode">'.$this->getDbField('ads4uCode').'</textarea>';
		$html .= '<div class="tip">'.$Language->get('complete-this-field-with-html-code').'</div>';
		$html .= '</div>';

		return $html;
	}
	
	public function postEnd()
	{
		if( $this->enable ) {
			return $this->ads4u();
		}
		return false;
	}

	public function pageEnd()
	{
                if( $this->enable ) {
                        return $this->ads4u();
                }
                return false;
        }

}
