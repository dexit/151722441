angular.module('templates-common', ['directives/dln-toolbar/dlnToolbar.tpl.html']);

angular.module("directives/dln-toolbar/dlnToolbar.tpl.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("directives/dln-toolbar/dlnToolbar.tpl.html",
    "<h1>Toolbar</h1>");
}]);
