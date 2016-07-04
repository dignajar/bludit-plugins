<?php

class pluginUniversalAnalytics extends Plugin {
	// Plugin datas
	public function init()
	{
		$this->dbFields = array(
			'id'=>'UA-XXXXXXXX-1'  // <= Your Google Analytics ID
			);
	}
	// Backend configuration page
	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label for="id">'.$Language->get('Your Google Analytics ID');
		$html .= '<input type="text" name="id" value="'.$this->getDbField('id').'" />';
		$html .= '</label>';
		$html .= '</div>';

		return $html;
	}
	// Show in Public theme head	
	public function siteHead()
	{
		$html  = PHP_EOL.'<!-- Universal Analytics -->'.PHP_EOL;
		$html .= '<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

  ga(\'create\', \''.$this->getDbField('id').'\', \'auto\');
  ga(\'send\', \'pageview\');

</script>'.PHP_EOL;

		return $html;
	}
}