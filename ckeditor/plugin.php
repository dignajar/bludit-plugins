<?php
/*
	@Package: Bludit
	@Plugin: CKeditor + KCFinder
	@Version: 1.0.4
	@Author: Fred K.
	@Realised: 14 Juilly 2015	
	@Updated: 30 Juilly 2015
*/	
class pluginCKeditor extends Plugin {
	
	private $loadWhenController = array(
		'new-post',
		'new-page',
		'edit-post',
		'edit-page'
	);
	public function init()
	{	
		$this->dbFields = array(
			'plugin_markdown' => false,
			'plugin_toolbar' => false,
			'toolbar' => 'basic',
			'skin' => 'bludit'
			);
	}


	public function adminHead()
	{
		global $Site;
		global $layout;
		$PathPlugins = 'plugins/ckeditor/libs/ckeditor/';
		$config_url = $Site->url().$PathPlugins;

		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();
			$html .= '<script src="'.$config_url.'ckeditor.js"></script>'.PHP_EOL;
			$html .= '<script src="'.$config_url.'lang/'.$language.'.js"></script>'.PHP_EOL;		
		}

		return $html;
	}
	
	public function adminBodyEnd()
	{
		global $Site;
		global $layout;
		$PathPlugins = 'plugins/ckeditor/libs/kcfinder/';
		$config_url = $Site->url().$PathPlugins;
		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();
			$html .= '		
				<script>
	$("textarea").each(function(){  
		
		CKEDITOR.replace( this , {
			language: \''.$language.'\',
			fullPage: false,
			allowedContent: false,
			filebrowserBrowseUrl : \''.$config_url.'browse.php?type=files\',
			filebrowserImageBrowseUrl : \''.$config_url.'browse.php?type=images\',
			filebrowserFlashBrowseUrl : \''.$config_url.'browse.php?type=flash\',
			filebrowserUploadUrl : \''.$config_url.'upload.php?type=files\',
			filebrowserImageUploadUrl : \''.$config_url.'upload.php?type=images\',
			filebrowserFlashUploadUrl : \''.$config_url.'upload.php?type=flash\'
		});
			CKEDITOR.config.entities = false; // pour faciliter la lecture du code source, les accents ne sont pas transformés en entités HTML (inutiles avec le codage utf-8 des pages)
			    
			// Correction orthographique en français par défaut :
			CKEDITOR.config.language = \''.$language.'\';  
			CKEDITOR.config.wsc_lang = \''.$Site->locale().'\';  
			CKEDITOR.config.scayt_sLang = \''.$Site->locale().'\';
			// config.scayt_autoStartup = false;    // Ligne à activer s\'il faut supprimer la correction orthographique automatique, qui génère beaucoup d\'accès Internet et peut ralentir l\'édition
			CKEDITOR.config.extraPlugins = \''.($this->getDbField('plugin_markdown') == true ? 'markdown,' : '').($this->getDbField('plugin_toolbar') == true ? 'toolbar,' : '').'\';
			
			'.($this->getDbField('toolbar') == 'standard' ? 'CKEDITOR.config.toolbar = 
			[[\'Bold\', \'Italic\', \'Underline\', \'-\', \'NumberedList\', \'BulletedList\', \'-\', \'JustifyLeft\',\'JustifyCenter\',\'JustifyRight\',\'JustifyBlock\', \'-\', \'Link\', \'Unlink\', \'Image\', \'RemoveFormat\', \'-\', \'Table\', \'TextColor\', \'BGColor\', \'ShowBlocks\'], [\'Source\'], [\'Maximize\'],
			\'/\',
			[\'Styles\',\'Format\',\'Font\',\'FontSize\']];' : '').'
			
			'.($this->getDbField('toolbar') == 'basic' ? 'CKEDITOR.config.toolbar = 
			[[\'Bold\', \'Italic\', \'Underline\', \'-\', \'NumberedList\', \'BulletedList\', \'-\', \'JustifyLeft\',\'JustifyCenter\',\'JustifyRight\',\'JustifyBlock\', \'-\', \'Link\', \'Unlink\', \'Image\', \'RemoveFormat\'], [\'Source\'], [\'Maximize\'] ];' : '').'	
			
			CKEDITOR.config.skin = \''.$this->getDbField('skin').'\';
	
	});
		</script>'.PHP_EOL;
		}

		return $html;
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input name="plugin_markdown" type="checkbox" value="false" '.($this->getDbField('plugin_markdown')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="plugin_markdown">'.$Language->get('Activate Markdown Plugin').'</label>';
		$html .= '</div>';
		$html .= '<div>';
		$html .= '<input name="plugin_toolbar" type="checkbox" value="false" '.($this->getDbField('plugin_toolbar')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for=plugin_toolbar">'.$Language->get('Activate Toolbar Plugin').'</label>';
		$html .= '</div>';
		$html .= '<div>';
		$html .= '<label for="toolbar">'.$Language->get('Select toolbar');
        $html .= '<select name="toolbar" class="width-50">';
        $toolbarOptions = array('basic' => $Language->get('Basic'),'standard' => $Language->get('Standard'),'advanced' => $Language->get('Advanced'));
        foreach($toolbarOptions as $text=>$value)
            $html .= '<option value="'.$text.'"'.( ($this->getDbField('toolbar')===$text)?' selected="selected"':'').'>'.$value.'</option>';
        $html .= '</select>';
        $html .= '<div class="forms-desc">'.$Language->get('Advanced is the full package of CKEditor').'</div>';
		$html .= '</label>';
		$html .= '</div>';		

		$html .= '<div>';
		$html .= '<label for="skin">'.$Language->get('Select skin');
        $html .= '<select name="skin" class="width-50">';
        $skinOptions = array('flat'=>'Flat','moono'=>'Moono','minimalist'=>'Minimalist','icy_orange'=>'Icy Orange','moono-dark'=>'Moono Dark','bludit'=>'Bludit');
        foreach($skinOptions as $text=>$value)
            $html .= '<option value="'.$text.'"'.( ($this->getDbField('skin')===$text)?' selected="selected"':'').'>'.$value.'</option>';
        $html .= '</select>';
		$html .= '</label>';
		$html .= '</div>';	
				
		return $html;
	}
		
}
