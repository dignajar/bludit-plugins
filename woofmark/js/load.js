// Create a woofmark instance
var wm = woofmark(document.querySelector('#jscontent'), {
  parseMarkdown: megamark,
  parseHTML: domador
});

// Newline fix for WYSIWYG mode -- http://wadmiraal.net/lore/2012/06/14/contenteditable-hacks-returning-like-a-pro/
$("div.wk-wysiwyg").keydown(function(e) {
	if(e.which === 13) {
		var doxExec = false;

		try {
			doxExec = document.execCommand('insertBrOnReturn', false, true);
		}
		catch (error) {
			// IE throws an error if it does not recognize the command...
		}

		if (doxExec) {
		// Hurray, no dirty hacks needed !
		return true;
		}
		// Standard
		else if (window.getSelection) {
			e.stopPropagation();

			var selection = window.getSelection(),
				range = selection.getRangeAt(0),
				br = document.createElement("br");
				
				range.deleteContents();
				range.insertNode(br);
				range.setStartAfter(br);
				range.setEndAfter(br);
				range.collapse(false);
				selection.removeAllRanges();
				selection.addRange(range);

				return false;
		}
		// IE
		else if ($.browser.msie) {
			e.preventDefault();
			var range = document.selection.createRange();
			range.pasteHTML('<BR><SPAN class="--IE-BR-HACK"></SPAN>');

			// Move the caret after the BR
			range.moveStart('character', 1);

			return false;
		}

		// Last resort, just use the default browser behavior and pray...
		return true;
	}
});

// WYSIWYG save fix for Bludit
$("button").on('click', function() {
	if( $(this).html() === "Save" ) {
		
		// Get content from WYSIWYG editor
		var content = wm.editable.innerHTML;

		// Convert to Markdown for a cleaner base
		//var content = wm.parseHTML();
		
		// Trim the content
		content = (content.trim) ? content.trim() : content.replace(/^\s+/,'');
		
		// Give the content from WYSIWYG (if needed) to textarea so that Bludit could catch it
		if( content != '' && !($("div.wk-wysiwyg").hasClass("wk-hide")) ) {
			$("textarea#jscontent").html(content);
		}
	}
});

$(document).ready(function(){
	// Restyle buttons to match admin's theme
	$(".wk-mode").addClass("uk-button");
	$(".wk-command").addClass("uk-button uk-button-primary");
});