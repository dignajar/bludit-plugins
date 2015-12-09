<?php
/**
 *  Cover image
 *
 *  @package Bludit
 *  @subpackage Plugins
 *  @author Teto Querini.
 *  @copyright 2015 Teto Querini
 * @version 0.1
 *  @release 2015-12-09
 *  @update 2015-12-09
 *
 */

class pluginCoverimage extends Plugin {

 /*private $loadWhenController = array(
  'new-post',
  'new-page',
  'edit-post',
  'edit-page'
);*/

 public function siteHead()
 {
  $GLOBALS['myCoverData'] = $this->getDbField('coverimages');
  function getCoverImage($slug){
    $mydatacovers = $GLOBALS['myCoverData'];
    $mycovers = explode(",", $mydatacovers);
    $thecover = '';
    foreach ($mycovers as $pageimage) {
     $mycoversdata = explode("|", $pageimage);
     if ( $mycoversdata[0] == $slug){
      $thecover = $mycoversdata[1];
     }
    };
    return $thecover;
  }
 }

 public function init()
 {
  $this->dbFields = array(
   'targetElement'=>'new-post,new-page,edit-post,edit-page',
   'coverimages'=> ''
  );
 }

 public function form()
 {
  global $Language;

  $html  = '<div>';
  $html .= '<label>'.$Language->get('label') . '</label>';
  $contentsType = $this->getDbField('targetElement');
  if ($contentsType == "new-page,edit-page"){
    $html .= '<input type="radio" name="targetElement" value="new-page,edit-page" checked> '.$Language->get('pages-only') . '<br>';
  } else {
		$html .= '<input type="radio" name="targetElement" value="new-page,edit-page"> '.$Language->get('pages-only') . '<br>';
	}
	if ($contentsType == "new-post,edit-post"){
  	$html .= '<input type="radio" name="targetElement" value="new-post,edit-post" checked> Posts only. '.$Language->get('posts-only') . '<br>';
	} else {
		$html .= '<input type="radio" name="targetElement" value="new-post,edit-post"> '.$Language->get('posts-only') . '<br>';
	}
	if ($contentsType == "new-post,new-page,edit-post,edit-page"){
		$html .= '<input type="radio" name="targetElement" value="new-post,new-page,edit-post,edit-page" checked> '.$Language->get('all-pages-and-posts');
	} else {
		$html .= '<input type="radio" name="targetElement" value="new-post,new-page,edit-post,edit-page"> '.$Language->get('all-pages-and-posts');
	}
  $html .= '<input name="coverimages" id="jscoverimage" type="hidden" value="'.$this->getDbField('coverimages').'">';
  $html .= '</div>';

  return $html;
 }

 public function adminHead()
 {
  global $Language;
  global $Site;
  global $layout;

  // Path plugin.
  $pluginPath = $this->htmlPath();

  $html = '';
	$contenttypes = explode(',', $this->getDbField('targetElement'));

 if(in_array($layout['controller'], $contenttypes))
  {
   $html  .= '<script src="'.$pluginPath.'js/coverimage.js"></script>'; // the cover image js

   $html  .= '<link rel="stylesheet" href="'.$pluginPath.'css/coverimage.css">'; // the cover image css
  }
  return $html;
 }

 public function adminBodyEnd()
 {
  global $Language;
  global $Site;
  global $Url;
  global $layout;
  $mydata = $this->getDbField('coverimages');
  $mytargetElement = $this->getDbField('targetElement');
  // detect current page slug
  $currentpage = $Url->slug();
  $currentpageSlugArray = explode("/", $currentpage);
  $currentpageSlug = end($currentpageSlugArray);
  $html = '';
	$contenttypes = explode(',', $this->getDbField('targetElement'));
  if(in_array($layout['controller'], $contenttypes))
  {
   $html  .= '<script>$(document).ready(function() { ';
   $html .= 'document.addEventListener("submit", function (e) {

      var coverimagesData = "";
      $("input.coverimageinput").each(function() {
       coverimagesData = $(this).val()+","+coverimagesData;
      });
       saveCoverImage( "'.$Site->url().'" ,coverimagesData , $("#targetElementData").val() , $("#jstokenCSRF").val());
      }, false);';
   $html .= '

      $("<input id=\"targetElementData\" type=\"hidden\" name=\"targetElement\" value=\"'. $mytargetElement .'\">").insertBefore(".uk-width-large-7-10 .uk-form-row:last-child");

      ';

   if ($mydata != ''){ // data from coverimages
    $mycovers = explode(",", $mydata);
    foreach ($mycovers as $pageimage) {
      $mycoversdata = explode("|", $pageimage);
      if ( $mycoversdata[0] != ""){
       if ( $mycoversdata[0] == $currentpageSlug){ // if the image is on this page
        $html .= '
        $(".coverimagecontainer").html("<div class=\"removeimage uk-button\" onClick=\"removeCoverimage();\"><i class=\"uk-icon-remove\"></i></div><img src=\"'. $mycoversdata[1] .'\" alt=\"\"><input id=\"coverimageinput\" class=\"coverimageinput\" type=\"hidden\" name=\"coverimages[]\" value=\"'. $pageimage .'\">");
        $("#jsaddImageCover").addClass("hidden");
        $("#jsremImageCover").removeClass("hidden");
        ';
       } else {
        $html .= '

        $("<input id=\"coverimageinput\" class=\"coverimageinput\" type=\"hidden\" name=\"coverimages[]\" value=\"'. $pageimage .'\">").insertBefore(".uk-width-large-7-10 .uk-form-row:last-child");

        ';
       }
      }
    };
   }
   $html .= '$("#jsaddImageCover").on("click", function() {

     var filename = $("#jsimageList option:selected" ).text();
     var pageslug = $("#jsslug" ).val();
     $("#jsaddImageCover").toggleClass("hidden");
      $("#jsremImageCover").toggleClass("hidden");
     if(!filename.trim()) {
      return false;
     }
     $(".coverimagecontainer").html("<div class=\"removeimage uk-button\" onClick=\"removeCoverimage();\"><i class=\"uk-icon-remove\"></i></div><img src=\"'. HTML_PATH_UPLOADS .'"+filename+"\" alt=\"\"><input id=\"coverimageinput\" class=\"coverimageinput\" type=\"hidden\" name=\"coverimages[]\" value=\""+pageslug+"|'. HTML_PATH_UPLOADS .'"+filename+"\">");
   });';

   $html .= '}); </script>';

  }
  return $html;
 }
}
