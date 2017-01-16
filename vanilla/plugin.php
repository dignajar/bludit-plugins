<?php

class pluginVanilla extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'homeLink'=>1,
			'label'=>'Pages'
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label>'.$Language->get('Plugin label').'</label>';
		$html .= '<input name="label" id="jslabel" type="text" value="'.$this->getDbField('label').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input type="hidden" name="homeLink" value="0">';
		$html .= '<input name="homeLink" id="jshomeLink" type="checkbox" value="1" '.($this->getDbField('homeLink')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jshomeLink">'.$Language->get('Show home link').'</label>';
		$html .= '</div>';

		return $html;
	}

	public function postEnd()
	{
		global $Post;

        $key = $Post->key();

		$html = '<div id="vanilla-comments"></div>
		        <script type="text/javascript">

		        /*** Required Settings: Edit BEFORE pasting into your web page ***/
            var vanilla_forum_url = ""; // The full http url & path to your vanillaforum
            var vanilla_identifier = "'.$key.'"; // Your unique identifier for the content being commented on

            /*** Optional Settings: Ignore if you like ***/
            // var vanilla_discussion_id = ""; // Attach this page of comments to a specific Vanilla DiscussionID.
            // var vanilla_category_id = ""; // Create this discussion in a specific Vanilla CategoryID.

            /*** DON"T EDIT BELOW THIS LINE ***/
            (function() {
            var vanilla = document.createElement("script");
            vanilla.type = "text/javascript"; var timestamp = new Date().getTime();
            vanilla.src = vanilla_forum_url + "/js/embed.js";
            (document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(vanilla);
            })();
            </script>
            <noscript>Please enable JavaScript to view the comments.</noscript>';

		return $html;

	}
}
