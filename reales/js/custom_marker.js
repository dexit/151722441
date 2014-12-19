function CustomMarker(latlng, map) {
	this.latlng_ = latlng;

	// Once the LatLng and text are set, add the overlay to the map.  This will
	// trigger a call to panes_changed which should in turn call draw.
	this.setMap(map);
}

CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function() {
	var me = this;

	// Check if the div has been created.
	var div = this.div_;
	var parent_div = '';
	if (!div) {
		// Create a overlay text DIV
		div = this.div_ = document.createElement('DIV');
		parent_div = document.createElement('DIV');
		// Create the DIV representing our CustomMarker
		div.style.position = "absolute";
		div.style.paddingLeft = "0px";
		div.style.cursor = 'pointer';
		div.className = 'dln-marker';
		parent_div.className = 'dln-parent-marker';
		parent_div.appendChild(div);

		//var img = document.createElement("img");
		//img.src = "http://gmaps-samples.googlecode.com/svn/trunk/markers/circular/bluecirclemarker.png";
		//div.appendChild(img);
		google.maps.event.addDomListener(div, "click", function(event) {
			google.maps.event.trigger(me, "click");
		});

		// Then add the overlay to the DOM
		var panes = this.getPanes();
		panes.overlayImage.appendChild(parent_div);
	}

	// Position the overlay 
	var point = this.getProjection().fromLatLngToDivPixel(this.latlng_);
	if (point) {
		div.style.left = point.x + 'px';
		div.style.top = point.y + 'px';
	}
};

CustomMarker.prototype.remove = function() {
	// Check if the overlay was on the map and needs to be removed.
	if (this.div_) {
		this.div_.parentNode.removeChild(this.div_);
		this.div_ = null;
	}
};

CustomMarker.prototype.getPosition = function() {
	return this.latlng_;
};