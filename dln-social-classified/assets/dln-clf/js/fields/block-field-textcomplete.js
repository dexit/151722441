(function($) {
	"use strict";
	
	/*var addTextNTag = function () {
		if ( typeof( $.fn.textntags ) == 'function' ) {
			$('.dln-textntag').textntags({
				triggers: {
					'#' : {
						uniqueTags	: false,
						syntax		: _.template('#[<%= id %>:<%= type %>:<%= title %>]'),
						parser		: /(#)\[(\d+):([\w\s\.\-]+):([\w\s@\.,-\/#!$%\^&\*;:{}=\-_`~()]+)\]/gi,
						parserGroup : {id: 2, type: 3, title: 4},
					}
				},
				 onDataRequest:function (mode, query, triggerChar, callback) {
					 console.log(mode, query, triggerChar, callback);
					 var data = {
						'#': [
		                    { id:4, name:'#Daniel Zahariev',  'img':'http://example.com/img1.jpg', 'type':'contact2' },
		                    { id:5, name:'#Daniel Radcliffe', 'img':'http://example.com/img2.jpg', 'type':'contact2' },
		                    { id:6, name:'#Daniel Nathans',   'img':'http://example.com/img3.jpg', 'type':'contact2' }
		                ],
		            };
					var base = query;
		            query = query.toLowerCase();
		            // new obj option
		            var obj = {};
		            obj.id = 0;
		            obj.name = '#' + base,
		            obj.type = 'contact1';
		            data[triggerChar].push(obj);
		            var found = _.filter(data[triggerChar], function(item) { return item.name.toLowerCase().indexOf(query) > -1; });
		            
		            callback.call(this, found);
		        }
			});
		}
	};*/
	
	var addTextComplete = function () {
		if ( typeof( $.fn.textcomplete ) == 'function' ) {
			$('.dln-textcomplete').each(function () {
				/*$(this).textcomplete(
					[{ // emoji strategy
						match: /\B:([\-+\w]*)$/,
						search: function (term, callback) {
							callback($.map(emojies, function (emoji) {
								return emoji.indexOf(term) === 0 ? emoji : null;
							}));
						},
						template: function (value) {
							return '<img src="' + dln_clf_params.url + '/assets/3rd-party/jquery-textcomplete/emoji/' + value + '.png"></img>' + value;
						},
						replace: function (value) {
							return ':' + value + ': ';
						},
						index: 1,
						maxCount: 5
					}]);
				
				$(this).textcomplete(
						[{ // html
					        mentions: [],
					        match: /\B@(\w*)$/,
					        search: function (term, callback) {
					        	callback($.map(this.mentions, function (mention) {
					        		return mention.indexOf(term) === 0 ? mention : null;
					            }));
					        },
					        index: 1,
					        replace: function (mention) {
					            return '@' + mention + ' ';
					        }
					    }
					], { appendTo: 'body' }).overlay([
					    {
					        match: /\B@\w+/g,
					        css: {
					            'background-color': '#d8dfea'
					        }
					    }
					]);*/
				
				$(this).textcomplete(
						[{ // html
					        mentions: [],
					        match: /\B#(\w*)$/,
					        search: function (term, callback) {
					        	callback($.map(this.mentions, function (mention) {
					        		return mention.indexOf(term) === 0 ? mention : null;
					            }));
					        },
					        index: 1,
					        replace: function (mention) {
					            return '#' + mention + ' ';
					        }
					    }
					], { appendTo: 'body' }).overlay([
					    {
					        match: /\B#\w+/g,
					        css: {
					            'background-color': '#d8dfea'
					        }
					    }
					]);
			});
		}
	};
	
	var capitalizeFirstLetter = function( string ) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	};
	
	$(document).ready(function () {
		addTextComplete();
		//addTextNTag();
		
		/*$('.dln-textntag').textntags('getTagsMapFacebook', function(data) {
            console.log(JSON.stringify(data), data);
        });*/
		
		
	});
}(jQuery));