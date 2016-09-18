<?php
class pluginHitcounter extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'counter'=>0,
			'numberofchars'=>5,
			'text'=>'Anzahl Besucher',
			'displayaschars'=>true,
			'displayasimages'=>false
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label>'.$Language->get('text').'</label>';
		$html .= '<input name="text" id="jstext" type="text" value="'.$this->getDbField('text').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('positions').'</label>';
		$html .= '<input name="numberofchars" id="jsnumberofchars" type="number" min="1" max="10" value="'.$this->getDbField('numberofchars').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$Language->get('current value').'</label>';
		$html .= '<input name="counter" id="jscounter" type="number" min="0" value="'.$this->getDbField('counter').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input type="hidden" name="displayaschars" value="0">';
		$html .= '<input name="displayaschars" id="jsdisplayaschars" type="checkbox" value="1" '.($this->getDbField('displayaschars')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsdisplayaschars">'.$Language->get('display counter as chars').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input type="hidden" name="displayasimages" value="0">';
		$html .= '<input name="displayasimages" id="jsdisplayasimages" type="checkbox" value="1" '.($this->getDbField('displayasimages')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsdisplayasimages">'.$this->showAllImages().' - '.$Language->get('display counter as images').'</label>';
		$html .= '</div>';

		return $html;
	}

	//Function for admin-panel, returns all number-images
	private function showAllImages() {
		$result = '';
		for ($i = 0; $i < 10; $i++) {
			$result .= '<img src="'.$this->htmlPath().'images'.DS.$i.'.gif" alt="'.$i.'.gif">';
		}
		return $result;
	}

	//Creates an img-tag for diplay current counter
	private function createImageTag($number) {
		return '<img src="'.$this->htmlPath().'images'.DS.$number.'.gif" alt="'.$number.'.gif">';
	}

	

	public function siteSidebar() {	
		$html  = '<div class="plugin plugin-hitcounter">';

		// Print the label if not empty.
		$label = $this->getDbField('text');
		if( !empty($label) ) {
			$html .= '<h2>'.$label.'</h2>';
		}
		
		// Get the current counter
		$counter = $this->createCounter($this->getDbField('counter'));
		
		//Display as character is checked
		if ($this->getDbField('displayaschars')) {
			$html .= '<p>'.$counter.'</p>';
		}

		//Display as images is checked
		if ($this->getDbField('displayasimages')) {
			foreach (str_split($counter) as $key => $val) {
				$html .= $this->createImageTag($val);
			}
		}

 		$html .= '</div>';
		return $html;
	}

	public function beforeSiteLoad() {
		$this->increaseCounter();
	}

	public function increaseCounter() {
		//Counter will be increased only once a session
		if (!isset($_SESSION['counterplugin'])) {
			$tmp = array();
			$tmp['counter'] = $this->getDbField('counter') + 1;
			$tmp['numberofchars'] = $this->getDbField('numberofchars');
			$tmp['text'] = $this->getDbField('text');
			$this->setDb($tmp);
			//Set Variable for this session so user cannot increase counter by pressing F5
			$_SESSION['counterplugin'] = 0;
		}
	}

	// Creates the complete string and fills it with zeros (if needed)
	private function createCounter($number) {
		$l = $this->getDbField('numberofchars');
		
		while (strlen($number) < $l)
		{
			$number = '0'.$number;
		}
		return $number;

	}
}
