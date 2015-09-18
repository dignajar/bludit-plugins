<?php
/**
 *  Contact
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Frédéric K.
 *  @copyright 2015 Frédéric K.
 *  @release 2015-08-10
 *  @update 2015-08-11
 *
 */
class pluginAnimateBg extends Plugin {
	
	# DONNÉES DU PLUG-IN
	public function init()
	{
		$this->dbFields = array(
			'modele' => 'animate1'
			);
	}	
	# AFFICHE LA FEUILLE DE STYLE ET LE JAVASCRIPT UNIQUEMENT SUR LA PAGE DEMANDÉE	
	public function siteHead()	
	{	
		return  '<style type="text/css">canvas{opacity:1;z-index:-1;position:fixed;top:0;left:0;right:0;bottom:0}</style>';
	}
		
	public function siteBodyEnd()	
	{	
		$pluginPath = $this->htmlPath();
		$html = '<script src="' .$pluginPath. 'animations/' .$this->getDbField('modele'). '.js"></script>';

		return $html;
	}
    /**
     * Add the contact form after content page
     *
     */		
	public function siteBodyBegin()
	{
		return '<canvas id="canvas"></canvas>';
	}   
/*
	public function getAnimationList()
	{
		global $Language
		$pluginPath = $this->htmlPath(). 'animations/';
		$files = glob($pluginPath.'*.js');
	
		$tmp = array();
	
		foreach($files as $file=>$value)
		{
			$animes = basename($file, '.js');
			$animateOptions = array($animes => $Language->get($animes));
			$tmp = $animateOptions;
		}
	
		return $tmp;
	}
*/
	// Backend configuration page
	public function form()
	{
		global $Language, $Site;
		$pluginPath = $this->htmlPath();
		
		$html  = '<div>';
		$html .= '<label for="modele">'.$Language->get('Choose animation');
        $html .= '<select name="modele" class="width-50">';
		#$animateOptions = pluginAnimateBg::getAnimationList();
		$animateOptions = array( 'animate1'=> $Language->get('Triangles, squares and crosses'), 'animate2'=> $Language->get('Floating dots'), 'animate3'=> $Language->get('Multicolored Hexagons'), 'animate4'=> $Language->get('Discrete Bubbles'), 'animate5'=> $Language->get('Snowflake') );
		foreach($animateOptions as $text=>$value) {
			$html .= '<option value="'.$text.'"'.( ($this->getDbField('modele')===$text)?' selected="selected"':'').'>'.$value.'</option>';
		}        
        $html .= '</select>';
		$html .= '</label>';
		$html .= '</div>';	
							
		return $html;
	}
	
}