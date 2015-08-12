<?php

class pluginTrumbowyg extends Plugin {

	private $loadWhenController = array(
		'new-post',
		'new-page',
		'edit-post',
		'edit-page'
	);

	public function onAdminHead()
	{
		global $Language;
		global $Site;
		global $layout;

		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();
			$html .= '<link href="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			#$html .= '<link href="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;
			$html .= '<link href="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/plugins/pagebreak/ui/trumbowyg.pagebreak.min.css" rel="stylesheet" type="text/css" />'.PHP_EOL;			
			// CSS fix for Bludit
			$html .= '<style>.trumbowyg-box {width: 80% !important; margin: 0 !important;}</style>';
		}

		return $html;
	}

	public function onAdminBodyEnd()
	{
		global $Language;
		global $Site;
		global $layout;

		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();

			$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/trumbowyg.min.js"></script>';
			$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/plugins/colors/trumbowyg.colors.js"></script>'.PHP_EOL;
			#$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/plugins/pagebreak/trumbowyg.pagebreak.js"></script>'.PHP_EOL;
			$html .= '<script src="'.HTML_PATH_PLUGINS.'trumbowyg/trumbowyg/langs/'.$language.'.min.js"></script>';
			$html .= '<script>
	/* Upload plugin */			
	(function(a){b();a.extend(true,a.trumbowyg,{langs:{en:{upload:"Upload",file:"File",uploadError:"Error"},sk:{upload:"Nahrať",file:"Súbor",uploadError:"Chyba"},fr:{upload:"Envoi",file:"Fichier",uploadError:"Erreur"},cs:{upload:"Nahrát obrázek",file:"Soubor",uploadError:"Chyba"}},upload:{serverPath:"'.PATH_PLUGINS.'trumbowyg/upload.php"},opts:{btnsDef:{upload:{func:function(g,e){var d,f=e.o.prefix;var c=e.openModalInsert(e.lang.upload,{file:{type:"file",required:true},alt:{label:"description"}},function(){var h=new FormData();h.append("fileToUpload",d);if(a("."+f+"progress",c).length===0){a("."+f+"modal-title",c).after(a("<div/>",{"class":f+"progress"}).append(a("<div/>",{"class":f+"progress-bar"})))}a.ajax({url:a.trumbowyg.upload.serverPath,type:"POST",data:h,cache:false,dataType:"json",processData:false,contentType:false,progressUpload:function(i){a("."+f+"progress-bar").stop().animate({width:Math.round(i.loaded*100/i.total)+"%"},200)},success:function(i){if(i.message=="uploadSuccess"){e.execCmd("insertImage",i.file);setTimeout(function(){e.closeModal()},250)}else{e.addErrorOnModalField(a("input[type=file]",c),e.lang[i.message])}},error:function(){e.addErrorOnModalField(a("input[type=file]",c),e.lang.uploadError)}})});a("input[type=file]").on("change",function(i){try{d=i.target.files[0]}catch(h){d=i.target.value}})},ico:"insertImage"}}}});function b(){if(!a.trumbowyg&&!a.trumbowyg.addedXhrProgressEvent){var c=a.ajaxSettings.xhr;a.ajaxSetup({xhr:function(){var e=c(),d=this;if(e&&typeof e.upload=="object"&&d.progressUpload!==undefined){e.upload.addEventListener("progress",function(f){d.progressUpload(f)},false)}return e}});a.trumbowyg.addedXhrProgressEvent=true}}})(jQuery);
			
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
