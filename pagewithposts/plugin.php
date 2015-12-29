<?php

class pluginPagewithPosts extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'blogpage'=>'hauptseite'
		);
	}

	public function form()
	{

	global $Language;
	global $pagesParents;

    echo $Language->get('Select the page for displaying posts');

    $html  = '<div>';
    $html .= '<label for="post-page">'.$Language->get('post-page').'</label>';
    $html .= '<select name="blogpage">';
    $html .= '<option value="'.$this->getDbField('blogpage').'" selected>'.$this->getDbField('blogpage').'</option>';


	foreach($pagesParents as $parentKey=>$pageList)
	{
		foreach($pageList as $Page)
		{

			$html  .= '<option value="'.$Page->title().'">'.$Page->title().'</option>';

		}
	}

	$html  .= '</select>';
	$html  .= '</div>';
	return $html;

	}

	public function siteHead(){

		$html  = '<script src="https://code.jquery.com/jquery-1.10.2.js"></script>';
		return $html;

	}

	public function pageEnd() {

    global $Language;
    global $Page;
    global $posts;

		if ($Page->title() == $this->getDbField('blogpage')) {

    		include(PATH_THEME_PHP.'home.php');
    		include('includes/pagination.php');

		}

	}

}
