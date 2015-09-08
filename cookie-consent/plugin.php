<?php
/*
	@Package: Bludit
	@Plugin: Cookie Consent 
	@Version: 1.0
	@Author: Fred K.
	@Realised: 10 August 2015	
	@Updated: 08 September 2015
*/
class pluginCookieConsent extends Plugin {
	private $loadWhenController = array(
		'configure-plugin'
	);		
	// Plugin datas
	public function init()
	{
		$this->dbFields = array(
			'enable' => true,
			'message' => 'Ce site utilise des cookies, notamment pour les statistiques de visites. Le fait de continuer à naviguer implique votre accord tacite.',
			'dismiss' => 'Fermer l’avertissement',
			'learnMore' => 'En savoir plus',
			'link' => 'http://silktide.com/cookieconsent',
			'theme' => 'dark-floating',
			'adblock' => false,
			'adblock_message' => '<h4>Il semblerait que vous utilisez Adblock, ou un autre logiciel destiné à bloquer les publicités.</h4>Quand vous cliquez sur une bannière de pub, c’est aussi remercier l’auteur du site pour les articles que vous lisez.<br />Si vous pensez que tout travail mérite récompense, alors n’hésitez pas à faire un bon geste avec un petit clic. Merci.',
			'adblock_background_color' => '146FC2'
			);
	}
	public function adminHead()
	{
		global $layout;

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$pluginPath = $this->htmlPath();
			return '<script src="' .$pluginPath. 'jscolor/jscolor.js"></script>'.PHP_EOL;		
		}
	}		
	// Backend configuration page
	public function form()
	{
		global $Language, $Site;
		$pluginPath = $this->htmlPath(). 'configurator-themes/';
		
		$html  = '<div>';		
		$html .= '<input name="enable" id="jsenable" type="checkbox" value="true" '.($this->getDbField('enable')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenable">'.$Language->get('Enable plugin (Config save)').'</label>';
		$html .= '</div>';

		$html .= '<div' .($this->getDbField('enable') ? '':' style="display:none"'). '>';
		$html .= '<label for="theme">'.$Language->get('Choose theme');
	    $html .= '<select name="theme" class="image-picker show-labels show-html width-50">';
	    $themeOptions = array('dark-bottom' => $Language->get('Dark Bottom'),'dark-floating' => $Language->get('Dark Floating'),'dark-top' => $Language->get('Dark Top'),'light-bottom' => $Language->get('Light Bottom'),'light-floating' => $Language->get('Light Floating'),'light-top' => $Language->get('Light Top'));
	        foreach($themeOptions as $text=>$value)
	    $html .= '<option style="background-image:url(\''.$pluginPath.$text.'.png\');" value="'.$text.'"'.( ($this->getDbField('theme')===$text)?' selected="selected"':'').'>'.$value.'</option>';
	    $html .= '</select>';
	    $html .= '<div class="forms-desc">';
		$html .= '<ul class="blocks-6">';
		$html .= '<li><figure><img src="'.$pluginPath. 'dark-bottom.png" alt="dark-bottom" /><figcaption>' .$Language->get('Dark Bottom'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$pluginPath. 'dark-floating.png" alt="dark-floating" /><figcaption>' .$Language->get('Dark Floating'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$pluginPath. 'dark-top.png" alt="dark-top" /><figcaption>' .$Language->get('Dark Top'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$pluginPath. 'light-bottom.png" alt="light-bottom" /><figcaption>' .$Language->get('Light Bottom'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$pluginPath. 'light-floating.png" alt="light-floating" /><figcaption>' .$Language->get('Light Floating'). '</figcaption></figure></li>';
		$html .= '<li><figure><img src="'.$pluginPath. 'light-top.png" alt="light-top" /><figcaption>' .$Language->get('Light Top'). '</figcaption></figure></li>';
		$html .= '</ul>';        
		$html .= '</div>';
		$html .= '</label>';
		$html .= '</div>';	
			
		$html .= '<div' .($this->getDbField('enable') ? '':' style="display:none"'). '>';				
		$html .= '<label for="message">'.$Language->get('Headline text');
		$html .= '<textarea name="message" id="jsmessage" class="width-70" rows="3">'.$this->getDbField('message').'</textarea>';
		$html .= '</label>';
		$html .= '</div>';
	
		$html .= '<div' .($this->getDbField('enable') ? '':' style="display:none"'). '>';				
		$html .= '<label for="dismiss">'.$Language->get('Accept button text');
		$html .= '<input type="text" name="dismiss" id="jsdismiss" value="'.$this->getDbField('dismiss').'" />';
		$html .= '</label>';
		$html .= '</div>';
			
		$html .= '<div' .($this->getDbField('enable') ? '':' style="display:none"'). '>';				
		$html .= '<label for="learnMore">'.$Language->get('Read more button text');
		$html .= '<input type="text" name="learnMore" id="jslearnMore" value="'.$this->getDbField('learnMore').'" />';
		$html .= '</label>';
		$html .= '</div>';
			
		$html .= '<div' .($this->getDbField('enable') ? '':' style="display:none"'). '>';				
		$html .= '<label for="link">'.$Language->get('Your cookie policy');
		$html .= '<input type="url" name="link" id="jslink" class="width-70" value="'.$this->getDbField('link').'" />';
		$html .= '<div class="forms-desc">'.$Language->get('If you already have a cookie policy, link to it here.'). '</div>';
		$html .= '</label>';
		$html .= '</div>';
			
		/*	Detect AdBlock Part */	
		$html .= '<h2><i class="fa fa-ban"></i> ' .$Language->get('adblock_config'). '</h2>';						
		$html .= '<div>';
		$html .= '<input name="adblock" id="jsadblock" type="checkbox" value="true" '.($this->getDbField('adblock')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsadblock">'.$Language->get('Ad blocker detection plugin').'</label>';
		$html .= '</div>';

		$html .= '<div' .($this->getDbField('adblock') ? '':' style="display:none"'). '>';				
		$html .= '<label for="adblock_background_color">'.$Language->get('adblock_background_color');
		$html .= '<input type="text" class="color" name="adblock_background_color" id="jsadblock_background_color" value="'.$this->getDbField('adblock_background_color').'" />';
		$html .= '</label>';
		$html .= '</div>';
			
		$html .= '<div' .($this->getDbField('adblock') ? '':' style="display:none"'). '>';				
		$html .= '<label for="adblock_message">'.$Language->get('adblock_message');
		$html .= '<textarea name="adblock_message" id="jsadblock_message" class="width-70" rows="5">'.$this->getDbField('adblock_message').'</textarea>';
		$html .= '</label>';
		$html .= '</div>';	
		
		return $html;
	}
	// Show in Public theme head	
	public function siteHead()
	{
		global $Site;
		$pluginPath = $this->htmlPath() .'configurator-themes/';
		$html = ''.PHP_EOL;	
			
		if($this->getDbField('enable')) {		
			$html .= PHP_EOL.'<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->'.PHP_EOL;
			$html .= '<script type="text/javascript">'.PHP_EOL;
			$html .= 'window.cookieconsent_options = {"message":"'.$this->getDbField('message').'","dismiss":"'.$this->getDbField('dismiss').'","learnMore":"'.$this->getDbField('learnMore').'","link":"'.$this->getDbField('link').'","theme":"'.$this->getDbField('theme').'"};'.PHP_EOL;
			$html .= '</script>'.PHP_EOL;
	
			$html .= '<script type="text/javascript" src="' .$pluginPath. 'cookieconsent.latest.min.js"></script>'.PHP_EOL;
			$html .= '<!-- End Cookie Consent plugin -->'.PHP_EOL;
		}
		// For AdBlock Detect
		if($this->getDbField('adblock'))  $html .= '<style type="text/css">#advert-notice { position: fixed; top: 0; left:0; z-index: 10000; width: 100%; padding: 40px 60px 50px; margin: 0; background-color: #'.$this->getDbField('adblock_background_color').'; color: #fff; font-size: 17px; text-align: center; display: block;}</style>'.PHP_EOL;
		return $html;
	}
	// Show in Public theme footer	
	public function siteBodyEnd()
	{
		// Path plugin.
		$pluginPath = $this->htmlPath();
		
		$html = ''.PHP_EOL;			
		if($this->getDbField('adblock')) {
			$html .= '<script src="'.$pluginPath.'js/advert.js"></script>'.PHP_EOL;
			$html .= '<script>
if (document.getElementById("ads") == null) {

    document.write("<div id=\'advert-notice\'>'.Sanitize::htmlDecode($this->getDbField('adblock_message')).'</div>");

}
</script>'.PHP_EOL;
		}
		return $html;		
	}

}