<?php
/**
 * Backup
 *
 * @author 		Frédéric K.
 * @copyright	(c) 2015
 * @license		http://opensource.org/licenses/MIT
 * @package		Bludit CMS
 * @version		0.4
 * @update		2015-08-08
 */		
define('BACKUP_FOLDER',		'backups' .DS);	
define('PATH_BACKUP',		PATH_ROOT. BACKUP_FOLDER);
class pluginBackup extends Plugin {	
	
	// Plugin datas
	public function init()
	{
		if(!is_dir(PATH_BACKUP) && (!@mkdir(PATH_BACKUP) || !@chmod(PATH_BACKUP, 0777)));
        if (!file_exists(PATH_BACKUP. 'index.html')) {
			$f = fopen(PATH_BACKUP. 'index.html', 'a+');
			fwrite($f, '');
			fclose($f);	
		}		
		$this->dbFields = array(
			'dataPath'		=> PATH_BACKUP  // <= Folder data to backup
		);
	}
	// Get full path url
	public function full_path()
	{
	    $s = &$_SERVER;
	    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
	    $sp = strtolower($s['SERVER_PROTOCOL']);
	    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
	    $port = $s['SERVER_PORT'];
	    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':' .$port;
	    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
	    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
	    $uri = $protocol . '://' . $host . $s['REQUEST_URI'];
	    $segments = explode('?', $uri, 2);
	    $url = $segments[0];
	    return $url;
	}	
	// Archive Content Folder
    public function zipData($source, $destination) 
    {
		global $Language;
		$archiveName = 'backup-' .time(). '.zip'; // Archive name
			    
        if (extension_loaded('zip')) {
            if (file_exists($source)) {
                $zip = new ZipArchive();
                if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
                    $source = realpath($source);
                    if (is_dir($source)) {
                        $iterator = new RecursiveDirectoryIterator($source);
                        // skip dot files while iterating 
                        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
                        $files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } else if (is_file($file)) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source)) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }              				
				if (!$zip->close()) {
					Alert::set($Language->get("There was a problem writing the ZIP archive."));
					Redirect::page('admin', 'configure-plugin/pluginBackup');
				} else {
					Alert::set($Language->get("Successfully created the ZIP Archive!"));
					Redirect::page('admin', 'configure-plugin/pluginBackup');
				}  
				// close the zip file
				$zip->close();  				            
            }
        }
        return false;
    }
	// List Files
	public function list_zipfiles($mydirectory) 
	{	
		global $Site, $Language;	
					
		$html = '<table class="table-container table-hovered">
	<thead>
		<tr>
			<th>' .$Language->get("Archives"). '</th>
			<th>' .$Language->get("File Size"). '</th>
			<th>' .$Language->get("Date"). '</th>
			<th>' .$Language->get("Actions"). '</th>
		</tr>
	</thead>
	<tbody>';
		// directory we want to scan
		$dircontents = scandir($mydirectory);	
		// list the contents
		foreach ($dircontents as $file) {
			$extension = pathinfo($file, PATHINFO_EXTENSION);
			$filesize = pluginBackup::getFilesize(PATH_BACKUP.$file);
			$date = filemtime(PATH_BACKUP.$file);
			clearstatcache();
	    	/* Files list */			
			$html .= '<tr>';
				if ($extension == 'zip') {
					$html .= '<td><strong>' .$file. '</strong></td>';
					$html .= '<td><span class="label label-outline label-black">' .$filesize. '</span></td>';
					$html .= '<td><em>' .date('F d Y h:i A', $date). '</em></td>';
					$html .= '<td><span class="btn-group">';					
					$html .= '<a class="btn btn-smaller" href="' .$Site->url().BACKUP_FOLDER.$file. '"><i class="fa fa-cloud-download"></i> ' .$Language->get("Download"). '</a>';
					$html .= '<a class="btn btn-smaller btn-green" href="' .pluginBackup::full_path(). '?restore=' .PATH_BACKUP.$file. '" onclick = "if(!confirm(\'' .$Language->get("Do you want to restore this backup?"). '\')) return false;"><i class="fa fa-undo"></i></i> ' .$Language->get("Restore"). '</a>';
					$html .= '<a class="btn btn-smaller btn-red" href="' .pluginBackup::full_path(). '?delete=' .PATH_BACKUP.$file. '" onclick = "if(!confirm(\'' .$Language->get("Delete this backup?"). '\')) return false;"><i class="fa fa-trash-o"></i> ' .$Language->get("Delete"). '</a>';
					$html .= '</span><td>';
				}
			$html .= '</tr>';			
		}
		$html .= '	</tbody>
</table>';

			/* Action files */
	    	if (isset($_GET['delete'])) pluginBackup::del($_GET['delete']);	
	    	if (isset($_GET['restore'])) pluginBackup::restore($_GET['restore']);
	    		    		
		return $html;
	}
    /**
     * Recursively deletes a directory
     *
     * @param  string  path to a directory
     * @return void
     */
    public function removeDir($dir) 
    {
		if ($handle = opendir($dir)){
		$array = array();		 
		    while (false !== ($file = readdir($handle))) {
		        if ($file != "." && $file != "..") {
		 
		            if(is_dir($dir.$file))
		            {
		                if(!@rmdir($dir.$file)) // Empty directory? Remove it
		                {
		                	pluginBackup::removeDir($dir.$file. '/'); // Not empty? Delete the files inside it
		                }
		            }
		            else
		            {
		               @unlink($dir.$file);
		            }
		        }
		    }
		    closedir($handle);		 
		    @rmdir($dir);
		}
	}	   
	// Delete a File
	public function del($file) 
	{	
		global $Language;
		$serveur = pluginBackup::full_path(); // redirection	
	
        if(file_exists($file)) unlink($file);       	
		if($file){
			Alert::set($Language->get("Successfully deleted file!"));
			Redirect::page('admin', 'configure-plugin/pluginBackup');		
		} else {
			Alert::set($Language->get("An error occurred while deleting the file."));
			Redirect::page('admin', 'configure-plugin/pluginBackup');		
		}
	} 	 
	// Restore a archive
	public function restore($file) 
	{	
		global $Language;	
	
		// get the absolute path to $file
		$path = PATH_CONTENT;
		$serveur = pluginBackup::full_path(); // redirection
		
		$zip = new ZipArchive;
		$res = $zip->open($file);		
		$removeDir = pluginBackup::removeDir($path);
		if ($res === TRUE) {
		  $removeDir;
          if(!is_dir($path) && (!@mkdir($path) || !@chmod($path, 0777)));
		  // extract it to the path we determined above
		  $zip->extractTo($path);
		  $zip->close();
		    Alert::set($Language->get("Archive is restored!"));
		    Redirect::page('admin', 'configure-plugin/pluginBackup');
		} else {
			Alert::set($Language->get("There was a problem to restore the ZIP archive"));
			Redirect::page('admin', 'configure-plugin/pluginBackup');	
		}	
	} 		
	/*
	 * @param string $file Filepath
	 * @param int $digits Digits to display
	 * @return string|bool Size (KB, MB, GB, TB) or boolean
	 */	
	public function getFilesize($file,$digits = 2) {
	       if (is_file($file)) {
	               $filePath = $file;
	               if (!realpath($filePath)) {
	                       $filePath = $_SERVER["DOCUMENT_ROOT"].$filePath;
	       }
	           $fileSize = filesize($filePath);
	               $sizes = array("TB","GB","MB","KB","B");
	               $total = count($sizes);
	               while ($total-- && $fileSize > 1024) {
	                       $fileSize /= 1024;
	                       }
	               return round($fileSize, $digits)." ".$sizes[$total];
	       }
	       return false;
	}			
	// Backend configuration page
	public function form()
	{
		global $Language;
		$archiveName = 'backup-' .time(). '.zip'; // Archive name
		
		$html  = '';
		if (file_exists(PATH_BACKUP)) $html .= pluginBackup::list_zipfiles(PATH_BACKUP);		
		$html .= '<div class="unit-100">';
		$html .= '<button class="btn btn-blue" type="submit" name="backup"><i class="fa fa-life-ring"></i> ' .$Language->get("Make a backup"). '</button>';
		$html .= '</div>';
		$html .= '<style type="text/css" scoped>button[name="publish"] {display:none};</style>';
		if (isset($_POST['backup'])) pluginBackup::zipData(PATH_CONTENT, PATH_BACKUP.$archiveName);
		
		return $html;
	}
    
}