$(function() {
	$('div.spoiler-title').click(function() {
		$(this)
			.children()
			.first()
			.toggleClass('hide-icon')
			.toggleClass('show-icon');
		$(this)
			.parent().children().last().toggle();
	});
});