(function(module) {

    module.config(['$stateProvider', function ($stateProvider) {
        $stateProvider.state('about', {
            url: '/about',
            views: {
                "main": {
                    controller: 'AboutController as model',
                    templateUrl: 'about/about.tpl.html',
					animation : 'second'
                }
            },
            data:{ pageTitle: 'About' }
        });
    }]);

}(angular.module("dlnAppFeed.about", [
    'ui.router'
])));

(function(module) {

    module.config(['$stateProvider', function ($stateProvider) {
        $stateProvider.state('about', {
            url: '/about',
            views: {
                "main": {
                    controller: 'AboutController as model',
                    templateUrl: 'about/about.tpl.html',
					animation : 'second'
                }
            },
            data:{ pageTitle: 'About' }
        });
    }]);

}(angular.module("dlnAppFeed.about", [
    'ui.router'
])));
