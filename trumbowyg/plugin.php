<?php

class pluginTrumbowyg extends Plugin {

	private $loadWhenController = array(
		'new-post',
		'new-page',
		'edit-post',
		'edit-page'
	);

	public function adminHead()
	{
		global $Language, $Site, $layout;
		// Path plugin.
		$pluginPath = $this->htmlPath();
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();
			$html .= '<link href="'.$pluginPath.'trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			#$html .= '<link href="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			$html .= '<link href="'.$pluginPath.'trumbowyg/plugins/pagebreak/ui/trumbowyg.pagebreak.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;			
			// CSS fix for Bludit
			$html .= '<style>.trumbowyg-box {width: 80% !important; margin: 0 !important;}</style>';
		}

		return $html;
	}

	public function adminBodyEnd()
	{
		global $Language, $Site, $layout;
		// Path plugin.
		$pluginPath = $this->htmlPath();

		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();

			$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/trumbowyg.min.js"></script>';
			$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/plugins/colors/trumbowyg.colors.js"></script>'.PHP_EOL;
			$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/langs/'.$language.'.min.js"></script>';
			$html .= '<script>			
	  $("#jscontent").trumbowyg({
	    lang: \''.$language.'\',
	    autogrow: true,
	    resetCss: true,
	    fixedBtnPane: true,
	    btnsDef: {    
	        insertImage: {
	            dropdown: [\'insertImage\', \'upload\'],
	            ico: \'insertImage\'
	        }
	    },
	     btns: [\'viewHTML\',
	            \'|\', \'formatting\',
	            \'|\', \'btnGrp-design\',
	            \'|\', \'link\',
	            \'|\', \'insertImage\',
	            \'|\', \'btnGrp-justify\',
	            \'|\', \'btnGrp-lists\',
	            \'|\', \'foreColor\', \'backColor\',
	            \'|\', \'horizontalRule\',
	            \'|\', \'pagebreak\',
	            \'|\', \'fullscreen\']
	                       
	});
		   	</script>'.PHP_EOL;
		}

		return $html;	
	}
}
