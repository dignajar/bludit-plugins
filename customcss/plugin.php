<?php

class pluginCustomCSS extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'ccss'=>''
		);
	}

	public function form()
	{
		global $Language;

?>

	<script src="/bl-plugins/customcss/lib/codemirror.js"></script>
	<link rel="stylesheet" href="/bl-plugins/customcss/lib/codemirror.css">
	<script src="/bl-plugins/customcss/mode/javascript/javascript.js"></script>
	<style>
	    .CodeMirror {
	        border: solid 1px black;
	        width: 50%;
	        margin-bottom: 20px !important;
	    }
		#jsformplugin div {
			margin-bottom: 0;
	    }
	</style>
	<div>
	<label><?php $Language->get('Custom CSS') ?></label>
	<textarea name="ccss" id="ccss"}><?php echo $this->getDbField('ccss') ?></textarea>
	</div>

	<script>
	  var editor = CodeMirror.fromTextArea(document.getElementById("ccss"), {
	    lineNumbers: true,
	    styleActiveLine: true,
	    matchBrackets: true
	  });
	</script>

<?php

	}

	public function siteHead(){

		$html  = '<style>';
		$html  .= ($this->getDbField('ccss'));
		$html  .= '</style>';
		return $html;

	}

}
