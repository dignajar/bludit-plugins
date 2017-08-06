<?php

class pluginFancyBox extends Plugin {
	
	public function init()
	{
		$this->dbFields = array(
			'id'=>'',
			'options'=>'padding: 0',
			'jquery'=>0
		);
	}
	
	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label><b>Image Identifier</b></label>';
		$html .= '<span>This is best left empty unless fancyBox is applied to every images for the theme that you are using.</span><br />';
		$html .= '<input name="id" id="jslabel" type="text" value="'.$this->getDbField('id').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label><b>Options</b></label>';
		$html .= '<span>Please refer to the <a href="http://fancyapps.com/fancybox/#docs">documentation here</a> for available options. Options are comma separated.</span><br />';
		$html .= '<input name="options" id="jsoptions" type="text" value="'.$this->getDbField('options').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<input type="hidden" name="jquery" value="0">';
		$html .= '<input name="jquery" id="jsjquery" type="checkbox" value="1" '.($this->getDbField('jquery')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsjquery">Enable jQuery (for themes without jQuery)</label>';
		$html .= '</div>';

		return $html;
	}
	
	public function siteHead(){

		$html  = '<link  href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/css/jquery.fancybox.min.css" rel="stylesheet">';
		return $html;

    }

 	public function siteBodyEnd()
 	{
 		global $Site;
 		global $layout;
		
		if($this->getDbField('jquery')){
			$html  = '<script src="'.HTML_PATH_ADMIN_THEME_JS.'jquery.min.js"></script>';
			$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/js/jquery.fancybox.min.js"></script>';
		} else {
			$html  = '<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.7/js/jquery.fancybox.min.js"></script>';
		}
 		$html  .= '<script>
						$(document).ready(function () {
							$("'.$this->getDbField('id').' img").on("click", function () {
								$.fancybox($(this).attr("src"), {
									'.$this->getDbField('options').'
								});
							});
						});
				   </script>';
 		return $html;
	}

}
