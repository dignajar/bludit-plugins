<?php
/*
	@Package: Bludit
	@Plugin: Simditor http://simditor.tower.im
	@Version: 2.2.1
	@Author: Fred K.
	@Realised: 14 Juilly 2015	
	@Updated: 31 Juilly 2015
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
			'markdown'=>true 
			);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input name="markdown" id="jsmarkdown" type="checkbox" value="true" '.($this->getDbField('markdown')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsmarkdown">'.$Language->get('Activate markdown').'</label>';
		$html .= '</div>';

		return $html;
	}
	
	public function adminHead()
	{
		global $Site;
		global $layout;
		
		$PathPlugins = 'plugins/simditor/simditor/';
		$config_url = $Site->url();
		
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$html .= '<link href="'.$config_url.$PathPlugins. 'css/simditor.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			$html .= '<link href="'.$config_url.$PathPlugins. 'css/simditor-markdown.css" rel="stylesheet" type="text/css" />'.PHP_EOL;		
		}

		return $html;
	}
	
	public function adminBodyEnd()
	{
		global $Site;
		global $layout;
		
		$PathPlugins= 'plugins/simditor/simditor/';
		$config_url = $Site->url();
		$langfile 	= $config_url.$PathPlugins. 'js/langs/'.$Site->locale().'.js';
		
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{	
			$html .= '<script src="'.$config_url.$PathPlugins. 'js/module.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$config_url.$PathPlugins. 'js/hotkeys.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$config_url.$PathPlugins. 'js/simditor.js"></script>'.PHP_EOL;
	        if ($this->getDbField('markdown') == true) {
	        $html .= '<script src="'.$config_url.$PathPlugins. 'js/to-markdown.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$config_url.$PathPlugins. 'js/marked.js"></script>'.PHP_EOL;
	        $html .= '<script src="'.$config_url.$PathPlugins. 'js/simditor-markdown.js"></script>'.PHP_EOL;
	        }
			$html .= '<!-- Include the language file. -->'.PHP_EOL;
			$html .= (!file_exists($langfile) ? '<script src="'.$langfile.'"></script>' : '<script src="'.$config_url.$PathPlugins. 'js/langs/en_US.js"></script>').PHP_EOL;
			$html .= '			<!-- Init. -->		
				<script>
	    $(function() {
		  Simditor.locale = \''.(!file_exists($langfile) ? $Site->locale() : 'en_US').'\';  
	      var editor = new Simditor({
	        textarea: $(\'textarea[name="content"]\'),
	        ' .($this->getDbField('markdown') == true ? 'markdown: true' : 'markdown: false'). ',
	        locale: \''.(!file_exists($langfile) ? $Site->locale() : 'fr_FR').'\',
	        toolbar: [\'title\', \'bold\', \'italic\', \'underline\', \'strikethrough\', \'color\', \'|\', \'ol\', \'ul\', \'blockquote\', \'code\', \'table\', \'|\', \'link\', \'image\', \'hr\', \'|\', \'indent\', \'outdent\', \'alignment\' ' .($this->getDbField('markdown') == true ? ', \'|\', \'markdown\'' : ''). ']
	      });
	    });
		   	</script>'.PHP_EOL;
		}

		return $html;
	}
		
}