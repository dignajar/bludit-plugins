<?php

class pluginYandexTools extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'yametrika-id'=>'',
			'yandex-verification'=>''
		);
	}

	public function form()
	{
		global $Language;

		$html  = '<div>';
		$html .= '<label for="jsyandex-verification">'.$Language->get('Yandex.Webmaster').'</label>';
		$html .= '<input id="jsyandex-verification" type="text" name="yandex-verification" value="'.$this->getDbField('yandex-verification').'">';
		$html .= '<div class="tip">'.$Language->get('complete-this-field-with-the-yandex-verification').'</div>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label for="jsyametrika-id">'.$Language->get('Yandex.Metrika Counter ID').'</label>';
		$html .= '<input id="jsyametrika-id" type="text" name="yametrika-id" value="'.$this->getDbField('yametrika-id').'">';
		$html .= '<div class="tip">'.$Language->get('complete-this-field-with-the-yametrika-id').'</div>';
		$html .= '</div>';

		return $html;
	}

	public function siteHead()
	{
                global $Url;

                if(Text::isEmpty($this->getDbField('yandex-verification')) || !($Url->whereAmI()=='home')) {
                        return false;
                }

                $html  = PHP_EOL.'<!-- Yandex.Webmaster counter -->'.PHP_EOL;
                $html  .= '<meta name="yandex-verification" content="'.$this->getDbField('yandex-verification').'" />'.PHP_EOL;
                return $html;
	}

	public function siteBodyEnd()
	{
		$html  = PHP_EOL.'<!-- Yandex.Metrika counter -->'.PHP_EOL;
		$html .= "<script type='text/javascript'>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter".$this->getDbField('yametrika-id')." = new Ya.Metrika({
                    id:".$this->getDbField('yametrika-id').",
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName('script')[0],
            s = d.createElement('script'),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://mc.yandex.ru/metrika/watch.js';

        if (w.opera == '[object Opera]') {
            d.addEventListener('DOMContentLoaded', f, false);
        } else { f(); }
    })(document, window, 'yandex_metrika_callbacks');
</script>
<noscript><div><img src='https://mc.yandex.ru/watch/".$this->getDbField('yametrika-id')."' style='position:absolute; left:-9999px;' alt='' /></div></noscript>".PHP_EOL;

		if(Text::isEmpty($this->getDbField('yametrika-id'))) {
			return false;
		}

		return $html;
	}
}
