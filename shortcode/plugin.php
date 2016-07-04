<?php
/**
 *  Shortcode API
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Frédéric K.
 *  @copyright 2015 Frédéric K, Bludit & Sergey Romanenko for the shortcode class.
 *	@version 0.4
 *  @release 2015-11-19
 *  @update 2015-12-07
 *
 */
class pluginShorcode extends Plugin {
	
	private $loadWhenController = array(
		'configure-plugin'
	);
	
	# PARSE SHORTCODES IN THEME (DON'T WORK FOR THE MOMENT!)
	private function addons_shortcode_themes() {
		global $Site;
		ob_start();
		$template = PATH_THEMES.$Site->theme().DS.'index.php';
		Shortcode::parse( $template );
		$template = ob_get_contents();
		ob_end_clean();	
	}
	
	# ADD EDITOR IN PLUGIN CONFIGURATION
	public function adminHead()
	{
		global $layout, $Site;

		$html = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{
			$language = $Site->shortLanguage();
			// Path plugin.
			$pluginPath = $this->htmlPath(). 'edit_area' .DS;			
			// SyntaxHighlighter
			$html .= '<script src="'.$pluginPath.'edit_area_full.js"></script>';
			$html .= '<style type="text/css">position: absolute;</style>';
			$html .= '<script>
	editAreaLoader.init({
			id: "jsshortcodes"	
			,start_highlight: true	
			,font_size: "8"
			,font_family: "verdana, monospace"
			,allow_resize: "n"
			,allow_toggle: true
			,language: "'.$language.'"
			,syntax: "php"	
			,toolbar: "charmap, |, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight, |, fullscreen, help"
			,plugins: "charmap"
			,charmap_default: "arrows"
				
		});				
			</script>';
		}

		return $html;
	}
		
	# PARSE SHORTCODES BEFORE BLUDIT LOAD
	public function beforeSiteLoad()
	{
		global $Page, $Post, $Url, $posts; // Better with instance() no?
					
		# Add Shortcode class
		require_once(dirname(__FILE__). DS .'Shortcode.class.php');
				
		# Add great extras shorcode!
		include_once(dirname(__FILE__). DS .'shortcodes.php');		

		# include shortcodes in themes		
		pluginShorcode::addons_shortcode_themes(); // FEATURES
								     
		// Filter then build it!
		switch($Url->whereAmI())
		{
			case 'post':
				$content = $Post->content();				
		        // Parse Shortcodes
		        $content = Shortcode::parse( $content );
		        $Post->setField('content', $content, true);	
				break;
			case 'page':
				$content = $Page->content();		
		        // Parse Shortcodes
		        $content = Shortcode::parse( $content );
		        $Page->setField('content', $content, true);
				break;
				
			default:
				// Homepage (Thx Diego for this tip)			
				foreach($posts as $key=>$Post)
				{
					// Full content parsed by Parsedown
					$content = $Post->content();
			
					// Parse with Shortcode
					$content = Shortcode::parse( $content );
			
					// Set full content
					$Post->setField('content', $content, true);
			
					// Set page break content
					$explode = explode(PAGE_BREAK, $content);
					$Post->setField('breakContent', $explode[0], true);
					$Post->setField('readMore', !empty($explode[1]), true);
				}  
		}
	     
	}

	# WRITE SHORTCODE FILE
	public function write_shortcode()
	{
		global $Language;
		# Shortcode file Path
		$shortcodeFile = dirname(__FILE__). DS .'shortcodes.php';	
		$shortcodes = isset($_POST['shortcodes']) ? $_POST['shortcodes'] : '';
		
		# Write in file    	
		file_put_contents($shortcodeFile, $shortcodes);       
		       
		# Write finish :)
		Alert::set($Language->get("Shortcodes updated!"));
		Redirect::page('admin', 'configure-plugin/pluginShorcode');	
	}
		
	# ADD SHORCODE IN PLUGIN CONFIGURATION
	public function form()
	{
		global $Language;
		
		# Shortcode file Path
		$shortcodeFile = dirname(__FILE__). DS .'shortcodes.php';
		# Load shortcode file
		$content = file_get_contents($shortcodeFile);
		
		$html  = '<div class="uk-button-group">';
		$html .= '<button class="uk-button uk-button-success" type="submit" name="add"><i class="uk-icon-pencil"></i> ' .$Language->get("edit-shorcodes"). '</button> <a class="uk-button uk-button-primary" href="#help" data-uk-modal=""><i class="uk-icon-info-circle"></i> ' .$Language->get("Help"). '</a>';
		$html .= '</div>';		
		$html .= '<div style="display: none; overflow-y: auto;" aria-hidden="true" id="help" class="uk-modal">';
		$html .= '<div class="uk-modal-dialog">';
		$html .= '<a href="" class="uk-modal-close uk-close"></a>';
		$html .= '<p>' .$Language->get("This page is for edit/add shortcodes. Don't forget to share your best shorctcodes with Bludit community!"). '</p>';
		$html .= '<p>' .$Language->get("You can directly edit the file that is located:"). '</p>';
		$html .= '<code>' .$shortcodeFile. '</code>';
		$html .= '</div>';
		$html .= '</div><br />';
		$html .= '<div>';
		$html .= '<textarea name="shortcodes" id="jsshortcodes" rows="50" class="uk-width-1-1">' .htmlspecialchars($content). '</textarea>';	
		$html .= '</div>';
		# Tip for hide default submit button
		$html .= '<style type="text/css" scoped>.uk-form-row button, .uk-form-row a {display:none};</style>';
		# Insert new button to save
		$html .= '<button class="uk-button uk-button-success" type="submit" name="add"><i class="uk-icon-pencil"></i> ' .$Language->get("edit-shorcodes"). '</button>';	
		# Submited? write the shorcode file		
		if (isset($_POST['add'])) pluginShorcode::write_shortcode();

		return $html;
	}	

}