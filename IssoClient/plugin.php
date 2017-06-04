<?php

class pluginIsso extends Plugin {

	private $enable;

	public function init()
	{
		$this->dbFields = array(
			'enablePages'=>0,
			'enablePosts'=>0,
			'enableDefaultHomePage'=>1,
			'pathData'=>'',
			'pathSrc'=>'',
			'pathCss'=>'',
			'dataLang'=>'',
			'dataReplySelf'=>'false',
			'dataRequireAuthor'=>'true',
			'dataRequireEmail'=>'false',
			'dataCommentsTop'=>'10',
			'dataCommentsNested'=>'5',
			'dataRevealClick'=>'5',
			'dataAvatar'=>'true',
			'dataAvatarBg'=>'',
			'dataAvatarFg'=>'',
			'dataVote'=>'true'
		);
	}

	function __construct()
	{
		parent::__construct();

		global $Url;

		$this->enable = false;

		if( $this->getDbField('enablePosts') && ($Url->whereAmI()=='post') ) {
			$this->enable = true;
		}
		elseif( $this->getDbField('enablePages') && ($Url->whereAmI()=='page') ) {
			$this->enable = true;
		}
		elseif( $this->getDbField('enableDefaultHomePage') && ($Url->whereAmI()=='home') ) {
			$this->enable = true;
		}
	}

	public function form()
	{
		global $Language;
		
		$html = '<div style="margin: 2em 0;">';
		$html .= '<i>'.$Language->get('intro-header').'</i>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePages" type="hidden" value="0">';
		$html .= '<input name="enablePages" id="jsenablePages" type="checkbox" value="1" '.($this->getDbField('enablePages')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('enable-on-page').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enablePosts" type="hidden" value="0">';
		$html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="1" '.($this->getDbField('enablePosts')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('enable-on-post').'</label>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<input name="enableDefaultHomePage" type="hidden" value="0">';
		$html .= '<input name="enableDefaultHomePage" id="jsenableDefaultHomePage" type="checkbox" value="1" '.($this->getDbField('enableDefaultHomePage')?'checked':'').'>';
		$html .= '<label class="forCheckbox" for="jsenableDefaultHomePage">'.$Language->get('enable-on-default-page').'</label>';
		$html .= '</div>';
		
		$html .= '<p><h3>'.$Language->get('required-settings').':</h3></p>';
		
		$html .= '<div>';
		$html .= '<label>data-isso: '.$Language->get('path-to-data').'</label>';
		$html .= '<input name="pathData" id="jsdata" type="text" value="'.$this->getDbField('pathData').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>src: '.$Language->get('path-to-script').'</label>';
		$html .= '<input name="pathSrc" id="jssource" type="text" value="'.$this->getDbField('pathSrc').'">';
		$html .= '</div>';
		

		$html .= '<p><h3>'.$Language->get('optional-settings').':</h3></p>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-reply-to-self: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataReplySelf" id="jsdatareplyself_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataReplySelf') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataReplySelf" id="jsdatareplyself_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataReplySelf') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-require-author: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataRequireAuthor" id="jsdatarequireauthor_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataRequireAuthor') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataRequireAuthor" id="jsdatarequireauthor_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataRequireAuthor') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-require-email: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataRequireEmail" id="jsdatarequireemail_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataRequireEmail') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataRequireEmail" id="jsdatarequireemail_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataRequireEmail') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-vote: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataVote" id="jsdatavote_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataVote') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataVote" id="jsdatavote_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataVote') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-avatar: ['.$Language->get('true').'/'.$Language->get('false').']</label>';
		$html .= '<input name="dataAvatar" id="jsdataavatar_1" type="radio" value="true" ';
		$html .= (($this->getDbField('dataAvatar') == 'true')?'checked':'').'> '.$Language->get('true').'</br>';
		$html .= '<input name="dataAvatar" id="jsdataavatar_2" type="radio" value="false" ';
		$html .= (($this->getDbField('dataAvatar') == 'false')?'checked':'').'> '.$Language->get('false').'</br>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>data-isso-avatar-fg: ['.$Language->get('color-code').']</label>';
		$html .= '<input name="dataAvatarFg" id="jsdataavatarfg" type="text" value="'.$this->getDbField('dataAvatarFg').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-avatar-bg: ['.$Language->get('color-code').']</label>';
		$html .= '<input name="dataAvatarBg" id="jsdataavatarbg" type="text" value="'.$this->getDbField('dataAvatarBg').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-lang: ['.$Language->get('language-code').']</label>';
		$html .= '<input name="dataLang" id="jsdatalang" type="text" value="'.$this->getDbField('dataLang').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-max-comments-top: ['.$Language->get('number').']</label>';
		$html .= '<input name="dataCommentsTop" id="jsdatacommentstop" type="number" min="0" value="'.$this->getDbField('dataCommentsTop').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-max-comments-nested: ['.$Language->get('number').']</label>';
		$html .= '<input name="dataCommentsNested" id="jsdatacommentsnested" type="number" min="0" value="'.$this->getDbField('dataCommentsNested').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>data-isso-reveal-on-click: ['.$Language->get('number').']</label>';
		$html .= '<input name="dataRevealClick" id="jsdatarevealclick" type="number" min="0" value="'.$this->getDbField('dataRevealClick').'">';
		$html .= '</div>';
		
		$html .= '<div>';
		$html .= '<label>'.$Language->get('path-to-css').'</label>';
		$html .= '<input name="pathCss" id="jsdatacss" type="text" value="'.$this->getDbField('pathCss').'">';
		$html .= '</div>';

		return $html;
	}

	public function postEnd()
	{
		global $Language;

		if( $this->enable ) {
			$html = '<section id="isso-thread"></section>';
			$html .= '<noscript>'.$Language->get('no-script-msg');
			$html .= '</noscript>';
			return $html;
		}

		return false;
	}

	public function pageEnd()
	{
		global $Url;
		global $Language;

		// Bludit check not-found page after the plugin method construct.
		// It's necesary check here the page not-found.

		if( $this->enable && !$Url->notFound()) {
			$html = '<section id="isso-thread"></section>';
			$html .= '<noscript>'.$Language->get('no-script-msg');
			$html .= '</noscript>';
			return $html;
		}

		return false;
	}

	public function siteHead()
	{
		if( $this->enable ) {
			$html = '<style>#isso-thread { margin: 20px 0 !important }</style>';
			
			if( !Text::isEmpty($this->getDbField('pathCss')) ) {
			    $html .= '<link rel="stylesheet" href="'.trim($this->getDbField('pathCss')).'">';
			}
			
			$html .= '<script ';
			$html .= 'data-isso="'.$this->getDbField('pathData').'" ';
			$html .= 'src="'.$this->getDbField('pathSrc').'" ';
			
			if( $this->getDbField('dataReplySelf') == 'true' || $this->getDbField('dataReplySelf') == 'false' ) {
			    $html .= 'data-isso-reply-to-self="'.$this->getDbField('dataReplySelf').'" ';
			}
			
			if( $this->getDbField('dataRequireAuthor') == 'true' || $this->getDbField('dataRequireAuthor') == 'false' ) {
			    $html .= 'data-isso-require-author="'.$this->getDbField('dataRequireAuthor').'" ';
			}
			
			if( $this->getDbField('dataRequireEmail') == 'true' || $this->getDbField('dataRequireEmail') == 'false' ) {
			    $html .= 'data-isso-require-email="'.$this->getDbField('dataRequireEmail').'" ';
			}
			
			if( $this->getDbField('dataVote') == 'true' || $this->getDbField('dataVote') == 'false' ) {
			    $html .= 'data-isso-vote="'.$this->getDbField('dataVote').'" ';
			}
			
			if( $this->getDbField('dataAvatar') == 'true' || $this->getDbField('dataAvatar') == 'false' ) {
			    $html .= 'data-isso-avatar="'.$this->getDbField('dataAvatar').'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('dataAvatarFg')) ) {
			    $html .= 'data-isso-avatar-fg="'.trim($this->getDbField('dataAvatarFg')).'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('dataAvatarBg')) ) {
			    $html .= 'data-isso-avatar-bg="'.trim($this->getDbField('dataAvatarBg')).'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('dataLang')) ) {
			    $html .= 'data-isso-lang="'.trim($this->getDbField('dataLang')).'" ';
			}
			
			if( Valid::int( $this->getDbField('dataCommentsTop') ) ) {
			    $html .= 'data-isso-max-comments-top="'.$this->getDbField('dataCommentsTop').'" ';
			}
			
			if( Valid::int( $this->getDbField('dataCommentsNested') ) ) {
			    $html .= 'data-isso-max-comments-nested="'.$this->getDbField('dataCommentsNested').'" ';
			}
			
			if( Valid::int( $this->getDbField('dataRevealClick') ) ) {
			    $html .= 'data-isso-reveal-on-click="'.$this->getDbField('dataRevealClick').'" ';
			}
			
			if( !Text::isEmpty($this->getDbField('pathCss')) ) {
			    $html .= 'data-isso-css="false" ';
			} else {
			    $html .= 'data-isso-css="true" ';
			}
			
			$html .= '></script>';
			
			return $html;
		}

		return false;
	}
}
