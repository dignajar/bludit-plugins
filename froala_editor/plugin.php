<?php
/*
	@Package: Bludit
	@Plugin: Froala Editor
	@Version: 1.2.7c
	@Author: Fred K.
	@Realised: 14 Juilly 2015	
	@Updated: 30 Juilly 2015
*/	
class pluginFroala_Editor extends Plugin {
	
	private $loadWhenController = array(
		'new-post',
		'new-page',
		'edit-post',
		'edit-page'
	);

	public function adminHead()
	{
		global $Site;
		global $layout;
		
		$PathPlugins = PATH_PLUGINS. '/froala_editor/';
		$config_url = $Site->url();

		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$html .= '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">'.PHP_EOL;
			$html .= '<!-- Include Editor style -->'.PHP_EOL;
			$html .= '<link href="'.$config_url. 'plugins/froala_editor/css/froala_editor.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			$html .= '<link href="'.$config_url. 'plugins/froala_editor/css/froala_style.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;		
		}

		return $html;
	}

	public function adminBodyEnd()
	{
		global $Site;
		global $layout;
		
		$PathPlugins = PATH_PLUGINS. '/froala_editor/';
		$config_url = $Site->url();
				
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/froala_editor.min.js"></script>'.PHP_EOL;
			$html .= '<!-- Include the language file. -->'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/langs/'.$language.'.js"></script>'.PHP_EOL;
			$html .= '<!-- Include IE8 JS. -->'.PHP_EOL;
			$html .= '<!--[if lt IE 9]>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/froala_editor_ie8.min.js"></script>'.PHP_EOL;
			$html .= '<![endif]-->'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/tables.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/lists.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/colors.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/media_manager.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/font_family.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/font_size.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/block_styles.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/video.min.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url. 'plugins/froala_editor/js/plugins/fullscreen.min.js"></script>'.PHP_EOL;
			$html .= '			<!-- Init. -->		
				<script>		
	  $(function() {
	      $("textarea").editable({
			  language: \''.$language.'\', 
			  inlineMode: false,	
			  minHeight: 300, 

		  	  // Add the upload file button in the toolbar buttons list.
		  	  buttons: ["bold","italic","underline","strikeThrough","fontSize","fontFamily","color","sep","formatBlock","blockStyle","align","insertOrderedList","insertUnorderedList","outdent","indent","sep","createLink","insertImage","insertVideo","insertHorizontalRule","undo","redo","html","uploadFile","fullscreen"],	      
	
		  	  // Set the image upload URL.
		  	  imageUploadURL: "'.PATH_PLUGINS. 'froala_editor/upload_image.php",
		  	  // Set the file upload URL.
		  	  fileUploadURL: "'.PATH_PLUGINS. 'froala_editor/upload_file.php",
	
	          // CORS. Only if needed.
	          crossDomain: false,
	
	          // Set the image error callback.
	          imageErrorCallback: function (data) {
	              // Bad link.
	              if (data.errorCode == 1) {
	                console.log ("bad link")
	              }
	
	              // No link in upload response.
	              else if (data.errorCode == 2) {
	                console.log ("bad response")
	              }
	
	              // Error during file upload.
	              else if (data.errorCode == 3) {
	                console.log ("upload error")
	              }
	          }
	      })
	  });
		   	</script>'.PHP_EOL;
		}

		return $html;
	}	
}