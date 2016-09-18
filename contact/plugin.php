<?php
/**
 *  Contact
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Frédéric K.
 *  @copyright 2015-2016 Frédéric K.
 *	@version 1.1.2
 *  @release 2015-08-10
 *  @update 2016-04-19
 *
 */
class pluginContact extends Plugin {
		
	# DONNÉES DU PLUG-IN.
	public function init()
	{
		$this->dbFields = array(
			'email'=>'',	// <= Your contact email
			'page'=>''		// <= Slug url of contact page
			);
	}
	# ADMINISTRATION DU PLUG-IN.
	public function form()
	{
		global $Language, $pages, $pagesParents;
			
		// Liste des pages ou afficher le formulaire
		$_selectPageList = '';
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
		$html .= '<label for="jsemail">'.$Language->get('Email').'</label>';
	    $html .= '<div class="uk-form-icon">';
		$html .= '<i class="uk-icon-envelope"></i>';
		$html .= '<input class="uk-form-width-large" name="email" id="jsemail" type="email" value="'.$this->getDbField('email').'">';
		$html .= '</div>';
		$html .= '</div>';
		
		$html .= '<div class="uk-form-select" data-uk-form-select>
    <span></span>';		
		$html .= '<label for="jspage">' .$Language->get('Select a page to add the contact form').'</label>';
		$html .= '<select name="page" class="uk-form-width-medium">';
        foreach($_selectPageList as $value=>$text) {
                $html .= '<option value="'.$value.'"'.( ($this->getDbField('page')===$value)?' selected="selected"':'').'>'.$text.'</option>';
        }
		$html .= '</select>';	
		$html .= '</div>';	
			
		return $html;
	}
    /**
     * AFFICHE LA FEUILLE DE STYLE ET LE JAVASCRIPT UNIQUEMENT SUR LA PAGE DEMANDÉE.
     *
     */			
	public function siteHead()
	{
		global $Page, $Url;
		$html = '';
		
		if($Url->whereAmI()=='page' && $Page->slug()==$this->getDbField('page'))
		{
			$pluginPath = $this->htmlPath();
			/** 
			 * ON INCLUT LA CSS PAR DÉFAUT DU PLUG-IN OU LA CSS PERSONNALISÉE STOCKER DANS NOTRE THÈME 
			 */
		    $css = PATH_THEME_CSS. 'contact.css';
		    if(file_exists($css))
			    $html .= Theme::css('contact.css', HTML_PATH_THEME_CSS, false);
		    else 
		    	$html .= Theme::css('contact.css', $pluginPath . 'layout' .DS, false);
			    #$html .= '<link rel="stylesheet" href="'.$pluginPath.'layout/contact.css">'.PHP_EOL;	    				
		}
		return $html;
	}  
    /**
     * AJOUTE LE FORMULAIRE DE CONTACT APRÈS LE CONTENU DE LA PAGE.
     *
     */		
	public function pageEnd()
	{
		global $Page, $Url, $Site, $Language, $Security;
		# On charge le script uniquement sur la page en paramètre
		if( $Url->whereAmI()=='page' && $Page->slug()==$this->getDbField('page') )
		{ 
		   $error = false;
		   $success = false;
		   
		   # $_POST
		   $name       	= isset($_POST['name']) ? $_POST['name'] : '';
		   $email      	= isset($_POST['email']) ? $_POST['email'] : '';
		   $message    	= isset($_POST['message']) ? $_POST['message'] : '';
		   $interested 	= isset($_POST['interested']) ? $_POST['interested'] : '';			            		           
		   $contentType = 'text'; // Type de mail (text/html)
		             
		    if(isset($_POST['submit'])){	

					// Renew the token. This token will be the same inside the session for multiple forms.
					$Security->generateTokenCSRF();
								   	            
		            # Paramètres
		            $site_title   = $Site->title();
		            $site_charset = CHARSET;
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
					    # Si tout ok, on envoi notre mail
		                if(mail($site_email, $subject, $email_content, $email_headers)) { 
		                  # Retourne le message de confirmation d’envoi           
		                  $success = $Language->get('Thank you for having contacted me. I will reply you as soon as possible.');				                
		                  # Redirection sur le formulaire
		                  # Redirect::page( '', $Page->slug() );	                  
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
		    $template = PATH_THEME_PHP. 'contact.php';
		    if(file_exists($template))
			    include($template);
		    else 
			    include(dirname(__FILE__) . DS . 'layout' . DS . 'contact.php');	    			
		    
		}
	}   

}