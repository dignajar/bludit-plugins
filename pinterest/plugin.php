<?php
class pluginPinterest extends Plugin {
	public function init()
	{
		$this->dbFields = array(
			'pinterest-verification-code'=>'1234567'
		);
	}
	public function form()
	{
		global $Language;
		$html  = '<div>';
		$html .= '<label for="pinterest-verification-code">'.$Language->get('Pinterest Verification Code').'</label>';
		$html .= '<input type="text" name="pinterest-verification-code" value="'.$this->getDbField('pinterest-verification-code').'" />';
		$html .= '<div class="tip">'.$Language->get('complete-this-field-with-the-pinterest-verification-code').'</div>';
		$html .= '</div>';
		return $html;
	}
	public function siteHead()
	{
		$html  = PHP_EOL.'<!-- Pinterest Verification -->'.PHP_EOL;
		$html .= '<meta name="p:domain_verify" content="'.$this->getDbField('pinterest-verification-code').'">'.PHP_EOL;
		if(Text::isEmpty($this->getDbField('pinterest-verification-code'))) {
			return false;
		}
		return $html;
	}
}
