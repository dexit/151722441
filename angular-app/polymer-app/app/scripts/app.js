(function (document) {
  'use strict';

  // Grab a reference to our auto-binding template
  // and give it some initial binding values
  // Learn more about auto-binding templates at http://goo.gl/Dx1u2g
  var app = document.querySelector('#app');
  app.appName = 'Yo, Polymer App!';

  // Listen for template bound event to know when bindings
  // have resolved and content has been stamped to the page
  app.addEventListener('template-bound', function() {
    console.log('Our app is ready to rock!');

	  // custom transformation: scale header's title
	  var titleStyle = document.querySelector('.title').style;
	  addEventListener('core-header-transform', function(e) {
		  var d = e.detail;
		  var m = d.height - d.condensedHeight;
		  var scale = Math.max(0.75, (m - d.y) / (m / 0.25)  + 0.75);
		  console.debug(titleStyle);
		  titleStyle.transform = titleStyle.webkitTransform =
				  'scale(' + scale + ') translateZ(0)';
	  });
  });

// wrap document so it plays nice with other libraries
// http://www.polymer-project.org/platform/shadow-dom.html#wrappers
})(wrap(document));
