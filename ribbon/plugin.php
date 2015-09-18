<?php
	/*
	@Package: Bludit
	@Plugin: Ribbon
	@Version: 1.0.1
	@Author: Fred K.
	@Realised: 27 Juilly 2015	
	@Updated: 30 Juilly 2015
*/
class pluginRibbon extends Plugin {
	
	private $loadWhenController = array(
		'configure-plugin'
	);	
	
	public function init()
	{	
		$this->dbFields = array(
		    'type' => 'ribbon', 
		    'title' => 'Fork me on Github',  
		    'url' => 'https://github.com',
		    'display' => 'right',
		    'display2' => 'top',    
		    'color' => 'EB593C', 
		    'linkcolor' => 'FFFFFF'	
			);
	}


	public function adminHead()
	{
		global $layout;
		$pluginPath = $this->htmlPath();
		
		$html  = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$html .= '<script src="' .$pluginPath. 'libs/jscolor/jscolor.js"></script>'.PHP_EOL;		
		}

		return $html;
	}
	
	public function siteHead()
	{
		$html = ''.PHP_EOL;
		
	    if ($this->getDbField('type') == 'ribbon') 
	     { 
	      $html .= '<style type="text/css" media="screen">
	      .ribbon{ background-color: #' .$this->getDbField('color'). '; z-index:1000;padding:3px;position:fixed;top:2em;' .$this->getDbField('display'). ':-3em; -moz-transform:rotate(' .($this->getDbField('display') =='left'? '-45':'45'). 'deg); -webkit-transform:rotate(' .($this->getDbField('display')=='left' ? '-45':'45'). 'deg); -moz-box-shadow:0 0 1em #888; -webkit-box-shadow:0 0 1em #888} 
	      .ribbon a{ border:1px dotted rgba(255,255,255,1); color:#' .$this->getDbField('linkcolor'). '; display:block; font:normal 81.25% "Helvetiva Neue",Helvetica,Arial,sans-serif; margin:0.05em 0 0.075em 0; padding:0.5em 3.5em; text-align:center; text-decoration:none;text-shadow:0 0 0.5em #333}
	      .ribbon a:hover{ opacity: 0.5}
	      </style>'.PHP_EOL;
	    } else { 
	      $html .= '<style type="text/css" media="screen">
	        .stickybar{position:fixed;left:0;right:0;top:0;font-size:14px; font-weight:400; height:35px; line-height:35px; overflow:visible; text-align:center; width:100%; z-index:1000; border-bottom-width:3px; border-bottom-style:solid; font-family:Georgia,Times New Roman,Times,serif; color:#fff; border-bottom-color:#fff; margin:0; padding:0; background-color: #' .$this->getDbField('color'). ';-webkit-border-bottom-right-radius:5px;-webkit-border-bottom-left-radius:5px;-moz-border-radius-bottomright:5px;-moz-border-radius-bottomleft:5px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;}
	         body {margin-top:35px !important}
	        .stickybar a, .stickybar a:link, .stickybar a:visited, .stickybar a:hover{color:#' .$this->getDbField('linkcolor'). ';font-size:14px; text-decoration:none; border:none;  padding:0}
	        .stickybar a:hover{text-decoration:underline}
	        .stickybar a{color:#fff; display:block;padding-bottom: 8px; text-align:center; text-decoration:none;text-shadow:0 0 0.1em #000}
	        .stickybar a:hover{ opacity: 0.8}
	        </style>'.PHP_EOL;
	     } 
	     
	     return $html;   
	}

	// Load js plugin in public theme
	public function siteBodyEnd()
	{ 		
			$html  = '<div class="' .$this->getDbField('type'). '">'.PHP_EOL;
            $html .= '<a href="' .$this->getDbField('url'). '">' .$this->getDbField('title'). '</a>'.PHP_EOL;
            $html .= '</div>'.PHP_EOL;  
			
			return $html;   
	}
	
	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label for="type">'.$Language->get('Display Type');
        $html .= '<select name="type" class="width-20">';
        $typeOptions = array( 'ribbon'=> $Language->get('Ribbon'), 'stickybar'=> $Language->get('Stickybar') );
        foreach($typeOptions as $text=>$value)
            $html .= '<option value="'.$text.'"'.( ($this->getDbField('type')===$text)?' selected="selected"':'').'>'.$value.'</option>';
        $html .= '</select>';
        $html .= '<div class="forms-desc">'.$Language->get('If stickybar is selected you can insert more text.').'</div>';
		$html .= '</label>';
		$html .= '</div>';	

        $html .= '<div class="width-50">';
		$html .= '<label for="title">'.$Language->get('Title');
		$html .= '<input type="text" name="title" value="'.$this->getDbField('title').'" required/>';
		$html .= '</label>';
		$html .= '</div>';		

        $html .= '<div>';
		$html .= '<label for="url">'.$Language->get('Link');
		$html .= '<input class="width-40" type="url" name="url" value="'.$this->getDbField('url').'" required/>';
		$html .= '</label>';
		$html .= '</div>';	

        $html .= '<div class="width-20">';
		$html .= '<label for="color">'.$Language->get('Background color');
		$html .= '<input class="color" type="text" name="color" value="'.$this->getDbField('color').'" required/>';
		$html .= '</label>';
		$html .= '</div>';
		
        $html .= '<div class="width-20">';
		$html .= '<label for="linkcolor">'.$Language->get('Link color');
		$html .= '<input class="color" type="text" name="linkcolor" value="'.$this->getDbField('linkcolor').'" required/>';
		$html .= '</label>';
		$html .= '</div>';
				
		if ($this->getDbField('type') == 'ribbon'){		
			$html .= '<div>';
			$html .= '<label for="display">'.$Language->get('Horizontal orientation');
	        $html .= '<select name="display" class="width-20">';
	        $displayOptions = array( 'left'=> $Language->get('Left'), 'right'=> $Language->get('Right') );
	        foreach($displayOptions as $text=>$value)
	            $html .= '<option value="'.$text.'"'.( ($this->getDbField('display')===$text)?' selected="selected"':'').'>'.$value.'</option>';
	        $html .= '</select>';
			$html .= '</label>';
			$html .= '</div>';	
		}		
		return $html;
	}
		
}
