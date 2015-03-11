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
    "<div class=\"card facebook-card\" ng-repeat=\"item in feeds\" on-last-repeat=\"ngRepeatFinished\">\n" +
    "	<div class=\"card-header\">\n" +
    "		<div class=\"facebook-avatar\">\n" +
    "			<img class=\"j-lazy\" data-original=\"http://graph.facebook.com/{{item.page.fb_id}}/picture?type=small\" width=\"34\" height=\"34\">\n" +
    "		</div>\n" +
    "		<div class=\"facebook-name\">{{item.page.name}}</div>\n" +
    "		<div class=\"facebook-date\">{{item.created_at | amCalendar}}</div>\n" +
    "	</div>\n" +
    "	<div class=\"card-content\">\n" +
    "		<div class=\"card-content-inner\">\n" +
    "			<p>{{item.message}}</p>\n" +
    "			<img ng-src=\"{{item.photo}}\" />\n" +
    "			<p class=\"color-gray\">Likes: {{item.like_count}} Comments: {{item.comment_count}}</p>\n" +
    "			<div ng-lick=\"redirectAppLink(item.app_link)\">Test</div>\n" +
    "			<a href=\"{{item.app_link}}\" class=\"external\" target=\"_blank\">Link</a>\n" +
    "			<a href=\"{{item.app_link}}\" class=\"external\" target=\"_system\">Link 1</a>\n" +
    "		</div>\n" +
    "	</div>\n" +
    "</div>\n" +
    "\n" +
    "<div class=\"content-block\">\n" +
    "	<p>\n" +
    "	<div ng-hide=\"loading\" class=\"button button-fill color-green\" ng-click=\"getFeeds()\">Trang sau</div>\n" +
    "	</p>\n" +
    "</div>\n" +
    "\n" +
    "<!-- Preloader -->\n" +
    "<div ng-show=\"loading\" class=\"infinite-scroll-preloader\">\n" +
    "	<div class=\"preloader\"></div>\n" +
    "</div>");
}]);
