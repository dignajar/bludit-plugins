<?php

class pluginHighlightBludit extends Plugin {
  // Library address
  private $highlightjs = "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js";
  // Themes addresses
  private $themes = array(
    'agate'                => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/agate.min.css',
    'androidstudio'        => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/androidstudio.min.css',
    'arduino-light'        => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/arduino-light.min.css',
    'arta'                 => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/arta.min.css',
    'ascetic'              => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/ascetic.min.css',
    'monokai-sublime'      => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css',
    'atelier-seaside-dark' => 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/atelier-seaside-dark.min.css'
  );

  // Plugin Data
  public function init() {
    $this->dbFields = array(
      'styles' => 'monokai-sublime'
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
    $html .= '<select name="styles">';

    foreach($this->themes as $text=>$value) {
      $html .= '<option value="'.$value.'" '.( ($this->getDbField('styles')===$value)?' selected="selected"':'').'>'.$text.'</option>';
    }

    $html .= '</select>';

    /* test highlight theme */
    $html .= '<link rel="stylesheet" href="'.$this->getDbField('styles').'">';
    $html .= '<script src="'.$this->highlightjs.'"></script>';
    $html .= '<script>hljs.initHighlightingOnLoad();</script>';

    $html .= '<h3>Highlight Example (work after save command)</h3>';

    $html .= '<h4>HTML</h4>';
    $html .= '<pre><code>';
      $html .= htmlspecialchars('<div>test text<div>');
    $html .= '</code></pre>';

    $html .= '<h4>CSS</h4>';
    $html .= '<pre><code>';
      $html .= 'html {padding: 10px;} <br/>';
      $html .= 'class {margin: 10px;}';
    $html .= '</code></pre>';
    /* /test highlight theme */

    $html .= '<br><br>';

    return $html;
  }
}

?>