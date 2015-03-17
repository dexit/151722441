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
    "<div class=\"card facebook-card\" ng-repeat=\"item in feeds\" on-last-repeat=\"ngRepeatFinished\">\n" +
    "	<div class=\"card-header\">\n" +
    "		<div class=\"facebook-avatar\">\n" +
    "			<img class=\"j-lazy\" data-original=\"{{item.profile_src}}\" width=\"34\" height=\"34\">\n" +
    "		</div>\n" +
    "		<div class=\"facebook-name\">{{item.profile_name}}</div>\n" +
    "		<div class=\"facebook-date\">{{item.created_at | amCalendar}} <i class=\"{{item.font_type}}\"></i></div>\n" +
    "		<a href=\"javascript:void(0)\" class=\"facebook-heart\"><i class=\"fa fa-heart-o\"></i></a>\n" +
    "	</div>\n" +
    "	<div class=\"card-content\">\n" +
    "		<div class=\"card-content-inner\">\n" +
    "			<p>{{item.message}}</p>\n" +
    "			<div class=\"card-thumbnail\">\n" +
    "				<i ng-if=\"item.type == 'video'\" class=\"fa-4 fa fa-play\"></i>\n" +
    "				<img ng-src=\"{{item.photo}}\" />\n" +
    "			</div>\n" +
    "			<p class=\"color-gray\">\n" +
    "				<i class=\"fa fa-thumbs-o-up\"></i> {{item.like_count|nFormater}} <span class=\"tab\"></span>\n" +
    "				<i class=\"fa fa-comments\"></i> {{item.comment_count|nFormater}} <span class=\"tab\"></span>\n" +
    "				<i class=\"fa fa-share-alt\"></i> {{item.share_count|nFormater}}\n" +
    "				<open-external url=\"item.link\">OpenURL</open-external>\n" +
    "				<a href=\"javascript:void(0)\" ng-click=\"window.open(item.link, '_system');\" class=\"link pull-right external\">Xem tin</a>\n" +
    "			</p>\n" +
    "		</div>\n" +
    "	</div>\n" +
    "</div>\n" +
    "\n" +
    "<div class=\"content-block\">\n" +
    "	<p><div ng-hide=\"loading\" class=\"button button-fill color-green\" ng-click=\"getFeeds()\">Trang sau</div></p>\n" +
    "</div>");
}]);
