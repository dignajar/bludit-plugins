/**
 * simplemde v0.0.1
 * Copyright Teto Querini.
 * @link http://www.freeco.it/teto
 * @license MIT
 */
$(document).ready(function() {
  $( "#jsaddImage" ).after( "</div><div class=\"uk-form-row uk-margin-top\"><label class=\"coverimageinfo uk-form-label\">Cover image</label><p class=\"uk-form-help-block\">The cover image is an image that rapresent your page or post content.</p></div><div class=\"uk-form-row uk-margin-top\"><div id=\"jsremImageCover\" class=\"hidden uk-button\" onClick=\"removeCoverimage();\">Remove Cover Image</div><button id=\"jsaddImageCover\" class=\"uk-button uk-button-primary\" type=\"button\">Add image as cover</button>" );
  $( '<div class="uk-form-row uk-margin-top uk-margin-bottom coverimagecontainer"><label id="coverimageinfo" class="coverimageinfo uk-form-label">Go to images tab to add a cover image.</label></div>' + '\n' ).insertBefore(".uk-width-large-7-10 .uk-form-row:last-child");
});
function removeCoverimage(){
  $(".coverimagecontainer").html("<label id=\"coverimageinfo\" class=\"coverimageinfo uk-form-label\">Go to images tab to add a cover image.</label>");
  $("#jsaddImageCover").toggleClass("hidden");
  $("#jsremImageCover").toggleClass("hidden");
};
function saveCoverImage(urlcover,coverimagesdata,targetElementdata,jstokenCSRF){
  var formData = {coverimages:coverimagesdata,targetElement:targetElementdata,tokenCSRF:jstokenCSRF};
  var urlcover = urlcover + 'admin/configure-plugin/pluginCoverimage';
  $.ajax({
      url : urlcover,
      type: "POST",
      data : formData,
      success: function(data, textStatus, jqXHR){
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert("Error in cover image.");
      }
  });
}
