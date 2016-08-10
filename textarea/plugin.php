<?php

class pluginTextarea extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'label'=>'Label',
			'text'=>''
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label>'.$Language->get('Plugin label').'</label>';
		$html .= '<input name="label" id="jslabel" type="text" value="'.$this->getDbField('label').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('Text').'</label>';
		$html .= '<textarea name="text" id="jstext">'.$this->getDbField('text').'</textarea>';
		$html .= '</div>';

		return $html;
	}

	public function siteSidebar()
	{

	$about = $this->getDbField('text');
	$about = htmlspecialchars_decode($about);

		$html  = '<div class="plugin plugin-about">';
		$html .= '<h2>'.$this->getDbField('label').'</h2>';
		$html .= '<div class="plugin-content">';
		$html .= nl2br($about);
 		$html .= '</div>';
 		$html .= '</div>';

		return $html;
	}
}
