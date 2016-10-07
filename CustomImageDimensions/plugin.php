<?php

class pluginCustomImageDimensions extends Plugin {

	public function siteBodyEnd()
	{
		$pluginPath = $this->htmlPath();
		$html  = '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.slim.min.js"></script>';
		$html .= '
		        <script>
		            $("img").each(function(){  
		                imgAlt = this.alt;
		                if(/height=/i.test(imgAlt)){
		                    heightPosition = imgAlt.lastIndexOf("height=") + 7;
		                    height = heightPosition;
		                    for(i = heightPosition; i < imgAlt.length; i++){
		                        if(!isNaN(parseInt(imgAlt.substring(i)))){
		                            height += 1;
		                        } else break;
		                    }
		                    this.style.setProperty("height", imgAlt.substring(heightPosition, height));
		                }
		                if(/width=/i.test(imgAlt)){
		                    widthPosition = imgAlt.lastIndexOf("width=") + 6;
		                    width = widthPosition;
		                    for(i = widthPosition; i < imgAlt.length; i++){
		                        if(!isNaN(parseInt(imgAlt.substring(i)))){
		                            width += 1;
		                        } else break;
		                    }
		                    this.style.setProperty("width", imgAlt.substring(widthPosition, width));
		                }
					});
		        </script>
		';
		
		return $html;	
	}
}
