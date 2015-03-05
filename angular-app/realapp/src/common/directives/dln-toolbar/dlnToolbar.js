(function (module) {

	module.directive('dlnToolbar', ['$parse', 'security', function ($parse, security) {
		return {
			templateUrl: 'common/directives/dln-toolbar/dlnToolbar.tpl.html',
			scope: true,
			link: function ($scope, $element, $attrs, $controller) {

			}
		};
	}]);

}(angular.module('directives.toolbar', [])));