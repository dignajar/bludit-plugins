<?php

class pluginFootnotes extends Plugin {

	public function siteHead(){

		$html  = '<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script><br>';
		$html  .= '<script src="/bl-plugins/footnotes/js/footnoted.js"></script>';
		return $html;

	}

}
