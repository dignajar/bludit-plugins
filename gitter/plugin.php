<?php

class pluginGitter extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'room'=>'dignajar/bludit',
			'activationElement'=>true,
			'targetElement'=>''
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label for="jsroom">'.$Language->get('Room').'</label>';
		$html .= '<input id="jsroom" type="text" name="room" value="'.$this->getDbField('room').'">';
		$html .= '</div>';

/*
		$html .= '<div>';
		$html .= '<label for="jsactivationElement">'.$Language->get('Activation Element').'</label>';
		$html .= '<input type="checkbox" id="activationElement" name="activationElement" value="false" '.($this->getDbField('activationElement')?'checked':'').' />';
		$html .= '<div class="tip">'.$Language->get('optionnel').'</div>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label for="jstargetElement">'.$Language->get('Target Element').'</label>';
		$html .= '<input id="jstargetElement" type="text" name="targetElement" value="'.$this->getDbField('targetElement').'">';
		$html .= '<div class="tip">'.$Language->get('optionnel').'</div>';
		$html .= '</div>';
*/
		
		return $html;
	}

	public function siteBodyEnd()
	{
		$pluginPath = $this->htmlPath();
		$html  = '';
		if ($this->getDbField('room') !=='') {
			$html  = PHP_EOL.'<!-- Gitter -->'.PHP_EOL;	
			$html .= '
		<script>
		  ((window.gitter = {}).chat = {}).options = {
		    room: "' .$this->getDbField('room'). '"	    
		  };
		</script>
		<script src="' .$pluginPath. 'sidecar.v1.js" async defer></script>'.PHP_EOL;
		}
		
		return $html;	
	}
}