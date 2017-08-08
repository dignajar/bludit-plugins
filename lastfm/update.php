<?php
	include __DIR__.'/config.php';
	
	$user = $config['username'];
	$key = $config['apikey'];
	$text = $config['plugintext'];

        if(empty($user) | empty($key)) return false;
    		$track = getTrackInfo($user, $key);

			if(!$track) return false;

			$pluginText = preg_replace_callback("/{(\w+)}/", function($m) use($track){
				return $track[$m[1]];
			}, $text);

			echo $pluginText;
			
		function getTrackInfo($user, $key) {
        $lastFmResponse = makeRequest($user, $key);
        if (!count($lastFmResponse['recenttracks'])) {
            return false;
        }
			
        $lastTrack = $lastFmResponse['recenttracks']['track'][0];

        return [
            'artist' => $lastTrack['artist']['#text'],
            'track' => $lastTrack['name'],
            'album' => $lastTrack['album']['#text'],
            'tracklink' => '<a href="'.$lastTrack['url'].'">'.$lastTrack['name'].'</a>'
        ];
    }

		function makeRequest($user, $key) {
        $url = 'http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&limit=1&user='.$user.'&api_key='.$key.'&format=json&limit=1';
        $response = file_get_contents($url);
        return json_decode($response, true);
}







