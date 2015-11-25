<?php
	
	// Add Shortcode {site_url}
	Shortcode::add('site_url', function () {
		global $Site;
	    return $Site->url();
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
	
	// Add Shortcode {Discus name='bludit'}
	Shortcode::add('Discus', function($attributes) {
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

?>