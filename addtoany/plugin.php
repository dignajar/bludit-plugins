<?php

class pluginAddToAny extends Plugin {

        private $enable;

        private function a2acode()
        {
                $ret  = '<!-- AddToAny BEGIN -->
                        <div class="a2a-social" style="margin:20px 0px;">
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                        <a class="a2a_button_facebook"></a>
                                        <a class="a2a_button_twitter"></a>
                                        <a class="a2a_button_google_plus"></a>
                                        <a class="a2a_button_linkedin"></a>
                                        <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
                                </div>
                        </div>
                        <script type="text/javascript">
                        var a2a_config = a2a_config || {};
                        a2a_config.icon_color = "unset";';

                if ( $this->getDbField('enableMinifyURL') ) {
                        $ret .='a2a_config.track_links = "googl";';
                };

                $ret .= '</script>
                        <!-- AddToAny END -->';

                return $ret;
        }

        public function init()
        {
                $this->dbFields = array(
                        'enablePages'=>0,
                        'enablePosts'=>1,
                        'enableDefaultHomePage'=>0,
                        'enableMinifyURL'=>1
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
                elseif( $this->getDbField('enableDefaultHomePage') && ($Url->whereAmI()=='home') )
                {
                        $this->enable = true;
                }
        }

        public function form()
        {
                global $Language;

                $html = '<div>';
                $html .= '<input type="hidden" name="enablePages" value="0">';
                $html .= '<input name="enablePages" id="jsenablePages" type="checkbox" value="1" '.($this->getDbField('enablePages')?'checked':'').'>';
                $html .= '<label class="forCheckbox" for="jsenablePages">'.$Language->get('enable-addtoany-on-pages').'</label>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<input type="hidden" name="enablePosts" value="0">';
                $html .= '<input name="enablePosts" id="jsenablePosts" type="checkbox" value="1" '.($this->getDbField('enablePosts')?'checked':'').'>';
                $html .= '<label class="forCheckbox" for="jsenablePosts">'.$Language->get('enable-addtoany-on-posts').'</label>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<input type="hidden" name="enableDefaultHomePage" value="0">';
                $html .= '<input name="enableDefaultHomePage" id="jsenableDefaultHomePage" type="checkbox" value="1" '.($this->getDbField('enableDefaultHomePage')?'checked':'').'>';
                $html .= '<label class="forCheckbox" for="jsenableDefaultHomePage">'.$Language->get('enable-addtoany-on-default-home-page').'</label>';
                $html .= '</div>';

                $html .= '<div>';
                $html .= '<input type="hidden" name="enableMinifyURL" value="0">';
                $html .= '<input name="enableMinifyURL" id="jsenableMinifyURL" type="checkbox" value="1" '.($this->getDbField('enableMinifyURL')?'checked':'').'>';
                $html .= '<label class="forCheckbox" for="jsenableMinifyURL">'.$Language->get('enable-google-url-shortener').'</label>';
                $html .= '</div>';

                return $html;
        }

        public function postEnd()
        {
                if( $this->enable ) {
                        return $this->a2acode();
                }
                return false;
        }

        public function pageEnd()
        {
                if( $this->enable ) {
                        return $this->a2acode();
                }
                return false;
        }

        public function siteHead()
        {
                if( $this->enable ) {
                        $html = '<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>';
                        return $html;
                }
                return false;
        }

}
