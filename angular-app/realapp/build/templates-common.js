angular.module('templates-common', ['directives/dln-toolbar/dlnToolbar.tpl.html']);

angular.module("directives/dln-toolbar/dlnToolbar.tpl.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("directives/dln-toolbar/dlnToolbar.tpl.html",
    "<md-sidenav class=\"site-sidenav md-sidenav-left md-whiteframe-z2\"\n" +
    "            md-component-id=\"left\"\n" +
    "            md-is-locked-open=\"$mdMedia('gt-sm')\">\n" +
    "\n" +
    "	<md-toolbar>\n" +
    "		<h1 class=\"md-toolbar-tools\">\n" +
    "			<a ng-href=\"/\" layout=\"row\" flex>\n" +
    "				<div class=\"docs-logotype\">Material Design</div>\n" +
    "			</a>\n" +
    "		</h1>\n" +
    "	</md-toolbar>\n" +
    "\n" +
    "	<ul class=\"skip-links\">\n" +
    "		<li class=\"md-whiteframe-z2\">\n" +
    "			<md-button ng-click=\"focusMainContent($event)\" href=\"#\">Skip to content</md-button>\n" +
    "		</li>\n" +
    "	</ul>\n" +
    "\n" +
    "	<md-content flex role=\"navigation\">\n" +
    "		<ul class=\"docs-menu\">\n" +
    "			<li ng-repeat=\"section in menu.sections\" class=\"parent-list-item\" ng-class=\"{'parentActive' : isSectionSelected(section)}\">\n" +
    "				<h2 class=\"menu-heading\" ng-if=\"section.type === 'heading'\" id=\"heading_{{ section.name | nospace }}\">\n" +
    "					{{section.name}}\n" +
    "				</h2>\n" +
    "				<menu-link section=\"section\" ng-if=\"section.type === 'link'\"></menu-link>\n" +
    "\n" +
    "				<menu-toggle section=\"section\" ng-if=\"section.type === 'toggle'\"></menu-toggle>\n" +
    "\n" +
    "				<ul ng-if=\"section.children\" class=\"menu-nested-list\">\n" +
    "					<li ng-repeat=\"child in section.children\" ng-class=\"{'childActive' : isSectionSelected(child)}\">\n" +
    "						<menu-toggle section=\"child\"></menu-toggle>\n" +
    "					</li>\n" +
    "				</ul>\n" +
    "			</li>\n" +
    "		</ul>\n" +
    "	</md-content>\n" +
    "</md-sidenav>\n" +
    "\n" +
    "<div ng-controller=\"dlnToolbarCtrl\">\n" +
    "	<md-content>\n" +
    "		<md-toolbar>\n" +
    "			<h2 class=\"md-toolbar-tools\">\n" +
    "				<span>Toolbar</span>\n" +
    "			</h2>\n" +
    "		</md-toolbar>\n" +
    "		<br>\n" +
    "		<br>\n" +
    "		<md-toolbar class=\"md-tall md-accent\">\n" +
    "			<h2 class=\"md-toolbar-tools\">\n" +
    "				<span>Toolbar: tall (md-accent)</span>\n" +
    "			</h2>\n" +
    "		</md-toolbar>\n" +
    "		<br>\n" +
    "		<md-toolbar class=\"md-tall md-warn md-hue-3\">\n" +
    "			<span flex></span>\n" +
    "\n" +
    "			<h2 class=\"md-toolbar-tools md-toolbar-tools-bottom\">\n" +
    "				<span class=\"md-flex\">Toolbar: tall with actions pin to the bottom (md-warn md-hue-3)</span>\n" +
    "			</h2>\n" +
    "		</md-toolbar>\n" +
    "	</md-content>\n" +
    "</div>");
}]);
