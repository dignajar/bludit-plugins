$(function() {
	setInterval(function(){		
			$('.LastFmNowPlaying').load('/bl-plugins/lastfm/update.php');
		}, 30000);
});
