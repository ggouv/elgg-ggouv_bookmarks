
elgg.provide('elgg.bookmarks');

elgg.bookmarks.init = function() {
	// append the title to the url
	var title = document.title,
		e = $('a.elgg-bookmark-page'),
		link = e.attr('href') + '&title=' + encodeURIComponent(title),
		resizebframe = function() {
			var i = $('iframe.bookmark-iframe');
			if (i.length ) {
				i.height($(window).height() - i.position().top - 48);
			}
		};

	e.attr('href', link);
	resizebframe();

	// for extensible template
	$(window).bind('resize', function() {
		resizebframe();
	});
};

elgg.register_hook_handler('init', 'system', elgg.bookmarks.init);

// end of elgg-ggouv_bookmarks js
