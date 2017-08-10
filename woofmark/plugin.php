<?php

class pluginWoofmark extends Plugin {

	private $loadOnController = array(
		'new-post',
		'new-page',
		'edit-post',
		'edit-page'
	);

	public function adminHead()
	{
		global $layout;
		
		if (in_array($layout['controller'], $this->loadOnController)) {
			$html = '';
			
			// Plugin path
			$pluginPath = $this->htmlPath();

			// woofmark css
			$html .= '<link rel="stylesheet" type="text/css" href="'.$pluginPath.'css/woofmark.min.css">';
			$html .= '<link rel="stylesheet" type="text/css" href="'.$pluginPath.'css/bludit.css">';

			return $html;
		}

		return false;
	}

	public function adminBodyEnd()
	{
		global $layout;
		
		if (in_array($layout['controller'], $this->loadOnController)) {
			$html = '';
			
			// Plugin path
			$pluginPath = $this->htmlPath();
			
			// Load woofmark
			$html .= '<script src="'.$pluginPath.'js/domador.min.js" ></script>';
			$html .= '<script src="'.$pluginPath.'js/megamark.min.js" ></script>';
			$html .= '<script src="'.$pluginPath.'js/woofmark.min.js" ></script>';
			$html .= '<script src="'.$pluginPath.'js/load.js" ></script>';
			
			return $html;
		}

		return false;
	}
}