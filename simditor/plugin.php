<?php
/*
	@Package: Bludit
	@Plugin: Simditor http://simditor.tower.im
	@Version: 2.3.6
	@Author: Frédéric K.
	@Realised: 14 Juilly 2015	
	@Updated: 31 Juilly 2016
*/	
class pluginSimditor extends Plugin {

	private $loadWhenController = array(
		'new-post',
		'new-page',
		'edit-post',
		'edit-page'
	);
	
	public function init()
	{
		$this->dbFields = array(
			'markdown'=>1 
			);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input type="hidden" name="markdown" value="0">';
		$html .= '<input name="markdown" id="jsmarkdown" type="checkbox" value="1" '.($this->getDbField('markdown')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsmarkdown">'.$Language->get('Activate markdown').'</label>';
		$html .= '</div>';

		return $html;
	}
	
	public function adminHead()
	{
		global $Site, $layout;		
		$PathPlugins = HTML_PATH_PLUGINS. 'simditor' .DS. 'simditor' .DS;
		
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$html .= '<link href="'.$PathPlugins. 'css/simditor.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			$html .= '<link href="'.$PathPlugins. 'css/simditor-markdown.css" rel="stylesheet" type="text/css" />'.PHP_EOL;		
		}

		return $html;
	}
	
	public function adminBodyEnd()
	{
		global $Site, $layout;
		
		$PathPlugins = HTML_PATH_PLUGINS. 'simditor' .DS. 'simditor' .DS;
		$langfile 	= $PathPlugins. 'js/langs/'.$Site->locale().'.js';
		
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{	
			$html .= '<script src="'.$PathPlugins. 'js/module.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$PathPlugins. 'js/hotkeys.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$PathPlugins. 'js/simditor.js"></script>'.PHP_EOL;
	        if ($this->getDbField('markdown') == true) {
	        $html .= '<script src="'.$PathPlugins. 'js/to-markdown.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$PathPlugins. 'js/marked.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$PathPlugins. 'js/simditor-markdown.js"></script>'.PHP_EOL;
	        }
			$html .= '<!-- Include the language file. -->'.PHP_EOL;
			$html .= (!file_exists($langfile) ? '<script src="'.$langfile.'"></script>' : '<script src="'.$PathPlugins. 'js/langs/en_US.js"></script>').PHP_EOL;
			$html .= '			<!-- Init. -->		
				<script>
	    $(function() {
		  Simditor.locale = \''.(!file_exists($langfile) ? $Site->locale() : 'en_US').'\';  
	      var editor = new Simditor({
	        textarea: $(\'textarea[name="content"]\'),
	        ' .($this->getDbField('markdown') == 1 ? 'markdown: true' : 'markdown: false'). ',
	        locale: \''.(!file_exists($langfile) ? $Site->locale() : 'fr_FR').'\',
	        toolbar: [\'title\', \'bold\', \'italic\', \'underline\', \'strikethrough\', \'color\', \'|\', \'ol\', \'ul\', \'blockquote\', \'code\', \'table\', \'|\', \'link\', \'image\', \'hr\', \'|\', \'indent\', \'outdent\', \'alignment\' ' .($this->getDbField('markdown') == 1 ? ', \'|\', \'markdown\'' : ''). ']
	      });
	    });
		   	</script>'.PHP_EOL;
		}

		return $html;
	}
		
}