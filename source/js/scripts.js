var $ = jQuery.noConflict();
var $headerHeight = $('.main-header').outerHeight();

/* Script on ready
------------------------------------------------------------------------------*/
$(() => {
	/* Do jQuery stuff when DOM is ready */
});

/* Script on load
------------------------------------------------------------------------------*/
window.onload = () => {
	/* Do jQuery stuff on Load */
};

/* Script on scroll
------------------------------------------------------------------------------*/
window.onscroll = () => {
	/* Do jQuery stuff on Scroll */
};

/* Script on resize
------------------------------------------------------------------------------*/
window.onresize = () => {
	/* Do jQuery stuff on resize */
};

/* Script all functions
------------------------------------------------------------------------------*/
/* Match height */
function sameHeight(elem, heightType) {
	var mhelem = $(elem);
	var maxHeight = 0;
	if (heightType == undefined) {
		heightType = 'min-height';
	} else {
		heightType = 'height';
	}
	mhelem.css(heightType, 'auto');
	mhelem.each(function () {
		if ($(this).outerHeight() > maxHeight) {
			maxHeight = $(this).outerHeight();
		}
	});
	mhelem.css(heightType, maxHeight);
}