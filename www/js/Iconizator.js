/**
 * Iconizator
 *
 * @version 1.0
 * @author Zdenek Hruska
 *
 * Create only one instance - it's enough for most cases.
 *
 * Icons will appear as text, when background image is downloaded, text will
 * be replaced with image.
 *
 * Image will downloaded when its needed for first time. Until image is downloaded,
 * all elements will be queued. When image is donwloaded, all elements in queue
 * will be treated and all future requests (ajax pop ups, etc, ...) will be treated
 * in real time.
 *
 * Adds icon content to title and sets "icon" class, so you don't have to
 * write class="icon icon-whatever" + it's an indicator that element was taken
 * trough icon treatment.
 * Only mess with title attribute if its not already set.
 */

function Iconizator(iconImageUrl) {
	this.iconImageUrl = iconImageUrl;
	this.iconImageState = 'fresh';
	this.iconImage = new Image();
	this.iconImage.onLoad = this.onIconImageLoad();
	this.iconQueue = [];
}

Iconizator.prototype = {
	iconImage: null,
	iconImageUrl: null,
	iconImageState: null,
	iconQueue: null,
	onIconImageLoad: function() {
		this.iconImageState = 'loaded';
	},
	loadIconImage: function() {
		this.iconImageState = 'loading';
		this.iconImage.src = this.iconImageUrl;
		this.emptyIconQueue();
	},
	emptyIconQueue: function() {
		this.createIcons(this.iconQueue);
		this.iconQueue = [];
	},
	createIcons: function(elements) {
		var self = this;

		$.each(elements, function(key, element) {
			var $element = $(element);
			if(!$element.hasClass('icon')) {
				$element.addClass('icon');
				$element.css({
					backgroundImage: "url('" + self.iconImageUrl + "')"
				});

				if($element.attr('title') === undefined) {
					$element.attr('title', $.trim($element.html()));
				}
			}
		});
	},
	iconize: function(elements) {
		switch(this.iconImageState) {
			case 'fresh':
				this.loadIconImage();
				// intetionally fall-through
			case 'loading':
				this.iconQueue.push.apply(this.iconQueue, elements); // append array to array
				break;
			case 'loaded':
				this.createIcons(elements);
				break;
		}
	}
}
