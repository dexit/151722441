angular.module('templates-app', ['about/about.tpl.html', 'home/home.tpl.html']);

angular.module("about/about.tpl.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("about/about.tpl.html",
    "<div class=\"navbar\">\n" +
    "	<div class=\"navbar-inner\">\n" +
    "		<div class=\"left sliding\"><a href=\"#\" class=\"back link\"> <i class=\"icon icon-back\"></i><span>Back</span></a></div>\n" +
    "		<div class=\"center sliding\">Contacts</div>\n" +
    "		<div class=\"right\"><a href=\"#\" class=\"link icon-only open-panel\"> <i class=\"icon icon-bars\"></i></a></div>\n" +
    "	</div>\n" +
    "</div>\n" +
    "<div class=\"pages\">\n" +
    "	<div data-page=\"contacts\" class=\"page\">\n" +
    "		<div class=\"page-content\">\n" +
    "			<div class=\"content-block\">\n" +
    "				<div class=\"content-block-inner\">\n" +
    "					<p>You can contact me using your iPhone by calling at {{tel}} or using iPad by emailing at {{email}}</p>\n" +
    "					<p>My address is {{street}}, {{city}}, {{country}}, {{zip}}</p>\n" +
    "				</div>\n" +
    "			</div>\n" +
    "		</div>\n" +
    "	</div>\n" +
    "</div>");
}]);

angular.module("home/home.tpl.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("home/home.tpl.html",
    "<h1>Home of Dln app feed</h1>\n" +
    "\n" +
    "<div class=\"card facebook-card\" ng-repeat=\"item in model.feeds\">\n" +
    "	<div class=\"card-header\">\n" +
    "		<div class=\"facebook-avatar\"><img src=\"http://graph.facebook.com/{{item.page.fb_id}}/picture?type=small\" width=\"34\" height=\"34\"></div>\n" +
    "		<div class=\"facebook-name\">{{item.page.name}}</div>\n" +
    "		<div class=\"facebook-date\">{{item.created_at}}</div>\n" +
    "	</div>\n" +
    "	<div class=\"card-content\">\n" +
    "		<div class=\"card-content-inner\">\n" +
    "			<p>{{item.message}}</p>\n" +
    "			<img src=\"{{item.photo}}\" width=\"100%\">\n" +
    "			<a href=\"{{item.link}}\" target=\"_blank\">Link</a>\n" +
    "			<p class=\"color-gray\">Likes: {{item.like_count}} Comments: {{item.comment_count}}</p>\n" +
    "		</div>\n" +
    "	</div>\n" +
    "	<div class=\"card-footer\">\n" +
    "		<a href=\"#\" class=\"link\">Like</a>\n" +
    "		<a href=\"#\" class=\"link\">Comment</a>\n" +
    "		<a href=\"#\" class=\"link\">Share</a>\n" +
    "	</div>\n" +
    "</div>\n" +
    "<!-- Preloader -->\n" +
    "<div class=\"infinite-scroll-preloader\">\n" +
    "	<div class=\"preloader\"></div>\n" +
    "</div>");
}]);
