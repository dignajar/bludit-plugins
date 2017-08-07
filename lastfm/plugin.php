<?php

class pluginLastFM extends Plugin {

		public function siteBodyBegin() {
			if($this->getDbField('position') == 'bodyBegin') {
				return $this->createPlugin();
			}
		}
		
		public function siteBodyEnd() {
			if($this->getDbField('position') == 'bodyEnd') {
				return $this->createPlugin();
			}
		}
		
		public function siteSidebar() {
			if($this->getDbField('position') == 'sidebar') {
				return $this->createPlugin();
			}
		}
		
		protected function createPlugin() {

        if(empty($this->getDbField('username')) | empty($this->getDbField('apikey'))) return false;
    		$track = $this->getTrackInfo();

			if(!$track) return false;

			$pluginText = preg_replace_callback("/{(\w+)}/", function($m) use($track){
				return $track[$m[1]];
			}, $this->getDbField('plugintext'));

			return '<div class="plugin LastFmNowPlaying">'.$pluginText.'</div>';
    }

    public function siteHead() {
    		$head = '<link rel="stylesheet" href="'.$this->htmlPath().'css/main.css">';
    		
    		if($this->getDbField('autoupdate')) {
    		$head .= "\n";
    		$head .= '<script src="'.$this->htmlPath().'js/lastfm.js" id="lastFmUpdate" data-t="'.$this->getDbField('plugintext').'" data-k="'.$this->getDbField('apikey').'" data-u="'.$this->getDbField('username').'"></script>';
    		}
    		return $head;
    }

    protected function getTrackInfo() {
        $lastFmResponse = $this->makeRequest();
        if (!count($lastFmResponse['recenttracks'])) {
            return false;
        }
			
        $lastTrack = $lastFmResponse['recenttracks']['track'][0];

			if(!$this->getDbField('showLatest')) {
        if (!isset($lastTrack['@attr']['nowplaying'])) {
            return false;
        }
        if (!$lastTrack['@attr']['nowplaying']) {
            return false;
        }
			}
        return [
            'artist' => $lastTrack['artist']['#text'],
            'track' => $lastTrack['name'],
            'album' => $lastTrack['album']['#text'],
            'tracklink' => '<a href="'.$lastTrack['url'].'">'.$lastTrack['name'].'</a>'
        ];
    }

    public function makeRequest() {
        $url = 'http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&limit=1&user='.$this->getDbField('username').'&api_key='.$this->getDbField('apikey').'&format=json&limit=1';
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

	public function init() {
		$this->dbFields = array(
			'apikey'=>'',
			'username'=>'',
        'plugintext'=>'♪ Now playing {track} by {artist} from {album}',
			'showLatest'=>false,
			'position'=>'bodyBegin',
			'autoupdate'=>false
		);
	}

	public function form() {
		global $Language;
		
		$positions = array('bodyBegin'=>'Body begin','bodyEnd'=>'Body end','sidebar'=>'Sidebar');

		$html  = '<div>';
		$html .= '<label>'.$Language->get('API Key').' <small><a href="https://www.last.fm/api">Get API key here</a></small></label>';
		$html .= '<input name="apikey" type="text" value="'.$this->getDbField('apikey').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('LastFM username').'</label>';
		$html .= '<input name="username" type="text" value="'.$this->getDbField('username').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('Text to show in plugin. <small>{artist} for artist, {track} for track, {tracklink} for track with link and {album} for album').'</small></label>';
		$html .= '<input name="plugintext" type="text" value="'.$this->getDbField('plugintext').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('Show latest  song if none is playing?').'</label>';
		$html .= '<select name="showLatest">';
		if($this->getDbField('showLatest')) {
			$html .= '<option value="1" selected>Yes</option>';
			$html .= '<option value="0">No</option>';
		} else {
			$html .= '<option value="1">Yes</option>';
			$html .= '<option value="0" selected>No</option>';
		}
		$html .= '</select>';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>'.$Language->get('Position for the plugin').'</label>';
		$html .= '<select name="position">';
		foreach($positions as $pos => $txt) {
			if($this->getDbField('position') == $pos) {
				$html .= '<option value="'.$pos.'" selected>'.$txt.'</option>';
			} else {
				$html .= '<option value="'.$pos.'">'.$txt.'</option>';
			}
		}
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('Auto update trackinfo?').' <small>Your API key will be visible in code</small></label>';
		$html .= '<select name="autoupdate">';
		if($this->getDbField('autoupdate')) {
			$html .= '<option value="1" selected>Yes</option>';
			$html .= '<option value="0">No</option>';
		} else {
			$html .= '<option value="1">Yes</option>';
			$html .= '<option value="0" selected>No</option>';
		}
		$html .= '</select>';
		$html .= '</div>';

		return $html;
	}

}

?>
