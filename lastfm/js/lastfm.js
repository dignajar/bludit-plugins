$(function() {
	
	var fmscript = $('script#lastFmUpdate'),
				k = fmscript.attr('data-k'),
				u = fmscript.attr('data-u'),
				t = fmscript.attr('data-t');
	
	setInterval(function(){		
	$.ajax({
		url: '/bl-plugins/lastfm/update.php',
		type: 'post',
		data: {
			k: k,
			u: u,
			t: t
		},
		success: function(response) {
			$('.LastFmNowPlaying').html(response);
		}
		});
		}, 30000);
		
				
});
