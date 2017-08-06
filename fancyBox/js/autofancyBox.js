$(document).ready(function () {
	$("img").on("click", function () {
		$.fancybox($(this).attr("src"), {
			padding: 0
		});
	});
});