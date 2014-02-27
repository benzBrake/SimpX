/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'simpx\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-chat': '&#xe600;',
		'icon-download': '&#xe601;',
		'icon-user': '&#xe602;',
		'icon-cog': '&#xe603;',
		'icon-list': '&#xe604;',
		'icon-share': '&#xe605;',
		'icon-info': '&#xe607;',
		'icon-link': '&#xe608;',
		'icon-search': '&#xe609;',
		'icon-heart': '&#xe60a;',
		'icon-star': '&#xe60b;',
		'icon-feed': '&#xe60c;',
		'icon-help': '&#xe60d;',
		'icon-users': '&#xe60e;',
		'icon-trashcan': '&#xe60f;',
		'icon-pencil': '&#xe610;',
		'icon-unlocked': '&#xe611;',
		'icon-images': '&#xe612;',
		'icon-article': '&#xe613;',
		'icon-tag': '&#xe614;',
		'icon-archive': '&#xe615;',
		'icon-calendar': '&#xe616;',
		'icon-comment': '&#xe617;',
		'icon-earth': '&#xe618;',
		'icon-hyperlink': '&#xe619;',
		'icon-in': '&#xe61a;',
		'icon-arrow-right': '&#xe61b;',
		'icon-arrow-left': '&#xe61c;',
		'icon-info2': '&#xe61d;',
		'icon-layout': '&#xe61e;',
		'icon-arrow-down': '&#xe606;',
		'icon-arrow-up': '&#xe61f;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
