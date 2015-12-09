<?php
/**
 *  SnowFlakes
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Frédéric K.
 *  @copyright 2015 Frédéric K.
 *	@version 0.1
 *  @release 2015-12-09
 *  @update 2015-12-09
 *
 */
class pluginSnowFlakes extends Plugin {
	private $loadWhenController = array(
		'configure-plugin'
	);		
	// Plugin datas
	public function init()
	{
		$this->dbFields = array(
			'enable' => true,
			'snowmax' => '35',
			'snowcolor' => '"#aaaacc","#ddddff","#ccccdd","#f3f3f3","#f0ffff"',
			'snowtype' => 'Times',
			'snowletter' => '❄',
			'sinkspeed' => '0.7',
			'snowmaxsize' => '30',
			'snowminsize' => '8',
			'snowingzone' => '1'
			);
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
			
		$html .= '<div>';
		$html .= '<label for="jssnowmax">'.$Language->get('snowmax').'</label>';
		$html .= '<input id="jssnowmax" type="number" name="snowmax" value="'.$this->getDbField('snowmax').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="jssnowcolor">'.$Language->get('snowcolor').'</label>';
		$html .= '<input id="jssnowcolor" type="text" name="snowcolor" value="'.$this->getDbField('snowcolor').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="jssnowtype">'.$Language->get('snowtype').'</label>';
		$html .= '<input id="jssnowtype" type="text" name="snowtype" value="'.$this->getDbField('snowtype').'">';
		$html .= '</div>';	
					
		$html .= '<div>';
		$html .= '<label for="jssnowletter">'.$Language->get('snowletter').'</label>';
		$html .= '<input id="jssnowletter" type="text" name="snowletter" value="'.$this->getDbField('snowletter').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="jssinkspeed">'.$Language->get('sinkspeed').'</label>';
		$html .= '<input id="jssinkspeed" type="text" name="sinkspeed" value="'.$this->getDbField('sinkspeed').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="jssnowmaxsize">'.$Language->get('snowmaxsize').'</label>';
		$html .= '<input id="jssnowmaxsize" type="number" name="snowmaxsize" value="'.$this->getDbField('snowmaxsize').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="jssnowminsize">'.$Language->get('snowminsize').'</label>';
		$html .= '<input id="jssnowminsize" type="number" name="snowminsize" value="'.$this->getDbField('snowminsize').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label for="jssnowingzone">'.$Language->get('snowingzone').'</label>';
		$html .= '<input id="jssnowingzone" type="number" name="snowingzone" value="'.$this->getDbField('snowingzone').'">';
		$html .= '</div>';
												
		return $html;
	}
	// Show in Public theme footer	
	public function siteBodyEnd()
	{
		// Path plugin.
		$pluginPath = $this->htmlPath();
		
		$html = ''.PHP_EOL;			
		if($this->getDbField('enable')) {
			$html .= '<!--html-compression no compression-->
<script>
// Set the number of snowflakes (more than 30 - 40 not recommended)
var snowmax='.$this->getDbField('snowmax').'
// Set the colors for the snow. Add as many colors as you like ("#aaaacc","#ddddff","#ccccdd","#f3f3f3","#f0ffff")
var snowcolor=new Array('.Sanitize::htmlDecode( $this->getDbField('snowcolor') ).')
// Set the fonts, that create the snowflakes. Add as many fonts as you like("Times","Arial","Times","Verdana")
var snowtype=new Array("'.$this->getDbField('snowtype').'")
// Set the letter that creates your snowflake (recommended: * )
var snowletter="'.Sanitize::htmlDecode( $this->getDbField('snowletter') ).'"
// Set the speed of sinking (recommended values range from 0.3 to 2)
var sinkspeed='.$this->getDbField('sinkspeed').'
// Set the maximum-size of your snowflakes
var snowmaxsize='.$this->getDbField('snowmaxsize').'
// Set the minimal-size of your snowflakes
var snowminsize='.$this->getDbField('snowminsize').'
// Set the snowing-zone
// Set 1 for all-over-snowing, set 2 for left-side-snowing
// Set 3 for center-snowing, set 4 for right-side-snowing
var snowingzone='.$this->getDbField('snowingzone').'
</script>
<script src="'.$pluginPath.'snowflakes.js"></script>'.PHP_EOL;
		}
		return $html;		
	}

}