var DLN_CustomMarker = function (latlng, map) {
	this.latlng = latlng;
	this.setMap(map);
};

DLN_CustomMarker.prototype = new google.maps.OverlayView();

DLN_CustomMarker.prototype.draw = function () {
	var self = this;
	var div = this.div;
	var parent_div;
	
	if (! div) {
		div = this.div = document.createElement('DIV');
		parent_div = document.createElement('DIV');
		
		div.style.position    = 'absolute';
		div.style.paddingLeft = '0px';
		div.style.cursor      = 'pointer';
		div.className         = 'dln-marker';
		
		parent_div.className  = 'dln-marker-parent';
		parent_div.appendChild(div);
		
		google.maps.event.addDomListener(div, 'click', function (e) {
			google.maps.event.trigger(self, 'click');
		});
		
		var panes = this.getPanes();
		panes.overlayImage.appendChild(parent_div);
	}
	
	var point = this.getProjection().fromLatLngToDivPixel(this.latlng);
	if (point) {
		div.style.left = point.x + 'px';
		div.style.top = point.y + 'px';
	}
};

DLN_CustomMarker.prototype.remove = function () {
	var self = this;
	if (this.div) {
		this.div.parentNode.removeChild(this.div);
		this.div = null;
	}
};

DLN_CustomMarker.prototype.getPosition = function() {
	return this.latlng;
};