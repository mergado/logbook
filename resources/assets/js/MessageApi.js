var Mergado = new function() {

	var _initialized = false;
	var _mAppViewId = null;
	var _window = null;
	var _parentWindow = null;
	var _this = this;

	var msgHandler = function(msg) {

		var self = _this;

		switch (msg.data.type) {

			// Mergado sends its greetings after IFRAME loads.
			case 'hello':
				_mAppViewId = msg.data.id;
				var h = _window.getComputedStyle(_window.document.body).height;
				_this.tellHeight(h);
				break;

		}

	}

	this.init = function(w) {

		_window = w;
		_parentWindow = w.parent;
		var self = this;

		// Tell Mergado's app viewport to change its height after page init.
		w.addEventListener('message', function(m) {
			msgHandler.call(this, m);
		}, false);

		// Replace opening links with using popups, where desired.
		w.addEventListener('load', function(e) {
			var a = document.querySelectorAll('[data-download]');
			var l = a.length;
			for(var i = 0; i < l; i++) {
				var el = a[i];
				el.onclick = function(ev) {
					w.parent.postMessage({type: 'start_download', vid: _mAppViewId, href: el[el.dataset.download]}, '*');
					ev.preventDefault();
				};
			}
		});

		_initialized = true;

	}

	this.getViewId = function() {
		return _mAppViewId;
	}

	// Height as number in pixels (without 'px').
	this.tellHeight = function(h) {

		if (typeof h == 'undefined') h = _window.getComputedStyle(_window.document.body).height;

		_parentWindow.postMessage({type: 'height', vid: _mAppViewId, ht: h}, '*');
	}

}

Mergado.init(window);

setTimeout(function() {

	debugger;
	console.log(Mergado.getViewId());

}, 3000);

