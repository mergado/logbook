/**
 * Created by samuel on 19.2.16.
 */

	$( document).ready(function(){
		var iconizatorIcons = new Iconizator(MergadoApp.staticUrl + '/img/icons.png');

		iconizatorIcons.iconize($('[class^="icon-"]')); // Common icons

	});
