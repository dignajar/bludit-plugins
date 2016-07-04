<?php
/**
 *  Gallery
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Frédéric K.
 *  @copyright 2015 Frédéric K.
 *  @release 2015-09-16
 *  @update 2016-01-30
 *
 */
 class pluginFolioGallery extends Plugin {
	# INSCRIPTION DANS LA BDD 	
	public function init()
	{	
		$this->dbFields = array(
			'folder' => '',  // <= Your folder gallery
			'page' => '',
			'itemsPerPage' => '12',
			'thumbWidth' => '250',
			'maxWidth' => '800',
			'numCaptionsChars' => '80',
			'sort_albums_by_date' => TRUE,    // TRUE will sort albums by creation date (most recent first), FALSE will sort albums by name 
			'sort_images_by_date' => TRUE,    // TRUE will sort thumbs by creation date (most recent first), FALSE will sort images by name 
			'random_thumbs' => TRUE,    // TRUE will display random thumbnails, FALSE will display the first image from thumbs folders
			'show_captions' => TRUE,    // TRUE will display file names as captions on thumbs inside albums, FALSE will display no captions			
			);
	}
	# ADMINISTRATION DU PLUG-IN
	public function form()
	{
		global $Language, $pages, $pagesParents, $Site;
		
		$html  = '<div class="uk-block uk-block-primary uk-contrast uk-float-right">
                        <div class="uk-container">
                                <h3><i class="uk-icon-info-circle"></i></h3>
                                <div class="uk-panel">
                                        <p>'.$Language->get('folio-gallery-help').'</p>
                                </div>
                        </div>
                  </div>';					
		if (isset($_GET['add_picture'])) {
			/** 
			 * ON INCLUT LE TEMPLATE PAR DÉFAUT DU PLUG-IN OU LE TEMPLATE PERSONNALISÉ STOCKER DANS NOTRE THÈME 
			 */
		    $template = PATH_THEME_PHP. 'manage.php';
		    if(file_exists($template)) {
			    include_once($template);
		    } else {
			    include(dirname(__FILE__). DS .'layout/manage.php');
		    }					
		} else {
		$html .= '<div>';		
		$html .= '<label class="uk-form-label" for="page">'.$Language->get('Select a folder for the gallery'). '</label>';
		$html .= '<select name="folder" class="width-50">';
			foreach(glob(PATH_UPLOADS.'*', GLOB_ONLYDIR) as $dir) {
			    $dir = str_replace(PATH_UPLOADS, '', $dir);
			    $html .= '<option value="'.$dir.'"'.( ($this->getDbField('folder')===$dir)?' selected="selected"':'').'>'.$dir.'</option>';
			}		
		$html .= '</select>';
		$html .= '<div class="uk-form-help-block">'.$this->getDbField('The directory must contain other subdirectories that must contain the images.').'</div>';	
		$html .= '</div>';	
		
		// Liste des pages ou afficher la galerie
		foreach($pagesParents as $parentKey=>$pageList)
		{
			foreach($pageList as $Page)
			{
				if($parentKey!==NO_PARENT_CHAR)
					$parentTitle = $pages[$Page->parentKey()]->title().'->';
				else 
					$parentTitle = '';
		
				if($Page->published()) 
					$_selectPageList[$Page->key()] = $Language->g('Page').': '.$parentTitle.$Page->title();
			}
		}		    	
		$html .= '<div>';			
		$html .= '<label class="uk-form-label" for="page">' .$Language->get('Select a page to add the gallery'). '</label>';
		$html .= '<select name="page" class="width-50">';
            foreach($_selectPageList as $value=>$text) {
                $html .= '<option value="'.$value.'"'.( ($this->getDbField('page')===$value)?' selected="selected"':'').'>'.$text.'</option>';
            }
		$html .= '</select>';		
		$html .= '</div>';	

		$html .= '<div>';
		$html .= '<label class="uk-form-label" for="itemsPerPage">'.$Language->get('Items Per Page').'</label>';
		$html .= '<input name="itemsPerPage" id="jsitemsPerPage" type="number" value="'.$this->getDbField('itemsPerPage').'" class="width-10" />';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label class="uk-form-label" for="thumbWidth">'.$Language->get('Thumb Width').'</label>';
		$html .= '<input name="thumbWidth" id="jsthumbWidth" type="number" value="'.$this->getDbField('thumbWidth').'" class="width-10" />';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label class="uk-form-label" for="maxWidth">'.$Language->get('Max pictures width').'</label>';
		$html .= '<input name="maxWidth" id="jsmaxWidth" type="number" value="'.$this->getDbField('maxWidth').'" class="width-10" />';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label class="uk-form-label" for="numCaptionsChars">'.$Language->get('Number of characters displayed in album and thumb captions').'</label>';
		$html .= '<input name="numCaptionsChars" id="jsnumCaptionsChars" type="number" value="'.$this->getDbField('numCaptionsChars').'" class="width-10" />';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="sort_albums_by_date" id="jssort_albums_by_date" type="checkbox" value="true" '.($this->getDbField('sort_albums_by_date')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jssort_albums_by_date">'.$Language->get('sort_albums_by_date').'</label>';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<input name="sort_images_by_date" id="jssort_images_by_date" type="checkbox" value="true" '.($this->getDbField('sort_images_by_date')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jssort_images_by_date">'.$Language->get('sort_images_by_date').'</label>';
		$html .= '</div>';
						
		$html .= '<div>';
		$html .= '<input name="random_thumbs" id="jsrandom_thumbs" type="checkbox" value="true" '.($this->getDbField('random_thumbs')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsrandom_thumbs">'.$Language->get('random_thumbs').'</label>';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<input name="random_thumbs" id="jsrandom_thumbs" type="checkbox" value="true" '.($this->getDbField('random_thumbs')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsrandom_thumbs">'.$Language->get('show_captions').'</label>';
		$html .= '</div>';		
/*
		$html .= '<div class="unit-100">';
		$html .= '<a href="'.HTML_PATH_ADMIN_ROOT.'configure-plugin/pluginFolioGallery?add_picture" class="btn btn-green"><i class="fa fa-life-ring"></i> ' .$Language->get("Add Images"). '</a>';
		$html .= '</div>';	
*/		
		}
				
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
		
		if($Url->whereAmI()==='page' && $Page->slug()==$this->getDbField('page'))
		{
			$pluginPath = $this->htmlPath().'libs'.DS;
			/** 
			 * ON INCLUT LA CSS PAR DÉFAUT DU PLUG-IN OU LA CSS PERSONNALISÉE STOCKER DANS NOTRE THÈME 
			 */
		    $css = PATH_THEME_CSS. 'foliogallery.css';
		    if(file_exists($css))
			    $html .= Theme::css('foliogallery.css');
		    else 
			    $html .= '<link rel="stylesheet" href="'.$pluginPath.'foliogallery' .DS. 'foliogallery.css">'.PHP_EOL;
			$html .= '<link rel="stylesheet" type="text/css" href="' .$pluginPath. 'colorbox' .DS. 'colorbox.css" media="screen">'.PHP_EOL;		
		}
		return $html;
	}
	# AFFICHE LE JAVASCRIPT UNIQUEMENT SUR LA PAGE DEMANDÉE	
	public function siteBodyEnd()
	{
		global $Page, $Url, $Site;
		$pluginPath = $this->htmlPath().'libs'.DS;
		$language = $Site->shortLanguage();
		
		$html ='';
		if($Url->whereAmI()==='page' && $Page->slug()==$this->getDbField('page'))
		{
			$html .= '<script src="' .$pluginPath. 'foliogallery' .DS. 'jquery.1.11.js"></script>'.PHP_EOL;
			$html .= '<script src="' .$pluginPath. 'colorbox' .DS. 'jquery.colorbox-min.js" charset="'.CHARSET.'"></script>'.PHP_EOL;	
			$html .= '<script src="' .$pluginPath. 'colorbox' .DS. 'i18n' .DS. 'jquery.colorbox-'.$language.'.js"></script>'.PHP_EOL;		
			$html .= '<script type="text/javascript">
			$(document).ready(function(){
			    // initiate colorbox
				$(".albumpix").colorbox({rel:"albumpix", transition:"fade", slideshow:true, slideshowSpeed:3500, slideshowAuto:false, retinaImage:true, retinaUrl:true});
				$(".vid").colorbox({rel:"albumpix", iframe:true, width:"80%", height:"96%"});
			});
			</script>'.PHP_EOL;				
		}
		return $html;
	}	
    /**
     * Encode string to
     * $string = pluginFolioGallery::encodeto($string);
     */		
	public function encodeto($string)
	{
		$string = mb_convert_encoding(trim($string), CHARSET, 'auto');
		return $string;
	} 
    /**
     * Make thumbnails from images
     * $string = pluginFolioGallery::make_thumb($folder,$file,$dest,$thumb_width);
     */		 
	public function make_thumb($folder,$file,$dest,$thumb_width) 
	{	
		$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));	
		switch($ext)
		{
			case "jpg":
			$source_image = imagecreatefromjpeg($folder. DS .$file);
			break;
			
			case "jpeg":
			$source_image = imagecreatefromjpeg($folder. DS .$file);
			break;
			
			case "png":
			$source_image = imagecreatefrompng($folder. DS .$file);
			break;
			
			case "gif":
			$source_image = imagecreatefromgif($folder. DS .$file);
			break;
		}	
		
		$width = imagesx($source_image);
		$height = imagesy($source_image);
		
		if($width < $thumb_width) // if original image is smaller don't resize it
		{
			$thumb_width = $width;
			$thumb_height = $height;
		}
		else
		{
			$thumb_height = floor($height*($thumb_width/$width));
		}
		
		$virtual_image = imagecreatetruecolor($thumb_width,$thumb_height);
		
		if($ext == "gif" or $ext == "png") // preserve transparency
		{
			imagecolortransparent($virtual_image, imagecolorallocatealpha($virtual_image, 0, 0, 0, 127));
			imagealphablending($virtual_image, false);
			imagesavealpha($virtual_image, true);
	    }
		
		imagecopyresampled($virtual_image,$source_image,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
		
		switch($ext)
		{
		    case 'jpg': imagejpeg($virtual_image, $dest,80); break;
			case 'jpeg': imagejpeg($virtual_image, $dest,80); break;
			case 'gif': imagegif($virtual_image, $dest); break;
			case 'png': imagepng($virtual_image, $dest); break;
	    }
	
		imagedestroy($virtual_image); 
		imagedestroy($source_image);		
	}
    /**
     * Return array sorted by date or name
     * $string = pluginFolioGallery::sort_array(&$array,$dir,$sort_by_date);
     */		
	public function sort_array(&$array,$dir,$sort_by_date) 
	{ 
		// array argument must be passed as reference
		if($sort_by_date)
		{
			foreach ($array as $key=>$item) 
			{
				$stat_items = stat($dir . DS . $item);
				$item_time[$key] = $stat_items['ctime'];
			}
			return array_multisort($item_time, SORT_DESC, $array); 
		}	
		else
		{
			return usort($array, 'strnatcasecmp');
		}	
	
	}
    /**
     * Get album and image descriptions
     * $string = pluginFolioGallery::itemDescription($album, $file='');
     */		
	public function itemDescription($album, $file='')
	{
		if(file_exists($album. DS. 'descriptions.txt'))
		{
			$lines_array = file($album. DS. 'descriptions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
			if($lines_array)
			{
				if($file == '')
				{
					$album_line = explode(';', $lines_array[0]); 
					return (!empty($album_line[0]) && $album_line[0] == 'album' ? $album_line[1] : '');
				}
				else
				{
					foreach($lines_array as $img_line)
					{	
						if(!empty($img_line)) {
							$img_desc = explode(';', $img_line);	
							if($img_desc[0] == $file) { return $img_desc[1]; }
						}
					}
				}	
			}
			else
			{
				return '';
			}
		}	
	}
    /**
     * Display pagination
     * $string = pluginFolioGallery::paginate_array($numPages,$urlVars,$alb,$currentPage);
     */		
	public function paginate_array($numPages,$urlVars,$alb,$currentPage) 
	{
	   global $Page;
	        
	   $html = '';
	   
	   if ($numPages > 1) 
	   {
	   
	       if ($currentPage > 1)
		   {
		       $prevPage = $currentPage - 1;
		       $html .= '<a class="pag prev" rel="'.$alb.'" rev="'.$prevPage.'" href="'.HTML_PATH_ROOT.$Page->slug().'?'.$urlVars.'p='.$prevPage.'"></a> ';
		   }	   
		   
		   for( $i=0; $i < $numPages; $i++ )
		   {
	           $p = $i + 1;
			   $class = ($p==$currentPage ? 'current-paginate' : 'paginate'); 
			   $html .= '<a rel="'.$alb.'" rev="'.$p.'" class="'.$class.' pag" href="'.HTML_PATH_ROOT.$Page->slug().'?'.$urlVars.'p='.$p.'"></a>';	  
		   }
		   
		   if ($currentPage != $numPages)
		   {
	           $nextPage = $currentPage + 1;	
			   $html .= ' <a class="pag next" rel="'.$alb.'" rev="'.$nextPage.'" href="'.HTML_PATH_ROOT.$Page->slug().'?'.$urlVars.'p='.$nextPage.'"></a>';
		   }	  	 
	   
	   }
	   
	   return $html;
	}
	
    /**
     * Add the gallery after content page
     *
     */		
	public function pageEnd()
	{
		global $Page, $Url, $Site, $Language;
		$pluginPath = $this->htmlPath();
		
		# On charge le script uniquement sur la page en paramètre
		if($Url->whereAmI()==='page' && $Page->slug()==$this->getDbField('page'))
		{ 
			define('IMAGE_DIR',	'./bl-content/uploads/' .$this->getDbField('folder'));
			$_REQUEST['fullalbum']=1;
			
			/***** gallery settings *****/
			$mainFolder          = IMAGE_DIR; // main folder that holds albums - this folder resides on root directory of your domain
			$album_page_url      = HTML_PATH_ROOT.$Page->slug(); // url of page where gallery/albums are located 
			$no_thumb            = $pluginPath.'foliogallery/noimg.png';  // show this when no thumbnail exists 
			$extensions          = array('jpg','png','gif','JPG','PNG','GIF'); // allowed extensions in photo gallery 
			$deny_files          = array('.DS_Store','..', '.','thumbs','descriptions.txt'); // not allowed extensions in photo gallery 
			$itemsPerPage        = $this->getDbField('itemsPerPage');    // number of images per page if not already specified in ajax mode 
			$thumb_width         = $this->getDbField('thumbWidth');   // width of thumbnails in pixels
			$max_width         	 = $this->getDbField('maxWidth');   // width of full pictures in pixels
			$sort_albums_by_date = $this->getDbField('sort_albums_by_date');   
			$sort_images_by_date = $this->getDbField('sort_images_by_date');    
			$random_thumbs       = $this->getDbField('random_thumbs');   
			$show_captions       = $this->getDbField('show_captions');    
			$num_captions_chars  = $this->getDbField('numCaptionsChars');    // number of characters displayed in album and thumb captions
			/***** end gallery settings *****/			
			$numPerPage = (!empty($_REQUEST['numperpage']) ? (int)$_REQUEST['numperpage'] : $itemsPerPage);
			$fullAlbum  = (!empty($_REQUEST['fullalbum']) ? 1 : 0);
			/** 
			 * ON INCLUT LE TEMPLATE PAR DÉFAUT DU PLUG-IN OU LE TEMPLATE PERSONNALISÉ STOCKER DANS NOTRE THÈME 
			 */
		    $template = PATH_THEME_PHP. 'gallery.php';
		    if(file_exists($template))
			    include_once($template);
		    else
			    include(dirname(__FILE__). DS. 'layout/gallery.php');					    							       			
		}
	}   

}