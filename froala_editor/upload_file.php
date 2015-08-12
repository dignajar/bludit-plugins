<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');	
	
	// Security constant
	define('BLUDIT', true);		
	
	// Directory separator
	define('DS', DIRECTORY_SEPARATOR);

	// PHP paths
	define('PATH_ROOT', '..'.DS.'..'.DS);
	define('PATH_BOOT',	PATH_ROOT.'kernel'.DS.'boot'.DS);

	// Init
	require(PATH_BOOT.'init.php');
	
    // Allowed extentions.
    $allowedExts = array("txt", "pdf", "doc");

    // Get filename.
    $temp = explode(".", $_FILES["file"]["name"]);

    // Get extension.
    $extension = end($temp);

    // Validate uploaded files.
    // Do not use $_FILES["file"]["type"] as it can be easily forged.
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

    if ((($mime == "text/plain")
    || ($mime == "application/msword")
    || ($mime == "application/x-pdf")
    || ($mime == "application/pdf"))
    && in_array($extension, $allowedExts)) {
        // Generate new random name.
        $name = sha1(microtime()) . "." . $extension;

        // Save file in the uploads folder.
        move_uploaded_file($_FILES["file"]["tmp_name"], PATH_UPLOADS. $name);

        // Generate response.
        $response = new StdClass;
        $response->link = PATH_UPLOADS. $name;
        echo stripslashes(json_encode($response));
    }
?>