<?php
	
	// Add Shortcode {site_url}
	Shortcode::add('site_url', function () {
		global $Site;
	    return $Site->url();
	}); 

	// Add Shortcode {template}
	Shortcode::add('template', function () {
	    return HTML_PATH_THEME;
	}); 
	
	// Add Shortcode {cut}
	Shortcode::add('cut', function () {
	    return PAGE_BREAK;
	}); 
		
	// Add Shortcode {Gitter room='dignajar/bludit'}
	Shortcode::add('Gitter', function($attributes) {
		// Extract attributes
		extract($attributes);
		// src
		if (isset($room)) $room = $room; else $room = 'dignajar/bludit';
		// return
		return "<section><script>((window.gitter = {}).chat = {}).options = {room: '".$room."'};</script><script src='https://sidecar.gitter.im/dist/sidecar.v1.js' async defer></script></section>";
	});   
	
	// Add Shortcode {Share class='uk-list' facebook='bludit' twitter='bludit' github='bludit'}
	Shortcode::add('Share', function($attributes) {
		// Extract attributes
		extract($attributes);
		// text
		if (isset($class)) $class = $class; else $class = 'uk-list';
		if (isset($facebook)) $facebook = $facebook; else $facebook = 'Anonymus';
		if (isset($twitter)) $twitter = $twitter; else $twitter = 'Anonymus';
		if (isset($github)) $github = $github; else $github = 'Anonymus';
		// return
		return '<ul class="'.$class.'">
			        <li><a href="http://twitter.com/'.$facebook.'">Twitter</a></li>
			        <li><a href="http://facebook.com/'.$twitter.'">facebook</a></li>
			        <li><a href="http://github.com/'.$github.'">Github</a></li>
			    </ul>';
	});
	
	// Add Shortcode {Disqus name='bludit'}
	Shortcode::add('Disqus', function($attributes) {
	    // Extract attributes
	    extract($attributes);
	    // name
	    if (isset($name)) $name = $name; else $name = 'bludit';
	    // return
	    return '<section><div id="disqus_thread"></div><script type="text/javascript">var disqus_shortname = "'.$name.'";(function() {var dsq = document.createElement("script");dsq.type = "text/javascript";dsq.async = true;dsq.src = "//" + disqus_shortname + ".disqus.com/embed.js";(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);})();</script></section>';
	});
	
	// Add Shortcode {Youtube width='560' height='315' src='YQHsXMglC9A'}
	Shortcode::add('Youtube', function($attributes) {
	    // Extract attributes
	    extract($attributes);
	    // src
	    if (isset($width)) $width = $width; else $width = '560';
	    if (isset($height)) $height = $height; else $height = '315';
	    if (isset($src)) $src = $src; else $src = '';
	    // return
	    return '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$src.'" frameborder="0" allowfullscreen></iframe>';
	});
	
	
	
	// Add Shortcode {Dailymotion width='560' height='315' src='cexar241'}
	Shortcode::add('Dailymotion', function($attributes) {
	    // Extract attributes
	    extract($attributes);
	    // src
	    if (isset($width)) $width = $width; else $width = '560';
	    if (isset($height)) $height = $height; else $height = '315';
	    if (isset($src)) $src = $src; else $src = '';
	    // return
	    return '<iframe width="'.$width.'" height="'.$height.'" src="//www.dailymotion.com/embed/video/'.$src.'" frameborder="0" allowfullscreen></iframe>';
	});
	
	
	// Add Shortcode {Vimeo width='560' height='315' src='144239829'}
	Shortcode::add('Vimeo', function($attributes) {
	    // Extract attributes
	    extract($attributes);
	    // src
	    if (isset($width)) $width = $width; else $width = '560';
	    if (isset($height)) $height = $height; else $height = '315';
	    if (isset($src)) $src = $src; else $src = '';
	    // return
	    return '<iframe width="'.$width.'" height="'.$height.'" src="//player.vimeo.com/video/'.$src.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	});

	// Add Shortcode {Field label='My Field' value='Value field'}
	Shortcode::add('Field', function($attributes) {
	    // Extract attributes
	    extract($attributes);
	    // src
	    if (isset($label)) $label = $label; else $label = 'My field';
	    if (isset($value)) $value = $value; else $value = 'Value field';
	    // return
	    return $label.': '.$value;
	});
	
	// Add Shortcode: {Tiny url='http://www.bludit.com'}
	Shortcode::add('Tiny', function ($attributes) {	
	    // Extract
	    extract($attributes);
	    $url = (isset($url)) ? file_get_contents('http://tinyurl.com/api-create.php?url='.$url) : '';
	    // return
	    return $url;
	});

	// Add Shortcode {Spoiler title='Spoiler' content='Spoiler content'}
	Shortcode::add('Spoiler', function($attributes) {
		// Extract attributes
		extract($attributes);
		// text
		if (isset($title)) $title = $title; else $title='Toggle content';
		if (isset($content)) $content = $content; else $content = 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.';
		// return
		return '<style>.spoiler-box{padding:5px;box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.2);;margin-top:5px;margin-bottom:5px;}.spoiler-close{background-color:#ddd;padding:0px 5px;float:right;}.spoiler-content2{width:100%;padding:5px;}.spoiler-title{background-color:#777;color:#fff;width:100%;display:block;padding:5px;position:relative;}.spoiler-close,.spoiler-content2{display:none}.spoiler-box:focus .spoiler-content2{display:block}.spoiler-box:focus .spoiler-close{display:block}</style>
<div class="spoiler-box" tabindex="1"><div class="spoiler-title">' .$title. '<div class="spoiler-close" tabindex="2">close</div></div><div class="spoiler-content2">' .$content. '</div></div>';
	});

?>