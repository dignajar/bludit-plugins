<?php

class pluginGravatar extends Plugin
{
	 private $gravatar;
	 private $save_path = PATH_UPLOADS_PROFILES;
	 private $html_path = HTML_PATH_UPLOADS_PROFILES;
	 protected $display;
	
	private $loadWhenController = array(
		'configure-plugin'
	);	

	public function init()
	{
		$this->dbFields = array(

			'themeDisplay'=>[

				'siteHead'=> FALSE,
				'siteSidebar'=> TRUE,
				'postBegin'=> FALSE,
				'postEnd'=> FALSE

			],

			'siteHead'=> [	'avatar'=>FALSE,
							'name'=>FALSE,
							'bio'=>FALSE,
							'email'=>FALSE,
							'vcard'=>FALSE
						],
			'siteSidebar'=> ['avatar'=>TRUE,
							'name'=>TRUE,
							'bio'=>TRUE,
							'email'=>TRUE,
							'vcard'=>TRUE
						],
			'postBegin'=> ['avatar'=>FALSE,
							'name'=>FALSE,
							'bio'=>FALSE,
							'email'=>FALSE,
							'vcard'=>FALSE
						],
			'postEnd'=> ['avatar'=>TRUE,
							'name'=>TRUE,
							'bio'=>TRUE,
							'email'=>TRUE,
							'vcard'=>FALSE
						]

		);
	}

	public function adminHead()
	{
		global $layout;
		$html  = '';

		if(in_array($layout['controller'], $this->loadWhenController))
		{		
			$html .= '<style type="text/css">.cmn-toggle{position:absolute;margin-left:-9999px;visibility:hidden;}.cmn-toggle + label{display:block;position:relative;cursor:pointer;outline:none;user-select:none;}input.cmn-toggle-round-flat + label{padding:1px;width:60px;height:30px;background-color:#dddddd;border-radius:30px;transition:background 0.4s;}input.cmn-toggle-round-flat + label:before,input.cmn-toggle-round-flat + label:after{display:block;position:absolute;content:"";}input.cmn-toggle-round-flat + label:before{top:1px;left:1px;bottom:1px;right:1px;background-color:#fff;border-radius:30px;transition:background 0.4s;}input.cmn-toggle-round-flat + label:after{top:2px;left:2px;bottom:2px;width:26px;background-color:#dddddd;border-radius:26px;transition:margin 0.4s,background 0.4s;}input.cmn-toggle-round-flat:checked + label{background-color:#8ce196;}input.cmn-toggle-round-flat:checked + label:after{margin-left:30px;background-color:#8ce196;}</style>'.PHP_EOL;
		}

		return $html;
	}

	public function form()// needs testing for values
	{
	    global $Language;
    	// $html = '<div>';
		$html = '<div class="uk-grid">'; 
		
		//loop on themeDisplay and fieldsDisplay
 		// form1
 		// var_dump( $this->dbFields['themeDisplay'] );
 		
		$html .= "<legend>Theme sections:</legend>";
 		foreach (  $this->dbFields['themeDisplay'] as $property => $value ) {
				$html .= '<div class="uk-width-1-2">';  
				$html .= '<label class="uk-form-stacked" for="' .$property. '">' .$property. '</label>';
				$html .= '<div class="switch tiny">';  
				$html .= '<input type="hidden" id="' .$property. '-hidden" name="themeDisplay['. $property .']" value="'. ($value ? 'true' : 'false') .'" '. ($value ? 'checked' : '' ) .' />'; 
				$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="' .$property. '" name="themeDisplay['. $property .']" value="'. ($value ? 'true' : 'false') .'" '. ($value ? 'checked' : '' ) .' />'; 
				$html .= '<label for="' .$property. '"></label>';
				$html .= '</div>'; 
				$html .= '</div>'; 
 		}

 		// form2
		$html .= "<legend>Fields to Display:</legend><br>";
		foreach (  $this->dbFields['themeDisplay'] as $property => $value ) {

			$html .= '<legend>For '. $property .':</legend>';
			foreach (  $this->dbFields[$property] as $property_name => $value) {
				$html .= '<div class="uk-width-1-2">';  
				
				$html .= '<label class="uk-form-stacked" for="' .$property_name. '">' .$property_name. '</label>';
				$html .= '<div class="switch tiny">';  
				$html .= '<input type="hidden" id="' .$property_name. '-hidden" name="'. $property .'['. $property_name .']" value="'. ($value ? 'true' : 'false') .'" '. ($value ? 'checked' : '' ) .' />'; 
				$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="' .$property_name. '" name="'. $property .'['. $property_name .']" value="'. ($value ? 'true' : 'false') .'" '. ($value ? 'checked' : '' ) .' />'; 
				$html .= '<label for="' .$property_name. '"></label>';
				$html .= '</div>'; 
				$html .= '</div>'; 
			}
		}

		// echo $html;


		$html .= '</div>'; 
	    return $html;
	}

	public function getUserInfo()
	{

		switch($this->Url->whereAmI())
		{
			case 'post':
				$this->username = $Post->username();
				break;
			case 'page':
				$this->username = $Page->username();
				break;
			default:
				$this->username = 'admin';
			break;
		}

		$this->email = $this->dbUsers->getDb($this->username);
		// $this->email = "specktator@totallynoob.com";
		// $this->username = "specktator";

		$this->userInfo = (object) $this->getDbField($this->username);

		return $this;
	}

	public function getPluginOpts()
	{
		$this->request_type = 'json';
		// $this->avatar-> ($this->getDbfield('avatar')),
		// $this->name-> ($this->getDbfield('name')),
		// $this->bio-> ($this->getDbfield('bio')),
		// $this->email-> ($this->getDbfield('email')),
		// $this->card-> ($this->getDbfield('card')),

		$this->themeDisplay = $this->getDbField('themeDisplay');
		
		foreach ( $this->themeDisplay as $property => $value ) {

			$this->{$property} = $this->getDbField($property); // get specific user options for each template's place

			foreach ( $this->$property as $propertyName => $value ) { 
				$this->{$propertyName} = $value;
			}
		}

		return $this;
	}

	public function setUserData()
	{
		// a hack to save each users gravatar profile info in DB
		if( !$this->getDbfield($this->username) ){
			$this->dbFields[$this->username] = (array) $this->gravatar;
			return $this;
		}//else{
		//	return FALSE;
		//}

	}

	public function backupProfilePic()
	{
		$profilePicPath = PATH_UPLOADS_PROFILES.$this->username.'.jpg';
		if( file_exists( $profilePicPath ) ) {
			rename( $profilePicPath, $profilePicPath.'_bck' );
		}

		return $this;
	}

	public function restoreProfilePic()
	{
		$currentProfilePic = glob(PATH_UPLOADS_PROFILES.$this->username.'.*[^\_bck]');
		$bckProfilePics = glob(PATH_UPLOADS_PROFILES.$this->username.'.*_bck');
		if ( rename( $bckProfilePics[0], str_replace( '_bck', '', $bckProfilePics[0] ) ) ) {
			unlink($currentProfilePic[0]);
		}
		
		return $this;
	}
	
	public function request()
	{

		$opts = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
						"Cookie: grava=tar\r\n".
						"User-Agent: {$_SERVER['HTTP_USER_AGENT']}\r\n" 
		  )
		);

		$this->context = stream_context_create($opts);

		switch ($this->request_type) {
			case 'php':
				
				$this->response = file_get_contents( 'https://www.gravatar.com/'.md5($this->email).'.php', false, $this->context );

				break;

			case 'vcard':

				$this->response = file_get_contents( 'https://www.gravatar.com/'.md5($this->email).'.vcf', false, $this->context );

				break;
			
			case 'json':

				$this->response = json_decode( 
					file_get_contents( 'https://www.gravatar.com/'.md5($this->email).'.json', false, $this->context )
				);

				break;
			default:

				$this->response = FALSE;

				break;
		}

		return $this;
	}

	public function getGravatarProfile()
	{

		
		switch ($this->request_type) {
			case 'php':

				$this->phpType();
				$this->vcardType();

				break;

			default:

				$this->jsonType();
				$this->vcardType();

				break;
		}

		return $this;
	}

	public function phpType()
	{
		if ( is_array( $this->response ) && isset( $this->response['entry'] ) ){
	
			// $this->gravatar->bg = $this->response['entry'][0]['profileBackground']['url'];
			$this->gravatar->avatar = $this->response['entry'][0]['thumbnailUrl'];
			$this->gravatar->displayName = $this->response['entry'][0]['displayName'];
			$this->gravatar->name = $this->response['entry'][0]['name'];
			$this->gravatar->aboutMe = $this->response['entry'][0]['aboutMe'];
			
			foreach ($this->response['entry'][0]['urls'] as $index => $urlArr) {

				$this->gravatar->urls[$index]->url = new stdClass;
				$this->gravatar->urls[$index]->title = new stdClass;
				$this->gravatar->urls[$index]->url = $urlArr['value'];
				$this->gravatar->urls[$index]->title = $urlArr['title'];

			}

		}

		return $this;
	}

	public function vcardType()
	{
		
		if( isset( $this->response ) && !is_array( $this->response ) && !is_object( $this->response ) ){
			if( file_put_contents( $this->save_path . $this->username .".vcf", $this->response ) ){
				$this->gravatar->vcard = $this->save_path . $this->username .".vcf";
			}
		}

		return $this;
	}

	public function jsonType()
	{
		if ( is_object( $this->response ) && is_array( $this->response->entry ) ) {

			// $this->gravatar->bg = $this->response->entry[0]->profileBackground->url;
			$this->gravatar->avatar = $this->response->entry[0]->thumbnailUrl;
			$this->gravatar->displayName = $this->response->entry[0]->displayName;
			$this->gravatar->name = $this->response->entry[0]->name;
			$this->gravatar->aboutMe = $this->response->entry[0]->aboutMe;
			
			foreach ($this->response->entry[0]->urls as $index => $urlArr) {

				$this->gravatar->urls[$index]->url = new stdClass;
				$this->gravatar->urls[$index]->title = new stdClass;
				$this->gravatar->urls[$index]->url = $urlArr->value;
				$this->gravatar->urls[$index]->title = $urlArr->title;

			}		
			
		} 

		return $this;
	}

	public function saveGravatarPic()
	{

		// if(file_exists(PATH_UPLOADS_PROFILES.$this->username.'.jpg')) {
		// 	echo '<img class="uk-border-rounded" src="'.HTML_PATH_UPLOADS_PROFILES.$this->username.'.jpg" alt="">';
		// }
		// 
	 	if( $this->gravatar->avatar ) {

			$data = file_get_contents( $this->gravatar->avatar, false, $this->context );
			$this->getMimeType($data)->mimeToExtention();

			if( !file_put_contents("{$this->save_path}{$this->username}{$this->extention}",$data) ){
				error_log(__CLASS__.": ".__METHOD__.": Image cannot be saved.");
			}else{
				$this->gravatar->avatar = $this->html_path.$this->username.$this->extention;
			}

	 	}else {
			error_log(__CLASS__.": ".__METHOD__.": Gravatar image url is not set.");
	 	}

		return $this;
	}

	public function getMimeType($data)
	{
		if (class_exists('finfo')) {

	    	$finfo = new finfo(FILEINFO_MIME);
			$this->mimeType = $finfo->buffer($data);

		} elseif (class_exists( 'exif_imagetype' ) ) {

	    	if( in_array( $imageTypeConsantNum = exif_imagetype( $data ), range(1,17), TRUE ) ){
	    		$this->mimeType = image_type_to_mime_type($imageTypeConsantNum);
	    	}

		}

		return $this;
	}

	public function mimeToExtention()
	{

		$extentions = ['image/jpeg'=>'.jpg', 'image/png'=>'.png', 'image/bmp'=> '.bmp', 'image/tiff'=>'.tiff', 'image/gif'=>'.gif'];
		$mimetype = preg_replace('/\;(.*)/','',$this->mimeType);
		foreach ($extentions as $key => $ext) {

			if($key === $mimetype){
				$this->extention = $ext;
				break;
			}
		}

		return $this;
	}

	public function isCacheExpired()
	{
		// decide to re-fetch the data from gravatar or not
		// $this->getDbField('cache');
		return TRUE;
	}

	public function output(array $preferences)
	{

		$html = '<div class="plugin plugin-gravatar">';
		// $html .= '<h2>'.$this->getDbField('label').'</h2>';
		$html .= '<div class="plugin-content">';
		// $html .= nl2br($this->getDbField('text'));
		
		if ($$preferences['avatar']) {
			$html .= '<div><img src="'. $this->userInfo->avatar .'" alt=""></div>';
		}
		
		if ($$preferences['name']) {
			$html .= "<div id=\"gravatar-name\"> {$this->userInfo->name->formatted} </div>";
		} 
		
		if ($$preferences['bio']) {
			$html .= "<div id=\"gravatar-bio\"> {$this->userInfo->aboutMe} </div>";
		}
		
		if ($$preferences['email']){
			$html .= "<div id=\"gravatar-email\"> {$this->userInfo->email} </div>";
		}
		
		if($$preferences['vcard']){
			$html .= "<div id=\"gravatar-vcard\"><a href=\" {$this->userInfo->vcard}\">My vCard</a></div>";
		}

 		$html .= '</div>';
 		$html .= '</div>';

		// echo $html;
		return $html;
		// return $this;
	}

	public function execute($themeMethod)
	{

		global $Url, $Site, $Language;
		global $Post, $Page, $dbUsers;

		$this->Post = $Post;
		$this->Page = $Page;
		$this->Url = $Url;
		$this->dbUsers = $dbUsers;

		if( $this->isCacheExpired() || !$this->userInfo ){
			$this->getUserInfo()->getPluginOpts()->request()->getGravatarProfile()->saveGravatarPic()->setUserData()->debug();
		}else{
			$this->getUserInfo()->getPluginOpts();
		}

		if( $this->themeDisplay[$themeMethod] ){

			$this->output($this->{$themeMethod});
		}
	}

	// include basic css at head
	// user set/get user preferences
	// template hooks
	//  

	public function siteHead()
	{
		$this->execute(__METHOD__);
	}

	public function siteSidebar()
	{
		$this->execute(__METHOD__);
	}

	public function postBegin()
	{
		$this->execute(__METHOD__);
	}

	public function postEnd()
	{
		$this->execute(__METHOD__);
	}

	public function debug()
	{
		echo "<pre>";
		var_dump($this->response);
		var_dump($this->gravatar);
		echo "</pre>";

		return $this;
	}


}