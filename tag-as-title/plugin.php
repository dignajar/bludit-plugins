<?php

class pluginTagTitle extends Plugin {

	public function postBegin() {
	  global $dbTags;

    $db = $dbTags->db['postsIndex'];

    $tag_slug = $_SERVER['REQUEST_URI'];
    $tag_url = strpos($tag_slug, "/tag/");

    if ($tag_url !== false) {

      $tag_pos = strrpos($tag_slug, "/");
      $tag_slug = substr($tag_slug, $tag_pos+1);
      $tag_url = strpos($tag_slug, "?");

        if ($tag_url === false) {

          $tagtitle = $db[$tag_slug]['name'];

          $html = '<div style="margin-bottom: 50px;">';
			    $html .= '<h1>'.$tagtitle.'</h1>';
          $html .= '</div>';

			    return $html;

        }

        else {

            $tag_pos1 = strrpos($tag_slug, "?");
            $tag_slug = substr($tag_slug, 0, $tag_pos1);
        	  $tagtitle = $db[$tag_slug]['name'];

        	  $html = '<div style="margin-bottom: 50px;" class="tag-title">';
			      $html .= '<h1>'.$tagtitle.'</h1>';
        	  $html .= '</div>';

			      return $html;

            }

	      }

	  }

}
