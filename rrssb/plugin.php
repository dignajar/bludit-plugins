<?php	
/*
	@Package: Bludit
	@Plugin: Ridiculously Responsive Social Sharing Buttons 
	@Version: 1.8.1c
	@Author: Fred K.
	@Realised: 14 Juilly 2015	
	@Updated: 02 August 2015
*/
class pluginRRSSB extends Plugin {
	
	private $loadWhenController = array(
		'configure-plugin'
	);	
	// Datas plugin
	public function init()
	{	
		$this->dbFields = array(
			'checkall' => false,
			'email' => false,
			'facebook' => true,
			'tumblr' => false,
			'linkedin' => false,
			'twitter' => true,
			'reddit' => false,
			'googleplus' => true,
			'youtube' => false,
			'pinterest' => false,
			'github_url' => '',
			'show_sidebar' => true
			);
	}
	// Styled plugin in backend
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
	// Backend configuration
	public function form()
	{
		global $Language;
		$html  = '';
		
/*
		$html .= '<div class="tools-message tools-message-yellow" style="display:block">' .$Language->get("To customize the buttons display on your theme, turn off the display in the sidebar and copy/paste this code anywhere you want in your theme."). '<p style="text-align:left;color:#000000; background-color:#ffffff; border:dashed black 1px; padding:0.5em 1em 0.5em 1em; overflow:auto;font-size:small; font-family:monospace;"><em><span style="color:#878787;">&lt;?php</span></em> Theme::<span style="color:#3f6e7d;">plugins</span>(<span style="color:#dd2400;">\'getRRSSB\'</span>); <em><span style="color:#878787;">?&gt;</span></em></p></div>';	

		$html .= '<div>';  

		$html .= '<div class="label label-white">';  
		$html .= '<label for="show_sidebar">' .$Language->get("Show in sidebar"). '</label>';
		$html .= '<div class="switch tiny">';  
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="show_sidebar" name="show_sidebar" value="false" '.($this->getDbField('show_sidebar')?'checked':'').' />'; 
		$html .= '<label for="show_sidebar"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
		
		$html .= '</div>';
*/
		
				  
		$html .= '<div>';  
		$html .= '<div class="label label-white">';  
		$html .= '<label for="email">' .$Language->get("Email"). '</label>';
		$html .= '<div class="switch tiny">';  
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="email" name="email" value="false" '.($this->getDbField('email')?'checked':'').' />'; 
		$html .= '<label for="email"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="facebook">' .$Language->get("Facebook"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="facebook" name="facebook" value="false" '.($this->getDbField('facebook')?'checked':'').' />'; 
		$html .= '<label for="facebook"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="tumblr">' .$Language->get("Tumblr"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="tumblr" name="tumblr" value="false" '.($this->getDbField('tumblr')?'checked':'').' />'; 
		$html .= '<label for="tumblr"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="linkedin">' .$Language->get("Linkedin"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="linkedin" name="linkedin" value="false" '.($this->getDbField('linkedin')?'checked':'').' />'; 
		$html .= '<label for="linkedin"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="twitter">' .$Language->get("Twitter"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="twitter" name="twitter" value="false" '.($this->getDbField('twitter')?'checked':'').' />'; 
		$html .= '<label for="twitter"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="reddit">' .$Language->get("Reddit"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="reddit" name="reddit" value="false" '.($this->getDbField('reddit')?'checked':'').' />'; 
		$html .= '<label for="reddit"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="googleplus">' .$Language->get("Google+"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="googleplus" name="googleplus" value="false" '.($this->getDbField('googleplus')?'checked':'').' />'; 
		$html .= '<label for="googleplus"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="youtube">' .$Language->get("Youtube"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="youtube" name="youtube" value="false" '.($this->getDbField('youtube')?'checked':'').' />'; 
		$html .= '<label for="youtube"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
      
		$html .= '<div class="label label-white">'; 
		$html .= '<label for="pinterest">' .$Language->get("Pinterest"). '</label>';
		$html .= '<div class="switch tiny">'; 
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" id="pinterest" name="pinterest" value="false" '.($this->getDbField('pinterest')?'checked':'').' />'; 
		$html .= '<label for="pinterest"></label>';
		$html .= '</div>'; 
		$html .= '</div>';

		$html .= '<div class="label">';  
		$html .= '<label for="checkall">' .$Language->get("Check all / Uncheck all"). '</label>';
		$html .= '<div class="switch tiny">';  
		$html .= '<input type="checkbox" class="cmn-toggle cmn-toggle-round-flat" data-tools="check-all" data-classname="cmn-toggle" id="checkall" name="checkall" value="false" '.($this->getDbField('checkall')?'checked':'').' />'; 
		$html .= '<label for="checkall"></label>';
		$html .= '</div>'; 
		$html .= '</div>';
		
		$html .= '<div>';  
		$html .= '<label for="github_url">' .$Language->get('Your Github repository (leave blank to disable)');
		$html .= '<div class="input-groups width-50">';
		$html .= '<span class="input-prepend">https://github.com/</span><input type="text" name="github_url" value="'.$this->getDbField('github_url').'" />';
		$html .= '</div>';
		$html .= '</label>';     
		$html .= '</div>';	
				
		$html .= '</div>';
						
		return $html;
	}
	// Load css plugin in public theme
	public function siteHead()
	{ 
			global $Site;
			$PathPlugins = 'plugins/rrssb/libs/';
			$config_url = $Site->url().$PathPlugins;	  
			$html = '<link rel="stylesheet" href="'.$config_url.'css/rrssb.css" />'.PHP_EOL; 
			return $html;     
	}
	// Load js plugin in public theme
	public function siteBodyEnd()
	{ 
			global $Site;
			$PathPlugins = 'plugins/rrssb/libs/';
			$config_url = $Site->url().$PathPlugins;	
			
			$html  = '<script>'.PHP_EOL;
			$html .= '/* <![CDATA[ */'.PHP_EOL;
			$html .= 'if(typeof(jQuery) === "undefined") document.write(\'<script src="'.$config_url.'js/vendor/jquery.1.10.2.min.js"><\/script>\');'.PHP_EOL;
			$html .= '/* !]]> */'.PHP_EOL;
			$html .= '</script>'.PHP_EOL;			  
			$html .= '<script src="'.$config_url.'js/rrssb.min.js"></script>'.PHP_EOL;    
			
			return $html;   
	}
	// Make the share bar!
	public function RRSSB()
	{
		global $Url, $Site, $Language;
		global $Post, $Page;
 
		$share = array(
			'title'			=>	$Site->title(). '&nbsp;',
			'description'	=>	'&nbsp;'. $Site->description(),
			'url'			=>	$Site->url(),
			'image'			=>	'themes/' .$Site->theme(). '/favicon.ico', // Pinterest feature
			'siteName'		=>	$Site->title()
		);

		switch($Url->whereAmI())
		{
			case 'post':
				$share['title']			= $Post->title(). '&nbsp;';
				$share['description']	= '&nbsp;'. $Post->description();
				$share['url']			= $Post->permalink(true);
				break;
			case 'page':
				$share['title']			= $Page->title(). '&nbsp;';
				$share['description']	= '&nbsp;'. $Page->description();
				$share['url']			= $Page->permalink(true);
				break;
		}
		
	    $html = '<ul class="rrssb-buttons">'.PHP_EOL;
	
	    
	    if ($this->getDbField('email'))  
	     { 
	      $html .= '<li class="rrssb-email">
	                        <a href="mailto:?subject=' .$share['title']. '-' .$share['description']. '%20' .$share['url']. '&amp;body='.$Site->url().'">
	                            <span class="rrssb-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve"><g><path d="M20.111 26.147c-2.336 1.051-4.361 1.401-7.125 1.401c-6.462 0-12.146-4.633-12.146-12.265 c0-7.94 5.762-14.833 14.561-14.833c6.853 0 11.8 4.7 11.8 11.252c0 5.684-3.194 9.265-7.399 9.3 c-1.829 0-3.153-0.934-3.347-2.997h-0.077c-1.208 1.986-2.96 2.997-5.023 2.997c-2.532 0-4.361-1.868-4.361-5.062 c0-4.749 3.504-9.071 9.111-9.071c1.713 0 3.7 0.4 4.6 0.973l-1.169 7.203c-0.388 2.298-0.116 3.3 1 3.4 c1.673 0 3.773-2.102 3.773-6.58c0-5.061-3.27-8.994-9.303-8.994c-5.957 0-11.175 4.673-11.175 12.1 c0 6.5 4.2 10.2 10 10.201c1.986 0 4.089-0.43 5.646-1.245L20.111 26.147z M16.646 10.1 c-0.311-0.078-0.701-0.155-1.207-0.155c-2.571 0-4.595 2.53-4.595 5.529c0 1.5 0.7 2.4 1.9 2.4 c1.441 0 2.959-1.828 3.311-4.087L16.646 10.068z"/></g></svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Email"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('facebook')) 
	     { 
	      $html .= '<li class="rrssb-facebook">
	                        <a href="https://www.facebook.com/sharer/sharer.php?u='.$share['url'].'" class="popup">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                    <path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
	                                        c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
	                                        c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
	                                </svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Facebook"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('tumblr'))
	     { 
	      $html .= '<li class="rrssb-tumblr">
	                        <a href="http://tumblr.com/share?s=&amp;v=3&t=' .$share['title']. '-' .$share['description']. '%20' .$share['url']. '&amp;u=' .$Site->url(). '">
	                            <span class="rrssb-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve"><path d="M18.02 21.842c-2.029 0.052-2.422-1.396-2.439-2.446v-7.294h4.729V7.874h-4.71V1.592c0 0-3.653 0-3.714 0 s-0.167 0.053-0.182 0.186c-0.218 1.935-1.144 5.33-4.988 6.688v3.637h2.927v7.677c0 2.8 1.7 6.7 7.3 6.6 c1.863-0.03 3.934-0.795 4.392-1.453l-1.22-3.539C19.595 21.6 18.7 21.8 18 21.842z"/></svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Tumblr"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('linkedin')) 
	     { 
	      $html .= '<li class="rrssb-linkedin">
	                        <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=' .$share['url']. '&amp;title=' .$share['title']. '%20' .$share['url']. '&amp;summary=' .$share['description']. '%20' .$share['url']. '" class="popup">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                    <path d="M25.424,15.887v8.447h-4.896v-7.882c0-1.979-0.709-3.331-2.48-3.331c-1.354,0-2.158,0.911-2.514,1.803
	                                        c-0.129,0.315-0.162,0.753-0.162,1.194v8.216h-4.899c0,0,0.066-13.349,0-14.731h4.899v2.088c-0.01,0.016-0.023,0.032-0.033,0.048
	                                        h0.033V11.69c0.65-1.002,1.812-2.435,4.414-2.435C23.008,9.254,25.424,11.361,25.424,15.887z M5.348,2.501
	                                        c-1.676,0-2.772,1.092-2.772,2.539c0,1.421,1.066,2.538,2.717,2.546h0.032c1.709,0,2.771-1.132,2.771-2.546
	                                        C8.054,3.593,7.019,2.501,5.343,2.501H5.348z M2.867,24.334h4.897V9.603H2.867V24.334z"/>
	                                </svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Linkedin"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('twitter'))
	     { 
	      $html .= '<li class="rrssb-twitter">
	                        <a href="http://twitter.com/home?status=' .$share['title']. '-' .$share['description']. '%20' .$share['url']. '" class="popup">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                <path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
	                                    c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
	                                    C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
	                                    C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
	                                    c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
	                                    C26.275,7.229,25.39,8.196,24.253,8.756z"/>
	                                </svg>
	                           </span>
	                            <span class="rrssb-text">' .$Language->get("Twitter"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('reddit')) 
	     { 
	      $html .= '<li class="rrssb-reddit">
	                        <a href="http://www.reddit.com/submit?url=' .$share['url']. '">
	                            <span class="rrssb-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve"><g><path d="M11.794 15.316c0-1.029-0.835-1.895-1.866-1.895c-1.03 0-1.893 0.865-1.893 1.895s0.863 1.9 1.9 1.9 C10.958 17.2 11.8 16.3 11.8 15.316z"/><path d="M18.1 13.422c-1.029 0-1.895 0.864-1.895 1.895c0 1 0.9 1.9 1.9 1.865c1.031 0 1.869-0.836 1.869-1.865 C19.969 14.3 19.1 13.4 18.1 13.422z"/><path d="M17.527 19.791c-0.678 0.678-1.826 1.006-3.514 1.006c-0.004 0-0.009 0-0.014 0c-0.004 0-0.01 0-0.015 0 c-1.686 0-2.834-0.328-3.51-1.005c-0.264-0.265-0.693-0.265-0.958 0c-0.264 0.265-0.264 0.7 0 1 c0.943 0.9 2.4 1.4 4.5 1.402c0.005 0 0 0 0 0c0.005 0 0 0 0 0c2.066 0 3.527-0.459 4.47-1.402 c0.265-0.264 0.265-0.693 0.002-0.958C18.221 19.5 17.8 19.5 17.5 19.791z"/><path d="M27.707 13.267c0-1.785-1.453-3.237-3.236-3.237c-0.793 0-1.518 0.287-2.082 0.761c-2.039-1.295-4.646-2.069-7.438-2.219 l1.483-4.691l4.062 0.956c0.071 1.4 1.3 2.6 2.7 2.555c1.488 0 2.695-1.208 2.695-2.695C25.881 3.2 24.7 2 23.2 2 c-1.059 0-1.979 0.616-2.42 1.508l-4.633-1.091c-0.344-0.081-0.693 0.118-0.803 0.455l-1.793 5.7 C10.548 8.6 7.7 9.4 5.6 10.75C5.006 10.3 4.3 10 3.5 10.029c-1.785 0-3.237 1.452-3.237 3.2 c0 1.1 0.6 2.1 1.4 2.69c-0.04 0.272-0.061 0.551-0.061 0.831c0 2.3 1.3 4.4 3.7 5.9 c2.299 1.5 5.3 2.3 8.6 2.325c3.228 0 6.271-0.825 8.571-2.325c2.387-1.56 3.7-3.66 3.7-5.917 c0-0.26-0.016-0.514-0.051-0.768C27.088 15.5 27.7 14.4 27.7 13.267z M23.186 3.355c0.74 0 1.3 0.6 1.3 1.3 c0 0.738-0.6 1.34-1.34 1.34s-1.342-0.602-1.342-1.34C21.844 4 22.4 3.4 23.2 3.355z M1.648 13.3 c0-1.038 0.844-1.882 1.882-1.882c0.31 0 0.6 0.1 0.9 0.209c-1.049 0.868-1.813 1.861-2.26 2.9 C1.832 14.2 1.6 13.8 1.6 13.267z M21.773 21.57c-2.082 1.357-4.863 2.105-7.831 2.105c-2.967 0-5.747-0.748-7.828-2.105 c-1.991-1.301-3.088-3-3.088-4.782c0-1.784 1.097-3.484 3.088-4.784c2.081-1.358 4.861-2.106 7.828-2.106 c2.967 0 5.7 0.7 7.8 2.106c1.99 1.3 3.1 3 3.1 4.784C24.859 18.6 23.8 20.3 21.8 21.57z M25.787 14.6 c-0.432-1.084-1.191-2.095-2.244-2.977c0.273-0.156 0.59-0.245 0.928-0.245c1.035 0 1.9 0.8 1.9 1.9 C26.354 13.8 26.1 14.3 25.8 14.605z"/></g></svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Reddit"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('googleplus'))
	     { 
	      $html .= '<li class="rrssb-googleplus">
	                        <a href="https://plus.google.com/share?url=' .$share['title']. '-' .$share['description']. '%20' .$share['url']. '%20' .$Site->url(). '" class="popup">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                    <g>
	                                        <g>
	                                            <path d="M14.703,15.854l-1.219-0.948c-0.372-0.308-0.88-0.715-0.88-1.459c0-0.748,0.508-1.223,0.95-1.663
	                                                c1.42-1.119,2.839-2.309,2.839-4.817c0-2.58-1.621-3.937-2.399-4.581h2.097l2.202-1.383h-6.67c-1.83,0-4.467,0.433-6.398,2.027
	                                                C3.768,4.287,3.059,6.018,3.059,7.576c0,2.634,2.022,5.328,5.604,5.328c0.339,0,0.71-0.033,1.083-0.068
	                                                c-0.167,0.408-0.336,0.748-0.336,1.324c0,1.04,0.551,1.685,1.011,2.297c-1.524,0.104-4.37,0.273-6.467,1.562
	                                                c-1.998,1.188-2.605,2.916-2.605,4.137c0,2.512,2.358,4.84,7.289,4.84c5.822,0,8.904-3.223,8.904-6.41
	                                                c0.008-2.327-1.359-3.489-2.829-4.731H14.703z M10.269,11.951c-2.912,0-4.231-3.765-4.231-6.037c0-0.884,0.168-1.797,0.744-2.511
	                                                c0.543-0.679,1.489-1.12,2.372-1.12c2.807,0,4.256,3.798,4.256,6.242c0,0.612-0.067,1.694-0.845,2.478
	                                                c-0.537,0.55-1.438,0.948-2.295,0.951V11.951z M10.302,25.609c-3.621,0-5.957-1.732-5.957-4.142c0-2.408,2.165-3.223,2.911-3.492
	                                                c1.421-0.479,3.25-0.545,3.555-0.545c0.338,0,0.52,0,0.766,0.034c2.574,1.838,3.706,2.757,3.706,4.479
	                                                c-0.002,2.073-1.736,3.665-4.982,3.649L10.302,25.609z"/>
	                                            <polygon points="23.254,11.89 23.254,8.521 21.569,8.521 21.569,11.89 18.202,11.89 18.202,13.604 21.569,13.604 21.569,17.004
	                                                23.254,17.004 23.254,13.604 26.653,13.604 26.653,11.89      "/>
	                                        </g>
	                                    </g>
	                                </svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Google+"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('youtube')) 
	     { 
	      $html .= '<li class="rrssb-youtube">
	                        <a href="' .$share['url']. '">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                    <path d="M27.688,8.512c0-2.268-1.825-4.093-4.106-4.093H4.389c-2.245,0-4.076,1.825-4.076,4.093v10.976 c0,2.268,1.825,4.093,4.076,4.093h19.192c2.274,0,4.106-1.825,4.106-4.093V8.512z M11.263,18.632V8.321l7.817,5.155L11.263,18.632z" />
	                                </svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Youtube"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('pinterest')) 
	     { 
	      $html .= '<li class="rrssb-pinterest">
	                        <a href="http://pinterest.com/pin/create/button/?url=' .$share['url']. '&amp;media=' .$share['image']. '&amp;description=' .$share['title']. '-' .$share['description']. '%20' .$share['url']. '">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                <path d="M14.021,1.57C6.96,1.57,1.236,7.293,1.236,14.355c0,7.062,5.724,12.785,12.785,12.785c7.061,0,12.785-5.725,12.785-12.785
	                                    C26.807,7.294,21.082,1.57,14.021,1.57z M15.261,18.655c-1.161-0.09-1.649-0.666-2.559-1.219c-0.501,2.626-1.113,5.145-2.925,6.458
	                                    c-0.559-3.971,0.822-6.951,1.462-10.116c-1.093-1.84,0.132-5.545,2.438-4.632c2.837,1.123-2.458,6.842,1.099,7.557
	                                    c3.711,0.744,5.227-6.439,2.925-8.775c-3.325-3.374-9.678-0.077-8.897,4.754c0.19,1.178,1.408,1.538,0.489,3.168
	                                    C7.165,15.378,6.53,13.7,6.611,11.462c0.131-3.662,3.291-6.227,6.46-6.582c4.007-0.448,7.771,1.474,8.29,5.239
	                                    c0.579,4.255-1.816,8.865-6.102,8.533L15.261,18.655z"/>
	                                </svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Pinterest"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	     
	    if ($this->getDbField('github_url') != '') 
	     { 
	      $html .= '<li class="rrssb-github">
	                        <a href="https://github.com/' .$this->getDbField('github_url'). '">
	                            <span class="rrssb-icon">
	                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
	                                <path d="M13.971,1.571c-7.031,0-12.734,5.702-12.734,12.74c0,5.621,3.636,10.392,8.717,12.083c0.637,0.129,0.869-0.277,0.869-0.615
	                                    c0-0.301-0.012-1.102-0.018-2.164c-3.542,0.77-4.29-1.707-4.29-1.707c-0.579-1.473-1.414-1.863-1.414-1.863
	                                    c-1.155-0.791,0.088-0.775,0.088-0.775c1.277,0.104,1.96,1.316,1.96,1.312c1.136,1.936,2.991,1.393,3.713,1.059
	                                    c0.116-0.822,0.445-1.383,0.81-1.703c-2.829-0.32-5.802-1.414-5.802-6.293c0-1.391,0.496-2.527,1.312-3.418
	                                    C7.05,9.905,6.612,8.61,7.305,6.856c0,0,1.069-0.342,3.508,1.306c1.016-0.282,2.105-0.424,3.188-0.429
	                                    c1.081,0,2.166,0.155,3.197,0.438c2.431-1.648,3.498-1.306,3.498-1.306c0.695,1.754,0.258,3.043,0.129,3.371
	                                    c0.816,0.902,1.315,2.037,1.315,3.43c0,4.892-2.978,5.968-5.814,6.285c0.458,0.387,0.876,1.16,0.876,2.357
	                                    c0,1.703-0.016,3.076-0.016,3.482c0,0.334,0.232,0.748,0.877,0.611c5.056-1.688,8.701-6.457,8.701-12.082
	                                    C26.708,7.262,21.012,1.563,13.971,1.571L13.971,1.571z"/>
	                                </svg>
	                            </span>
	                            <span class="rrssb-text">' .$Language->get("Github"). '</span>
	                        </a>
	                    </li>'.PHP_EOL;
	     }
	                 
	     
	    $html .= '</ul>'.PHP_EOL;

		return $html;  	   
	}
	// Display on sidebar theme
	public function siteSidebar()
	{  
		#if ($this->getDbField('show_sidebar')) 
		return pluginRRSSB::RRSSB();     
	}
	// Display anywhere in theme: Theme::plugins('getRRSSB');
	public function getRRSSB()
	{  
		return pluginRRSSB::getRRSSB();     
	}		
}