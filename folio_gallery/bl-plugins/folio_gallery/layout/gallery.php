<?php 
/**
 *  Gallery layout
 *
 *  @package: Bludit
 *  @subpackage: Plugin
 *  @author: Frédéric K.
 *  @copyright: 2015-2016 Frédéric K.
 *  @info: Duplicate this layout in your themes/YOUR_THEME/php/ 
 *	for a custom template.
 */
?>
      
<div class="fg">

<?php
if (empty($_REQUEST['album'])) // if no album requested, show all albums
{		
	
	$albums = array_diff(scandir($mainFolder), $deny_files);
	$numAlbums = count($albums);
	 
	if($numAlbums == 0) 
	{ ?>
		
		<div class="titlebar"><p><?php echo $Language->g('No albums posted'); ?></p></div>
    
	<?php
	}
	else
	{
		pluginFolioGallery::sort_array($albums,$mainFolder,$sort_albums_by_date); // rearrange array either by date or name
		$numPages = ceil( $numAlbums / $numPerPage );
		
		if(isset($_REQUEST['p']))
		 {
		 	$currentPage = ((int)$_REQUEST['p'] > $numPages ? $numPages : (int)$_REQUEST['p']); 
         } 
		 else 
		 {
		 	$currentPage=1;
         }
		
		$start = ($currentPage * $numPerPage) - $numPerPage; ?>
	     
		<div class="p10-lr">
        	<span class="title"><?php echo $Language->g('Photo Gallery'); ?></span> - <?php echo $numAlbums; ?> <?php echo $Language->g('albums'); ?>
        </div>
	  
        <div class="clear"></div>
	  	 
		<?php 			 
	    for( $i=$start; $i<$start + $numPerPage; $i++ )
		{
	  						
			if(isset($albums[$i])) 
			{  
				$thumb_pool = glob($mainFolder. DS .$albums[$i]. DS. 'thumbs/*{.'.implode(",", $extensions).'}', GLOB_BRACE);
				
				if (count($thumb_pool) == 0)
				{ 
					$album_thumb = $no_thumb;
				}
				else
				{	
					$album_thumb = ($random_thumbs ? $thumb_pool[array_rand($thumb_pool)] : $thumb_pool[0]); // display a random thumb or the 1st thumb					
				} ?>
			 		 			 
				<div class="thumb-wrapper">
					<div class="thumb">
					   <a class="showAlb" rel="<?php echo $albums[$i]; ?>" href="<?php echo HTML_PATH_ROOT.$Page->slug(); ?>?album=<?php echo urlencode($albums[$i]); ?>">
					     <img src="<?php echo $album_thumb; ?>" alt="<?php echo $albums[$i]; ?>" /> 
					   </a>	
					</div>
					<div class="caption"><?php echo substr($albums[$i],0,$num_captions_chars); ?></div>
				</div>
	
			<?php
			}
		
		}
		?>
	      
		 <div class="clear"></div>
  
         <div align="center" class="paginate-wrapper">
        	<?php
				$urlVars = "";
				$alb = "";
	            echo pluginFolioGallery::paginate_array($numPages,$urlVars,$alb,$currentPage);
			?>
         </div>   
    <?php
	}

} 
else //display photos in album 
{

	$albums_in_maindir = scandir($mainFolder);	
	$requested_album = Sanitize::html($_REQUEST['album']); // xss prevention
	
	// check requested album against directory traverse
	if (!in_array($requested_album, $albums_in_maindir)) { ?>
        <span class="title"><?php echo $Language->g('Photo Gallery'); ?> &raquo; <a href="<?php echo $album_page_url; ?>" class="refresh"><?php echo $Language->g('Index'); ?></a></span>
		<p></p>
		<?php die('Invalid Request');
	}
	
	$album = $mainFolder. DS .$requested_album;
	$scanned_album = scandir($album);
	
	$files = array_diff($scanned_album, $deny_files);
	$numFiles = count($files); ?>
	 
	<div class="p10-lr">
		<?php if($fullAlbum==1) { ?>
			<span class="title"><a href="<?php echo $album_page_url; ?>" class="refresh"><?php echo $Language->g('Index'); ?></a></span>
			<span class="title">&raquo;</span>
		<?php } ?>
		<span class="title"><?php echo $requested_album; ?></span> - <?php echo $numFiles; ?> <?php echo $Language->g('images'); ?>
	</div>  
	   
	<div class="clear"></div>
	
	<?php
	if($numFiles == 0)
	{ ?>
	    
		 <div class="p10-lr"><p><?php echo $Language->g('There are no images in this album.'); ?></p></div>
	
	<?php
	}
	else	
	{			
		pluginFolioGallery::sort_array($files,$album,$sort_images_by_date); // rearrange array either by date or name
		$numPages = ceil( $numFiles / $numPerPage );
		
		if(isset($_REQUEST['p']))
		{
			$currentPage = ((int)$_REQUEST['p'] > $numPages ? $numPages : (int)$_REQUEST['p']);
		} 
		 else
		{
		 	$currentPage=1;
		}
		 			 
		$start = ($currentPage * $numPerPage) - $numPerPage;
		
		if (!is_dir($album. DS. 'thumbs')) 
		{
			mkdir($album. DS. 'thumbs');
			chmod($album. DS. 'thumbs', 0777);
			//chown($album.'/thumbs', 'apache'); 
		}	 	

		for( $i=0; $i <= $numFiles; $i++ )
		{   
			if(isset($files[$i]) && is_file($album .DS. $files[$i]))
			{   
				$info = getimagesize($album .DS. $files[$i]);
				$info_width = $info[0];
				if ( intval($info_width) > $max_width )
					pluginFolioGallery::make_thumb($album,$files[$i],$album. DS .$files[$i],$max_width);	
						    
				$thumb_url_end = '</a>';
				$ext = strtolower(pathinfo($files[$i], PATHINFO_EXTENSION));
				$prefix = substr($files[$i], 0, -(strlen($ext)+1));
				$prefix_begin = mb_substr($prefix, 0, 6); // 1st 6 characters of caption			
			    $full_caption = (pluginFolioGallery::itemDescription($album, $files[$i]) ? pluginFolioGallery::itemDescription($album, $files[$i]) : $prefix); // image captions
				$num_chars = strlen($full_caption);
				$caption = ($num_chars > $num_captions_chars ? substr($full_caption,0,$num_captions_chars). '…' : $full_caption);
				$caption = pluginFolioGallery::encodeto($caption);
					
				switch($prefix_begin)
				{
					case "utube-":
					$video_id = explode('utube-', $prefix);
					$video_id = $video_id[1];
					$thumb_url_start = '<a href="http://www.youtube.com/embed' .DS .$video_id.'?rel=0&amp;wmode=transparent" title="'.$caption.'" class="albumpix vid">';
					break;
					
					case "vimeo-":
					$video_id = explode('vimeo-', $prefix);
					$video_id = $video_id[1];
					$thumb_url_start = '<a href="http://player.vimeo.com/video' .DS .$video_id.'" title="'.$caption.'" class="albumpix vid">';
					break;
					
					default:
					$thumb_url_start = '<a href="'.$album. DS .$files[$i].'" title="'.$caption.'" class="albumpix">';
					break;
				}
									
				if(in_array($ext, $extensions)) 
				{  				  					   
					$thumb = $album. DS . 'thumbs' .DS .$files[$i];
					if (!file_exists($thumb))
					{
						pluginFolioGallery::make_thumb($album,$files[$i],$thumb,$thumb_width); 
					}	   
				   
					if($i<$start || $i>=$start + $numPerPage) { ?><div style="display:none;"><?php } ?>
					<div class="thumb-wrapper">
						<div class="thumb">
							<?php echo $thumb_url_start; ?><img src="<?php echo $thumb; ?>" alt="<?php echo $files[$i]; ?>" /><?php echo $thumb_url_end; ?>
						</div> 
						<?php if($show_captions) { ?>
							<div class="caption">
								<?php if($num_chars > $num_captions_chars) { ?>
									<div class="tooltip-container"><?php echo $caption; ?><span class="tooltip"><?php echo $full_caption; ?></span></div>
								<?php } else { echo $caption; } ?>
							</div>
						<?php } ?> 
					</div>
					<?php if($i<$start || $i>=$start + $numPerPage) { ?></div><?php }
				}
			
			} 
			
		}
		
		?> 
	
		<div class="clear"></div>
		  
		<div class="paginate-wrapper">
			<?php	 
			$urlVars = "album=".urlencode($requested_album)."&amp;";
			echo pluginFolioGallery::paginate_array($numPages,$urlVars,$requested_album,$currentPage);
			?>
		</div>
		
		<?php echo (file_exists($album. DS .'descriptions.txt') ? '<div class="description-wrapper">'.pluginFolioGallery::encodeto(pluginFolioGallery::itemDescription($album)).'</div>' : ''); //display album description ?>
	 
	<?php	 
	} // end if numFiles not 0	 

}
?>
</div>