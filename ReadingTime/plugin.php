<?php
/**
 * Estimated reading time
 *
 * @author 		Frédéric K.
 * @copyright	(c) 2015
 * @license		http://opensource.org/licenses/MIT
 * @package		Bludit CMS
 * @version		1.0
 * @update		2016-02-27
 */

class pluginReadingTime extends Plugin {
	
	public function init()
	{
		$this->dbFields = array(
			'formatAltEnable'=> false
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<input name="formatAltEnable" id="jsformatAltEnable" type="checkbox" value="true" '.($this->getDbField('formatAltEnable')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsformatAltEnable">'.$Language->get('Format Alt Enable').'</label>';
		$html .= '</div>';

		return $html;
	}
		
	public function readingTime($content, array $params = [])
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
		$html = '<style type="text/css" media="screen">.reading_duration{ opacity: 0.5; font-style: italic; font-size: small}</style>'.PHP_EOL;	     
	    return $html;   
	}
		
	# Display in homepage and post
	public function postEnd()
	{
		global $Post, $Url, $posts; 
		$content = '';
		// Filter then build it!
		switch($Url->whereAmI())
		{
			case 'post':
				$content = $Post->content();				
		        // Parse Shortcodes
		        $content = pluginReadingTime::readingTime( $content );
				break;
				
			default:
				foreach($posts as $key=>$Post)
				{
					// Full content parsed by Parsedown
					$content = $Post->content();
					// Parse with Shortcode
					$content = pluginReadingTime::readingTime( $content );
				}    
		}
		return '<span class="reading_duration">'.$content.'</span>';
	     
	}
	
	# Display on Pages
	public function pageEnd()
	{
		global $Page; 
		
		$content = $Page->content();		
		$content = pluginReadingTime::readingTime( $content );		
		return '<span class="reading_duration">'.$content.'</span>';
	     
	}
			
}
