<?php
class pluginMinify extends Plugin {
	
	public function init()
	{
		$this->dbFields = array(
			'compress_css'=>true,
			'compress_js'=>true,
			'info_comment'=>true,
			'remove_comments'=>true
		);
	}
	
	public function beforeSiteLoad()
	{
		# Add minify class
		require_once(dirname(__FILE__).'/minify.class.php');
		# Config plugin (For later)
		$compress_css 	= $this->getDbField('compress_css');
		$compress_js 	= $this->getDbField('compress_js');	
		$info_comment 	= $this->getDbField('info_comment');
		$remove_comments= $this->getDbField('remove_comments');
		
		# Declare class		
	    function html_compression_finish($html) {		    
		    return new HTML_Compression($html);
	    }
	    function html_compression_start() {
		    ob_start('html_compression_finish');
	    }
	    # Start compression
	    return html_compression_start();  
	}}
