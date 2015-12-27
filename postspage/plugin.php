<?php

class pluginPostsPage extends Plugin {

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

	public function pageEnd() {

    global $Language;
    global $Page;
	global $posts;

	if ($Page->title() == $this->getDbField('blogpage')) {

	foreach ($posts as $Post) {
?>

    	<section class="post">

		    <!-- Plugins Post Begin -->
		    <?php Theme::plugins('postBegin') ?>

		    <!-- Post header -->
		    <header class="post-header">

		        <!-- Post title -->
		        <h2 class="post-title">
		            <a href="<?php echo $Post->permalink() ?>"><?php echo $Post->title() ?></a>
		        </h2>

		        <!-- Post date and author -->
		        <div class="post-meta">
		            <span class="date"><?php echo $Post->date() ?></span>
		            <span class="author">
		                <?php
		                    echo $Language->get('Posted By').' ';

		                    if( Text::isNotEmpty($Post->authorFirstName()) || Text::isNotEmpty($Post->authorLastName()) ) {
		                        echo $Post->authorFirstName().' '.$Post->authorLastName();
		                    }
		                    else {
		                        echo $Post->username();
		                    }
		                ?>
		            </span>
		        </div>

		    </header>

		    <!-- Post content -->
		    <div class="post-content">
		        <?php
		            // Call the method with FALSE to get the first part of the post
		            echo $Post->content(false)
		        ?>
		    </div>

		    <?php if($Post->readMore()) { ?>
		    <a class="read-more" href="<?php echo $Post->permalink() ?>"><?php $Language->printMe('Read more') ?></a>
		    <?php } ?>

		    <!-- Plugins Post End -->
		    <?php Theme::plugins('postEnd') ?>

		</section>

<?php

		}

	    echo Paginator::html();

	    }

	}

}
