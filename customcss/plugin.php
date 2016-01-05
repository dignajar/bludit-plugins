<?php

class pluginCustomCSS extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'text'=>''
		);
	}

	public function form()
	{
		global $Language;

		$html = '<div>';
		$html .= '<label>'.$Language->get('Custom CSS').'</label>';
		$html .= '<textarea name="text" id="jstext">'.$this->getDbField('text').'</textarea>';
		$html .= '</div>';

		return $html;
	}

	public function siteHead(){

		$html  = '<style>';
		$html  .= ($this->getDbField('text'));
		$html  .= '</style>';
		return $html;

	}

}
