<?php

class pluginVanilla extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'vanilla-url'=>'http'
		);
	}

	public function form()
	{
		global $Language;

        $html = '<div>';
        $html .= '<label for="vanilla-url">'.$Language->get('URL of Vanilla Forums').'</label>';
                $html .= '<input type="text" name="vanilla-url" value="'.$this->getDbField('vanilla-url').'" />';
                $html .= '</div>';
                return $html;

		return $html;
	}

	public function postEnd()
	{
		global $Post;

        $key = $Post->key();

		$html = '<div id="vanilla-comments"></div>
		        <script type="text/javascript">

                var vanilla_forum_url = "'.$this->getDbField('vanilla-url').'";
                var vanilla_identifier = "'.$key.'";

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
