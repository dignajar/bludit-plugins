<?php
/**
 *  Contact
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Frédéric K.
 *  @copyright 2015 Frédéric K.
 *  @release 2015-08-10
 *  @update 2015-08-11
 *
 */
class pluginContact extends Plugin {
	
	protected static $security_token_name = 'security_token';
	/**
	 * Instance handler
	 * @var string
	 */
	var $handler		= null;		
	# DONNÉES DU PLUG-IN
	public function init()
	{
		$this->dbFields = array(
			'email'=>'',  // <= Your contact email
			'slug'=>''
			);
	}
	# AFFICHE LA FEUILLE DE STYLE ET LE JAVASCRIPT SUR LA CONFIGURATION DU PLUG-IN	
	public function adminHead()
	{
		global $Language;
		$html = '';

		$html .= '<script></script>'.PHP_EOL;
		return $html;
	}	
	# ADMINISTRATION DU PLUG-IN
	public function form()
	{
		global $Language, $pagesParents;

		// Liste des pages ou afficher le formulaire
		foreach($pagesParents as $parentKey=>$pageList)
		{
			foreach($pageList as $Page)
			{
				if($parentKey!==NO_PARENT_CHAR) {
					$parentTitle = $pages[$Page->parentKey()]->title().'->';
				}
				else {
					$parentTitle = '';
				}
		
				if($Page->published()) {
					$_selectPageList[$Page->key()] = $Language->g('Page').': '.$parentTitle.$Page->title();
				}
			}
		}
		$html  = '<div>';
		$html .= '<label>'.$Language->get('Email').'</label>';
		$html .= '<input name="email" id="jsemail" type="email" value="'.$this->getDbField('email').'" class="width-50" />';
		$html .= '</div>';
		
		$html .= '<div>';		
		$html .= '<label for="page">' .$Language->get('Select a page to add the contact form');
		$html .= '<select name="page" class="width-50">';
            $htmlOptions = $_selectPageList;
            foreach($htmlOptions as $value=>$text) {
                $html .= '<option value="'.$value.'"'.( ($this->getDbField('page')===$value)?' selected="selected"':'').'>'.$text.'</option>';
            }
		$html .= '</select>';
		$html .= '</label>';		
		$html .= '</div>';	
	
		return $html;
	}	
	# AFFICHE LA FEUILLE DE STYLE ET LE JAVASCRIPT UNIQUEMENT SUR LA PAGE DEMANDÉE	
	public function siteHead()
	{
		global $Page, $Url, $Site;
		$html = '';
		
		if($Url->whereAmI()==='page' && $Page->slug()==$this->getDbField('page'))
		{
			$html .= '<style type="text/css">input[name="interested"] {display: none;}
			.alert{padding: 5px 8px;color: white;width: 50%}
			.alert.error{background-color: crimson}
			.alert.success{background-color: mediumaquamarine}</style>'.PHP_EOL;
			$html .= '<script>$(".alert").fadeOut(10000);</script>'.PHP_EOL;
		}
		return $html;
	}
	
    /**
     * Generate and store a unique token which can be used to help prevent
     * [CSRF](http://wikipedia.org/wiki/Cross_Site_Request_Forgery) attacks.
     *
     *  <code>
     *      $token = pluginContact::generateToken();
     *  </code>
     *
     * You can insert this token into your forms as a hidden field:
     *
     *  <code>
     *      <input type="hidden" name="token" value="<?php echo pluginContact::generateToken(); ?>">
     *  </code>
     *
     * This provides a basic, but effective, method of preventing CSRF attacks.
     *
     * @param  boolean $new force a new token to be generated?. Default is false
     * @return string
     */
    public function generateToken($new = false) {
        # Get the current token
        if (isset($_SESSION[(string) pluginContact::$security_token_name])) $token = $_SESSION[(string) pluginContact::$security_token_name]; else $token = null;
        # Create a new unique token
        if ($new === true or ! $token) {
            # Generate a new unique token
            $token = sha1(uniqid(mt_rand(), true));
            # Store the new token
            $_SESSION[(string) pluginContact::$security_token_name] = $token;
        }
        # Return token
        return $token;
    }
    /**
     * Check that the given token matches the currently stored security token.
     *
     *  <code>
     *     if (pluginContact::checkToken($token)) {
     *         // Pass
     *     }
     *  </code>
     *
     * @param  string  $token token to check
     * @return boolean
     */
    public function checkToken($token) {
        return pluginContact::generateToken() === $token;
    }
    /**
     * Sanitize data to prevent XSS - Cross-site scripting
     *
     *  <code>
     *     $str = pluginContact::cleanString($str);
     *  </code>
     *
     * @param  string $str String
     * @return string 
     */
    public function cleanString($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
	/**
	 * Valid mail address ?
     *
     *  <code>
     *     $str = pluginContact::mailcheck();
     *  </code>
     *	 
	 * @return boolean
	 */
	public function mailcheck() { 
		return (filter_var($this->handler, FILTER_VALIDATE_EMAIL)) ? true : false; 
	}    
    /**
     * Add the contact form after content page
     *
     */		
	public function pageEnd()
	{
		global $Page, $Url, $Site, $Language;
		# On charge le script uniquement sur la page en paramètre
		if($Url->whereAmI()==='page' && $Page->slug()==$this->getDbField('page'))
		{ 
		   $error = false;
		   $success = false;
		   $token = pluginContact::generateToken(); // Très important de déclarer le jeton !!!

		   # $_POST
		   $name       = isset($_POST['name']) ? $_POST['name'] : '';
		   $email      = isset($_POST['email']) ? $_POST['email'] : '';
		   $message    = isset($_POST['message']) ? $_POST['message'] : '';
		   $interested = isset($_POST['interested']) ? $_POST['interested'] : '';			            		           
		   $contentType = 'text'; // Type de mail (text/html)
		             
		   if(isset($_POST['submit']) && pluginContact::checkToken($token)){		            
		            # Paramètres
		            $site_title   = $Site->title();
		            $site_charset = 'UTF-8';
		            $site_email   = $this->getDbField('email');
		            
		            # Object du mail
		            $subject        = $Language->get('New contact from ').$site_title;
		            # Contenu du mail.
		            $email_content  = $Language->get('Name:').$name."\r\n";
		            $email_content .= $Language->get('Email:').$email."\r\n";
		            $email_content .= $Language->get('Message:')."\r\n".$message."\r\n";
		            
		            # Entêtes du mail
		            $email_headers  = "From: ".$name." <".$email.">\r\n";
		            $email_headers .= "Reply-To: ".$email."\r\n";
		            $email_headers .= 'MIME-Version: 1.0'."\r\n";
		            # Content-Type
		            if($contentType == 'html')
		               $email_headers .= 'Content-type: text/html; charset="'.$site_charset.'"'."\r\n";
				    else
					   $email_headers .= 'Content-type: text/plain; charset="'.$site_charset.'"'."\r\n";
		
				    $email_headers .= 'Content-transfer-encoding: 8bit'."\r\n";
				    $email_headers .= 'Date: '.date("D, j M Y G:i:s O")."\r\n"; // Sat, 7 Jun 2001 12:35:58 -0700
				
		            # On vérifie les champs qu'ils soient remplis
			        if(trim($name)=='')
				       $error = $Language->get('Please enter your name');			       	       	       
			        elseif(trim($email)=='')
				       $error = $Language->get('Please enter a valid email address');
			        elseif(trim($message)=='')
				       $error = $Language->get('Please enter the content of your message');
				    elseif($interested)
				       $error = $Language->get('Oh my god a Bot!');
				    if(!$error) {
		               if(mail($site_email, $subject, $email_content, $email_headers)) { 
			              # Reset fields, work ?
			              $_POST = array();  
		                  # Envoi du Mail             
		                  $success = $Language->get('Thank you for having contacted me. I will reply you as soon as possible.');
		                  #Redirect::page($Page->slug());
		               } else {
		                  $error = $Language->get('Oops! An error occurred while sending your message, thank you to try again later.');
		               }
		            }
		        # On retourne les erreurs    
		        if($error) echo '<div class="alert fade error">'.$error.'</div>'."\r\n";
		        elseif($success) echo '<div class="alert fade success">'.$success.'</div>'."\r\n";
		    }	
						    							    
			/** 
			 * VERSION 0.3
			 * ON INCLUT LE TEMPLATE PAR DÉFAUT DU PLUG-IN OU LE TEMPLATE PERSONNALISÉ STOCKER DANS NOTRE THÈME 
			 */
		    $template = PATH_THEMES. $Site->theme(). '/php/contact.php';
		    if(file_exists($template)) {
			    include_once($template);
		    } else {
			    include(dirname(__FILE__).'/layout/contact.php');
		    }	    			

		}
	}   

}