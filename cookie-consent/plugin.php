<?php
/*
	@Package: Bludit
	@Plugin: Cookie Consent 
	@Version: 0.1
	@Author: Fred K.
	@Realised: 10 August 2015	
	@Updated: 10 August 2015
*/
class pluginCookieConsent extends Plugin {
	private $loadWhenController = array(
		'configure-plugin'
	);		
	// Plugin datas
	public function init()
	{
		$this->dbFields = array(
			'enable'=>true,
			'message'=>'This website uses cookies to ensure you get the best experience on our website',
			'dismiss'=>'Got it!',
			'learnMore'=>'More info',
			'link'=>'http://silktide.com/cookieconsent',
			'theme'=>'dark-floating'
			);
	}
	// Styled plugin in backend
	public function adminHead()
	{
		global $layout, $Site;
		$PathPlugins = 'plugins/cookie-consent/libs/';
		$config_url = $Site->url().$PathPlugins;
		
		$html  = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{		
			$html .= ''.PHP_EOL;
		}

		return $html;
	}	
	// Backend configuration page
	public function form()
	{
		global $Language, $Site;
		$PathPlugins = 'plugins/cookie-consent/configurator-themes/';
		$config_url = $Site->url().$PathPlugins;

		$html  = '<div>';
		$html .= '<input name="enable" id="jsenable" type="checkbox" value="true" '.($this->getDbField('enable')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenable">'.$Language->get('Enable plugin (Config save)').'</label>';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="theme">'.$Language->get('Choose theme');
        $html .= '<select name="theme" class="image-picker show-labels show-html width-50">';
        $themeOptions = array('dark-bottom' => $Language->get('Dark Bottom'),'dark-floating' => $Language->get('Dark Floating'),'dark-top' => $Language->get('Dark Top'),'light-bottom' => $Language->get('Light Bottom'),'light-floating' => $Language->get('Light Floating'),'light-top' => $Language->get('Light Top'));
        foreach($themeOptions as $text=>$value)
            $html .= '<option style="background-image:url(\''.$config_url.$text.'.png\');" value="'.$text.'"'.( ($this->getDbField('theme')===$text)?' selected="selected"':'').'>'.$value.'</option>';
        $html .= '</select>';
        $html .= '<div class="forms-desc">';
		$html .= '<ul class="blocks-6">';
		$html .= '<li><figure><img src="'.$config_url. 'dark-bottom.png" alt="dark-bottom" /><figcaption>' .$Language->get('Dark Bottom'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$config_url. 'dark-floating.png" alt="dark-floating" /><figcaption>' .$Language->get('Dark Floating'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$config_url. 'dark-top.png" alt="dark-top" /><figcaption>' .$Language->get('Dark Top'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$config_url. 'light-bottom.png" alt="light-bottom" /><figcaption>' .$Language->get('Light Bottom'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$config_url. 'light-floating.png" alt="light-floating" /><figcaption>' .$Language->get('Light Floating'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$config_url. 'light-top.png" alt="light-top" /><figcaption>' .$Language->get('Light Top'). '</figcaption></figure></li>';
		$html .= '</ul>';        
		$html .= '</div>';
		$html .= '</label>';
		$html .= '</div>';	
		
		$html .= '<div>';				
		$html .= '<label for="message">'.$Language->get('Headline text');
		$html .= '<textarea name="message" id="jsmessage" class="width-70" rows="3">'.$this->getDbField('message').'</textarea>';
		$html .= '</label>';
		$html .= '</div>';

		$html .= '<div>';				
		$html .= '<label for="dismiss">'.$Language->get('Accept button text');
		$html .= '<input type="text" name="dismiss" id="jsdismiss" value="'.$this->getDbField('dismiss').'" />';
		$html .= '</label>';
		$html .= '</div>';
		
		$html .= '<div>';				
		$html .= '<label for="learnMore">'.$Language->get('Read more button text');
		$html .= '<input type="text" name="learnMore" id="jslearnMore" value="'.$this->getDbField('learnMore').'" />';
		$html .= '</label>';
		$html .= '</div>';
		
		$html .= '<div>';				
		$html .= '<label for="link">'.$Language->get('Your cookie policy');
		$html .= '<input type="url" name="link" id="jslink" class="width-70" value="'.$this->getDbField('link').'" />';
		$html .= '<div class="forms-desc">'.$Language->get('If you already have a cookie policy, link to it here.'). '</div>';
		$html .= '</label>';
		$html .= '</div>';						

		return $html;
	}
	// Show in Public theme head	
	public function siteHead()
	{
		global $Site;
		$PathPlugins = 'plugins/cookie-consent/configurator-themes/';
		$config_url = $Site->url().$PathPlugins;
		$html = ''.PHP_EOL;	
			
		if($this->getDbField('enable')) {		
			$html .= PHP_EOL.'<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->'.PHP_EOL;
			$html .= '<script type="text/javascript">'.PHP_EOL;
			$html .= 'window.cookieconsent_options = {"message":"'.$this->getDbField('message').'","dismiss":"'.$this->getDbField('dismiss').'","learnMore":"'.$this->getDbField('learnMore').'","link":"'.$this->getDbField('link').'","theme":"'.$this->getDbField('theme').'"};'.PHP_EOL;
			$html .= '</script>'.PHP_EOL;
	
			$html .= '<script type="text/javascript" src="' .$config_url. 'cookieconsent.latest.min.js"></script>'.PHP_EOL;
			$html .= '<!-- End Cookie Consent plugin -->'.PHP_EOL;
		}
		return $html;
	}
}