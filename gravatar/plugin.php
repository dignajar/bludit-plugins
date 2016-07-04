<?php

class pluginGravatar extends Plugin
{
	 private $gravatar;
	 private $settings;
	 private $save_path = PATH_UPLOADS_PROFILES;
	 private $html_path = HTML_PATH_UPLOADS_PROFILES;
	 private $expiretime = 180;
	
	private $loadWhenController = array(
		'configure-plugin'
	);	

	public function init()
	{
		$this->dbFields = array(

			'themeDisplay-siteSidebar'=> "TRUE",
			'themeDisplay-postBegin'=> "FALSE",
			'themeDisplay-postEnd'=> "FALSE",
			'themeDisplay-pageBegin'=> "FALSE",
			'themeDisplay-pageEnd'=> "FALSE",


			'siteSidebar-avatar'=>"TRUE",
			'siteSidebar-name'=>"TRUE",
			'siteSidebar-bio'=>"TRUE",
			'siteSidebar-email'=>"TRUE",
			'siteSidebar-vcard'=>"TRUE",

			'postBegin-avatar'=>"FALSE",
			'postBegin-name'=>"FALSE",
			'postBegin-bio'=>"FALSE",
			'postBegin-email'=>"FALSE",
			'postBegin-vcard'=>"FALSE",

			'postEnd-avatar'=>"FALSE",
			'postEnd-name'=>"FALSE",
			'postEnd-bio'=>"FALSE",
			'postEnd-email'=>"FALSE",
			'postEnd-vcard'=>"FALSE",

			'pageBegin-avatar'=>"FALSE",
			'pageBegin-name'=>"FALSE",
			'pageBegin-bio'=>"FALSE",
			'pageBegin-email'=>"FALSE",
			'pageBegin-vcard'=>"FALSE",

			'pageEnd-avatar'=>"FALSE",
			'pageEnd-name'=>"FALSE",
			'pageEnd-bio'=>"FALSE",
			'pageEnd-email'=>"FALSE",
			'pageEnd-vcard'=>"FALSE"

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

	    $this->opts2obj( $this->getAllDb($this->dbFields) );

		$html = '<div class="uk-grid">'; 
		$html .= "<legend>Theme sections:</legend>";
 		foreach (  $this->settings->themeDisplay as $property => $value )
 		{
				$fieldName = "themeDisplay-" .$property;
				$html .= '<div class="uk-width-1-2">';  
				$html .= '<label class="uk-form-stacked" for="' .$fieldName. '">' .$property. '</label>';
				$html .= '<div class="switch tiny">';  
				$html .= '<input type="hidden" id="' .$fieldName. '-hidden" name="'. $fieldName .'" value="false" />'; 
				$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="' .$fieldName. '" name="'. $fieldName .'" value="true" '. ($value ? 'checked' : '' ) .' />'; 
				$html .= '<label for="' .$fieldName. '"></label>';
				$html .= '</div>';
				$html .= '</div>'; 
 		}

		$html .= "<legend>Fields to Display:</legend><br>";
		foreach (  $this->settings->themeDisplay as $property => $value )
		{
			$html .= '<legend>For '. $property .':</legend>';
			foreach (  $this->settings->{$property} as $property_name => $value)
			{
				$fieldName = $property."-" .$property_name;
				$value = (boolean) $value;

				$html .= '<div class="uk-width-1-2">';  
				$html .= '<label class="uk-form-stacked" for="' .$fieldName. '">' .$property_name. '</label>';
				$html .= '<div class="switch tiny">';  
				$html .= '<input type="hidden" id="' .$fieldName. '-hidden" name="'. $fieldName .'" value="false" />'; 
				$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="'. $fieldName .'" name="'. $fieldName .'" value="true" '. ($value ? 'checked' : '' ) .' />'; 
				$html .= '<label for="' .$fieldName. '"></label>';
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
				$this->username = $this->Post->username();
				break;
			case 'page':
				$this->username = $this->Page->username();
				break;
			default:
				$this->username = 'admin';
			break;
		}

		$this->email = $this->dbUsers->getDb($this->username)['email'];

		return $this;
	}

	function getAllDb($db)
	{

		foreach ($db as $prop => $value) {
			$this->currentDbFields[$prop] = $this->getDbField($prop);
		}

		return $this->currentDbFields;
    }

	function opts2obj( array $db)
	{
		foreach ($db as $prop => $value) {
			$a = explode("-",$prop);
			if( strtolower($value) === 'true'){
				@$this->settings->{$a[0]}[$a[1]] = true;
			}elseif( strtolower($value) === 'false' ){
				@$this->settings->{$a[0]}[$a[1]] = false;
			}else{
				@$this->settings->{$a[0]}->{$a[1]} = $value;
			}
		}
	}

	public function obj2opts( stdClass $db )
	{
		foreach ($db as $prop => $value) {
			if( is_array($value) || is_object($value) )
			{
				foreach ($value as $key => $v) {
					
					if( is_bool($v) ){
						$a[$prop."-".$key] = ($v === true)? 'true':'false';
					}elseif ( is_string( $v ) ){
						$a[$prop."-".$key] =  $v;
					}elseif ( is_int( $v ) ) {
						$a[$prop."-".$key] =  (string) $v;
					}

				}
			}
		}
		return $a;
	}

	public function getPluginOpts()
	{
		$this->request_type = 'json';
	    $this->opts2obj( $this->getAllDb($this->db) );

		return $this;
	}

	public function setUserData()
	{
		//saving settings to db
			$this->setDb( $this->obj2opts( $this->settings ) );
		return $this;
	}

	public function backupProfilePic()
	{
		$profilePicPath = $this->save_path.$this->username.'.jpg';
		if( file_exists( $profilePicPath ) ) {
			rename( $profilePicPath, $profilePicPath.'_bck' );
		}

		return $this;
	}

	public function restoreProfilePic()
	{
		$currentProfilePic = glob($this->save_path.$this->username.'.*[^\_bck]');
		$bckProfilePics = glob($this->save_path.$this->username.'.*_bck');
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
			
			case 'json':

				$this->response = json_decode( 
					file_get_contents( 'https://www.gravatar.com/'.md5($this->email).'.json', false, $this->context )
				);

				break;
			case 'vcard':

				$this->response = file_get_contents( 'https://www.gravatar.com/'.md5($this->email).'.vcf', false, $this->context );

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
		if ( is_array( $this->response ) && isset( $this->response['entry'] ) )
		{
	
			// $this->gravatar->bg = $this->response['entry'][0]['profileBackground']['url'];
			$this->settings->{$this->username}->avatar = @$this->gravatar->avatar = $this->response['entry'][0]['thumbnailUrl'];
			$this->settings->{$this->username}->displayName = @$this->gravatar->displayName = $this->response['entry'][0]['displayName'];
			$this->settings->{$this->username}->name = @$this->gravatar->name = $this->response['entry'][0]['name'];
			$this->settings->{$this->username}->aboutMe = @$this->gravatar->aboutMe = $this->response['entry'][0]['aboutMe'];
			
			// foreach ($this->response['entry'][0]['urls'] as $index => $urlArr)
			// {

			// 	$this->gravatar->urls[$index]->url = new stdClass;
			// 	$this->gravatar->urls[$index]->title = new stdClass;
			// 	$this->gravatar->urls[$index]->url = $urlArr['value'];
			// 	$this->gravatar->urls[$index]->title = $urlArr['title'];

			// }

		}

		return $this;
	}

	public function vcardType()
	{
		
		if(  $this->response ) // if not FALSE from previous response
		{
			$this->request_type = 'vcard';
			$this->request();
			$file = file_put_contents( $this->save_path . $this->username .".vcf", $this->response );
			if( $file )
			{
				$this->gravatar->vcard = $this->html_path . $this->username .".vcf";
				$this->settings->{$this->username}->vcard = $this->gravatar->vcard;
			}
		}

		return $this;
	}

	public function jsonType()
	{
		if ( is_object( $this->response ) && is_array( $this->response->entry ) )
		{
			// $this->gravatar->bg = $this->response->entry[0]->profileBackground->url;
			$this->settings->{$this->username}->avatar = @$this->gravatar->avatar = $this->response->entry[0]->thumbnailUrl;
			$this->settings->{$this->username}->displayName = @$this->gravatar->displayName = $this->response->entry[0]->displayName;
			$this->settings->{$this->username}->name = @$this->gravatar->name = $this->response->entry[0]->name->formatted;
			$this->settings->{$this->username}->aboutMe = @$this->gravatar->aboutMe = $this->response->entry[0]->aboutMe;
			
			// foreach ($this->response->entry[0]->urls as $index => $urlArr)
			// {

			// 	@$this->gravatar->urls[$index]->url = $urlArr->value;
			// 	@$this->gravatar->urls[$index]->title = $urlArr->title;

			// }		
			
		}

		return $this;
	}

	public function saveGravatarPic()
	{

		// if(file_exists(PATH_UPLOADS_PROFILES.$this->username.'.jpg')) {
		// 	echo '<img class="uk-border-rounded" src="'.HTML_PATH_UPLOADS_PROFILES.$this->username.'.jpg" alt="">';
		// }
		// 
	 	if( !empty( $this->gravatar->avatar ) )
	 	{

			$data = file_get_contents( $this->gravatar->avatar, false, $this->context );
			$this->getMimeType($data)->mimeToExtention();
			//$this->backupProfilePic();
			$file = file_put_contents($this->save_path.$this->username.$this->extention,$data);

			if( $file )
			{
				$this->gravatar->avatar = $this->html_path.$this->username.$this->extention;
				$this->settings->{$this->username}->avatar = $this->gravatar->avatar;
			}else
			{
				error_log(__CLASS__.": ".__METHOD__.": Image cannot be saved.");
			}

	 	}else
	 	{
			error_log(__CLASS__.": ".__METHOD__.": Gravatar image url is not set.");
	 	}

		return $this;
	}

	public function getMimeType($data)
	{
		if (class_exists('finfo'))
		{

	    	$finfo = new finfo(FILEINFO_MIME);
			$this->mimeType = $finfo->buffer($data);

		} elseif (class_exists( 'exif_imagetype' ) )
		{

	    	if( in_array( $imageTypeConsantNum = exif_imagetype( $data ), range(1,17), TRUE ) )
	    	{
	    		$this->mimeType = image_type_to_mime_type($imageTypeConsantNum);
	    	}

		}

		return $this;
	}

	public function mimeToExtention()
	{

		$extentions = ['image/jpeg'=>'.jpg', 'image/png'=>'.png', 'image/bmp'=> '.bmp', 'image/tiff'=>'.tiff', 'image/gif'=>'.gif'];
		$mimetype = preg_replace('/\;(.*)/','',$this->mimeType);
		foreach ($extentions as $key => $ext)
		{

			if($key === $mimetype)
			{
				$this->extention = $ext;
				break;
			}
		}

		return $this;
	}

	public function isCacheExpired()
	{
		// decide to re-fetch the data from gravatar or not
		$cTime = time();
		if( @!$this->settings->{$this->username}->cache ) {
			
			@$this->settings->{$this->username}->cache = $cTime;
			return TRUE;

		}elseif( $this->settings->{$this->username}->cache ) {
			
			$expired = ( $cTime - (int) $this->settings->{$this->username}->cache ) / 60 ;
			if( $expired >= $this->expiretime ){
				$this->settings->{$this->username}->cache = $cTime;
				return TRUE;

			}else{
				return FALSE;

			}

		}
	}

	public function output(array $preferences)
	{

		$html = '<div class="plugin plugin-gravatar">';
		// $html .= '<h2>'.$this->getDbField('label').'</h2>';
		$html .= '<div class="plugin-content">';
		// $html .= nl2br($this->getDbField('text'));
		
		if ($preferences['avatar']) {
			$html .= '<div id="gravatar-avatar"><img src="'. $this->settings->{$this->username}->avatar .'" alt=""></div>';
		}
		
		if ($preferences['name']) {
			$html .= "<div id=\"gravatar-name\"> {$this->settings->{$this->username}->displayName} </div>";
		} 
		
		if ($preferences['bio']) {
			$html .= "<div id=\"gravatar-bio\"> {$this->settings->{$this->username}->aboutMe} </div>";
		}
		
		if ($preferences['email']){
			$html .= "<div id=\"gravatar-email\"> {$this->email} </div>";
		}
		
		if($preferences['vcard']){
			$html .= "<div id=\"gravatar-vcard\"><a href=\" {$this->settings->{$this->username}->vcard}\">My vCard</a></div>";
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

		$this->getUserInfo()->getPluginOpts(); //load user and plugin options

		if( $this->settings->themeDisplay[ $themeMethod ] ){


			if( $this->isCacheExpired() || !$this->settings->{$this->username} ){
				$this->request()->getGravatarProfile()->saveGravatarPic()->setUserData();
			}
			return $this->output( $this->settings->$themeMethod ); 
		}
	}

	// add css to header
	// restore profile img

	public function siteHead()
	{ 
			global $Site;
			$PathPlugins = 'bl-plugins/gravatar/css/';
			$url = $Site->url().$PathPlugins;	  
			$html = '<link rel="stylesheet" href="'.$url.'gravatar.css" />'.PHP_EOL; 
			return $html;     
	}

	public function siteSidebar()
	{
		return $this->execute(__FUNCTION__);
	}

	public function postBegin()
	{
		return $this->execute(__FUNCTION__);
	}

	public function postEnd()
	{
		return $this->execute(__FUNCTION__);
	}

	public function pageBegin()
	{
		return $this->execute(__FUNCTION__);
	}

	public function pageEnd()
	{
		return $this->execute(__FUNCTION__);
	}

	public function debug()
	{
		echo "<pre>";
		// var_dump($this->response);
		var_dump($this->gravatar);
		echo "</pre>";

		return $this;
	}


}