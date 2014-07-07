/*app.utils.templates = (function() {

	var load = function(views, callback) {

		var deferreds = [];

		$.each(views, function(index, view) {
			if (app.views[view]) {
				deferreds.push($.get('tpl/' + view + '.html', function(data) {
					app.views[view].prototype.template = _.template(data);
				}, 'html'));
			} else {
				alert(view + " not found");
			}
		});

		$.when.apply(null, deferreds).done(callback);
	}

	// The public API
	return {
		load: load
	};
}());*/
app.utils.templates = {
	deferreds: {},

	get: function (id, callback) {
		var deferred = this.deferreds[id];

		if ( deferred ) {
			callback(deferred);
		} else {
			var that = this;
			$.get('assets/app/tpl/' + id + '.html', function ( deferred ) {
				that.deferreds[id] = deferred;
				callback(deferred);
			}, 'html').fail(function () {
				console.log(id + " not found");
			});
		}
	},
};