<?php

class pluginHighlight extends Plugin {
  // Library address
  private $highlightjs = "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js";
  // Themes addresses
  private $themes = array(
    'agate'                  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/agate.min.css',
    'androidstudio'          => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/androidstudio.min.css',
    'arduino-light'          => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/arduino-light.min.css',
    'arta'                   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/arta.min.css',
    'ascetic'                => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/ascetic.min.css',
    'atelier-cave-light'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-cave-light.min.css',
    'atelier-dune-dark'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-dune-dark.min.css',
    'atelier-dune-light'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-dune-light.min.css',
    'atelier-estuary-dark'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-estuary-dark.min.css',
    'atelier-estuary-light'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-estuary-light.min.css',
    'atelier-forest-dark'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-forest-dark.min.css',
    'atelier-forest-light'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-forest-light.min.css',
    'atelier-heath-dark'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-heath-dark.min.css',
    'atelier-heath-light'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-heath-light.min.css',
    'atelier-lakeside-dark'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-lakeside-dark.min.css',
    'atelier-lakeside-light' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-lakeside-light.min.css',
    'atelier-plateau-dark'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-plateau-dark.min.css',
    'atelier-plateau-light'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-plateau-light.min.css',
    'atelier-savanna-dark'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-savanna-dark.min.css',
    'atelier-savanna-light'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-savanna-light.min.css',
    'atelier-seaside-dark'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-seaside-dark.min.css',
    'atelier-seaside-light'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-seaside-light.min.css',
    'atelier-sulphurpool-dark'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-sulphurpool-dark.min.css',
    'atelier-sulphurpool-light' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-sulphurpool-light.min.css',
    'atom-one-dark'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atom-one-dark.min.css',
    'atom-one-light'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atom-one-light.min.css',
    'brown-paper'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/brown-paper.min.css',
    'brown-papersq'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/brown-papersq.png',
    'codepen-embed'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/codepen-embed.min.css',
    'color-brewer'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/color-brewer.min.css',
    'darcula'         => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/darcula.min.css',
    'dark'            => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/dark.min.css',
    'darkula'         => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/darkula.min.css',
    'default'         => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css',
    'docco'           => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/docco.min.css',
    'dracula'         => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/dracula.min.css',
    'far'             => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/far.min.css',
    'foundation'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/foundation.min.css',
    'github-gist'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/github-gist.min.css',
    'github'          => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/github.min.css',
    'googlecode'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/googlecode.min.css',
    'grayscale'       => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/grayscale.min.css',
    'gruvbox-dark'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/gruvbox-dark.min.css',
    'gruvbox-light'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/gruvbox-light.min.css',
    'hopscotch'       => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/hopscotch.min.css',
    'hybrid'          => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/hybrid.min.css',
    'idea'            => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/idea.min.css',
    'ir-black'        => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/ir-black.min.css',
    'kimbie.dark'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/kimbie.dark.min.css',
    'kimbie.light'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/kimbie.light.min.css',
    'magula'          => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/magula.min.css',
    'mono-blue'       => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/mono-blue.min.css',
    'monokai-sublime' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css',
    'monokai'         => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai.min.css',
    'obsidian'        => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/obsidian.min.css',
    'ocean'           => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/ocean.min.css',
    'paraiso-dark'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/paraiso-dark.min.css',
    'paraiso-light'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/paraiso-light.min.css',
    'pojoaque'        => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/pojoaque.min.css',
    'purebasic'       => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/purebasic.min.css',
    'qtcreator_dark'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/qtcreator_dark.min.css',
    'qtcreator_light' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/qtcreator_light.min.css',
    'railscasts'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/railscasts.min.css',
    'rainbow'         => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/rainbow.min.css',
    'routeros'        => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/routeros.min.css',
    'school-book'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/school-book.min.css',
    'solarized-dark'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/solarized-dark.min.css',
    'solarized-light' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/solarized-light.min.css',
    'sunburst'                => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/sunburst.min.css',
    'tomorrow-night-blue'     => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow-night-blue.min.css',
    'tomorrow-night-bright'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow-night-bright.min.css',
    'tomorrow-night-eighties' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow-night-eighties.min.css',
    'tomorrow-night'          => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow-night.min.css',
    'tomorrow' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/tomorrow.min.css',
    'vs'       => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/vs.min.css',
    'vs2015'   => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/vs2015.min.css',
    'xcode'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/xcode.min.css',
    'xt256'    => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/xt256.min.css',
    'zenburn'  => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/zenburn.min.css'
  );

  // Plugin Data
  public function init() {
    $this->dbFields = array(
      'styles' => 'agate'
    );
  } 
  //
  public function siteHead() {
    echo '<link rel="stylesheet" href="'.$this->getDbField('styles').'">';
  }
  public function siteBodyEnd() {
    echo '<script src="'.$this->highlightjs.'"></script>';
    echo '<script>hljs.initHighlightingOnLoad();</script>';
  }
  // Backend configuration page
  public function form() {
    global $Language, $Site;
    $html = '<label for="styles">'.$Language->get('choose-theme').'</label>';
    $html .= '<select name="styles" onchange="document.getElementById(\'highlight-theme-link\').setAttribute(\'href\', this.options[this.selectedIndex].value)">';

    foreach($this->themes as $text=>$value) {
      $html .= '<option value="'.$value.'" '.( ($this->getDbField('styles')===$value)?' selected="selected"':'').'>'.$text.'</option>';
    }

    $html .= '</select>';

    /* test highlight theme */
    $html .= '<link id="highlight-theme-link" type="text/css" rel="stylesheet" href="'.$this->getDbField('styles').'">';
    $html .= '<script src="'.$this->highlightjs.'"></script>';
    $html .= '<script>hljs.initHighlightingOnLoad();</script>';

    $html .= '<p>'.$Language->get('highlight-example').'</p>';

    $html .= '<h4>HTML</h4>';
    $html .= '<pre><code>';
      $html .= htmlspecialchars('<div>test text<div><br/><span>test text<span>');
    $html .= '</code></pre>';

    $html .= '<h4>CSS</h4>';
    $html .= '<pre><code>';
      $html .= 'html { padding: 10px; } <br/>';
      $html .= '.classname { margin: 10px; }';
    $html .= '</code></pre>';
    /* /test highlight theme */

    $html .= '<br><br>';

    return $html;
  }
}

?>