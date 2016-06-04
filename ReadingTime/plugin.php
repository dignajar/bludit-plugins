<?php
/**
 * Estimated reading time
 *
 * @author 		Frédéric K.
 * @copyright	(c) 2015
 * @license		http://opensource.org/licenses/MIT
 * @package		Bludit CMS
 * @version		1.0.1
 * @update		2016-03-07
 */

class pluginReadingTime extends Plugin {

	private $enable;
		
	public function init()
	{
		$this->dbFields = array(
			'formatAltEnable'=> false,
			'enablePages'=>true,
			'enablePosts'=>true,
			'enableDefaultHomePage'=>false,			
			'dontDisplayPage'=>''
		);
	}

	function __construct()
	{
		parent::__construct();

		global $Url;

		$this->enable = false;

		if( $this->getDbField('enablePosts') && ($Url->whereAmI()=='post') ) {
			$this->enable = true;
		}
		elseif( $this->getDbField('enablePages') && ($Url->whereAmI()=='page') ) {
			$this->enable = true;
		}
		elseif( $this->getDbField('enableDefaultHomePage') && ($Url->whereAmI()=='home') )
		{
			$this->enable = true;
		}
	}
	
	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input name="formatAltEnable" id="jsformatAltEnable" type="checkbox" value="true" '.($this->getDbField('formatAltEnable')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsformatAltEnable">'.$Language->get('Format Alt Enable').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePages" id="jsenablePages" type="checkbox" value="true" '.($this->getDbField('enablePages')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('Enable Reading Time on pages').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="true" '.($this->getDbField('enablePosts')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('Enable Reading Time on posts').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enableDefaultHomePage" id="jsenableDefaultHomePage" type="checkbox" value="true" '.($this->getDbField('enableDefaultHomePage')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenableDefaultHomePage">'.$Language->get('Enable Reading Time on default home page').'</label>';
		$html .= '</div>';
				
/*
		$html .= '<div>';
		$html .= '<label for="jsdontDisplayPage">'.$Language->get('pages-where-do-not-display-the-reading-time').'</label>';
		$html .= '<input id="jsdontDisplayPage" type="text" name="dontDisplayPage" value="'.$this->getDbField('dontDisplayPage').'">';
		$html .= '<div class="tip">'.$Language->get('write-the-pages-separated-by-commas').'</div>';
		$html .= '</div>';	
*/	

		return $html;
	}
	/**
	 * Fansoro Reading Time Plugin
	 *
	 * (c) Romanenko Sergey / Awilum <awilum@msn.com>
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */	
	public function readingTime($content, $params = array() ) 	
	{
		global $Language;
	    $defaults = [
	      'minute'              => $Language->get('minute'),
	      'minutes'             => $Language->get('minutes'),
	      'second'              => $Language->get('second'),
	      'seconds'             => $Language->get('seconds'),
	      'format'              => '{minutes_count} {minutes_label}, {seconds_count} {seconds_label}',
	      'format.alt'          => '{seconds_count} {seconds_label}',
	      'format.alt.enable'   => $this->getDbField('formatAltEnable')
	    ];
	
	    $options      = array_merge($defaults, $params);
	    $words        = str_word_count(strip_tags($content));
	    $minutesCount = floor($words / 200);
	    $secondsCount = floor($words % 200 / (200 / 60));
	    $minutesLabel = ($minutesCount <= 1) ? $options['minute'] : $options['minutes'];
	    $secondsLabel = ($secondsCount <= 1) ? $options['second'] : $options['seconds'];
	
	    $replace      = [
	      'minutes_count' => $minutesCount,
	      'minutes_label' => $minutesLabel,
	      'seconds_count' => $secondsCount,
	      'seconds_label' => $secondsLabel,
	    ];
	
	    if ($minutesCount < 1 and $options['format.alt.enable'] === true) {
	        $result = $options['format.alt'];
	    } else {
	        $result = $options['format'];
	    }
	
	    foreach ($replace as $key => $value) {
	        $result = str_replace('{' . $key . '}', $value, $result);
	    }
	
	    return $result;
	}
	
	# Css
	public function siteHead()
	{
		if( $this->enable ) {
			return '<style type="text/css" media="screen">.reading_duration{ opacity: 0.5; font-style: italic; font-size: small}</style>'.PHP_EOL;
		}
		return false;
	}
		
	# Display in homepage and post
	public function postEnd()
	{
		global $Post, $Url, $posts; 
		$content = '';
		if( $this->enable ) {
			// Filter then build it!
			switch($Url->whereAmI())
			{
				case 'post':
					$content = $Post->content();				
			        $content = pluginReadingTime::readingTime($content);
			        return '<span class="reading_duration">'.$content.'</span>';
					break;
					
				case 'tag':
					$content = $Post->content();				
			        $content = pluginReadingTime::readingTime($content);
			        return '<span class="reading_duration">'.$content.'</span>';
					break;
										
				default:
					foreach($posts as $key=>$Post)
					{
						$content = $Post->content(false,true);										
						$content = pluginReadingTime::readingTime($content);
						return '<span class="reading_duration">'.$content.'</span>';
					}    
			}
		}

		return false;	     
	}
	
	# Display on Pages
	public function pageEnd()
	{
		global $Url, $Page;

		if( $this->enable && !$Url->notFound() ) {
			$content = $Page->content();		
			$content = pluginReadingTime::readingTime( $content );		
			return '<span class="reading_duration">'.$content.'</span>';
		}

		return false;		
	     
	}
	# ----------------------------------------------------------------------------------------------------------------------------
	# ----------------------------------------------------------------------------------------------------------------------------
	# ALL RESTE IS FOR FEATURE, DON4T WORK AT THE MOMENT!
	# ----------------------------------------------------------------------------------------------------------------------------
	# ----------------------------------------------------------------------------------------------------------------------------
/*
	public function template($file, $vars=array()) {
	    if(file_exists($file)){
	        // Make variables from the array easily accessible in the view
	        extract($vars);
	        // Start collecting output in a buffer
	        ob_start();
	        require($file);
	        // Get the contents of the buffer
	        $applied_template = ob_get_contents();
	        // Flush the buffer
	        ob_end_clean();
	        return $applied_template;
	    }
	}
		
	# Display in template
	public function beforeSiteLoad()
	{
		global $Page, $Post, $Url, $posts, $Site;
		switch($Url->whereAmI())
		{
			case 'post':
				$content = $Post->content();				
			    $content = pluginReadingTime::readingTime($content);
			    
				pluginReadingTime::template(PATH_THEMES.$Site->theme().DS.'post.php', array('{{ReadingTime}}'=>'15secondes'));
				break;
			case 'page':
				$content = $Page->content();		
		        // Parse
		        $content = str_replace('{ellapseTime}', '<span class="reading_duration">'.pluginReadingTime::readingTime($content).'</span>', $content);
		        $Page->setField('content', $content, true);
				break;
				
			default:
				foreach($posts as $key=>$Post)
				{
					// Full content parsed by Parsedown
					$content = $Post->content();
			
					// Parse
					$content = str_replace('{ellapseTime}', '<span class="reading_duration">'.pluginReadingTime::readingTime($content).'</span>', $content);
			
					// Set full content
					$Post->setField('content', $content, true);
			
					// Set page break content
					$explode = explode(PAGE_BREAK, $content);
					$Post->setField('breakContent', $explode[0], true);
					$Post->setField('readMore', !empty($explode[1]), true);
				}    
		}				     
	}
*/			
}
