'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PagesCtrl
 * @description
 * # PagesCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
    .controller('PagesCtrl', function ($scope, $rootScope, $stateParams, $location, fCache, sFeed) {
        $scope.pages = [];
        $scope.category_id = '';
        // For feeds
        $scope.page = null;
        $scope.feeds = [];
        $scope.category = null;
        $scope._page = 0;
        $scope.last_request = '';
        $scope.loading = false;

        $scope.gotoPage = function (index) {
            if (!$scope.pages[index]) {
                return false;
            }

            $location.path('/pages/' + $scope.pages[index].id);
        };

        $scope.gotoFBLink = function (index) {
            if (!$scope.pages[index]) {
                return false;
            }

            var url = '';
            if ($rootScope.allowScheme) {
                url = $scope.pages[index].app_page_link;
            } else {
                url = $scope.pages[index].page_link;
            }

            $rootScope.gotoLink(url);
        };

        $('#dln_tab_pages .tab-item').on('click', function (e) {
            e.preventDefault();

            var type = $(this).data('type');
            $('.tab-item-content').removeClass('active');
            $('.tab-item-content[data-type="' + type + '"]').addClass('active');

            $('#dln_tab_pages .tab-item.active').removeClass('active');
            $(this).addClass('active');
            if (type === 'feed') {
                $rootScope.$emit('onFeedRefreshFeeds', null);
            }
        });

        $scope.$on('$ionicView.enter', function () {
            $('#dln_tab_pages').show();
        });

        $scope.$on('$ionicView.leave', function () {
            $('#dln_tab_pages').hide();
        });

        $rootScope.$on('onFeedRefreshFeeds', function (e, args) {
            $scope._page = 0;
            $scope.last_request = '';
            sFeed.getFeeds($scope, true);
        });

        /* for feeds */
        $scope.scollGetFeeds = function () {
            sFeed.getFeeds($scope);
        };

        $scope.setFeeds = function (feeds) {
            $scope.feeds = feeds;
        };

        $scope.gotoPageLink = function () {
            var url = '';
            if ($rootScope.allowScheme) {
                url = $scope.page.app_page_link;
            } else {
                url = $scope.page.page_link;
            }

            $rootScope.gotoLink(url);
        };

        $scope.init = function () {
            fCache.init(function () {
                var pages = [];
                if (fCache.getPages().length) {
                    angular.forEach(fCache.getPages(), function (item) {

                        if ($stateParams.categoryId && item.category_id !== $stateParams.categoryId) {
                            return;
                        }

                        if (item.category_id) {
                            item.category = fCache.findCategoryById(item.category_id);
                        }

                        pages.push(item);
                    });
                    $scope.pages = pages;
                }

                $scope.loading = false;
                $scope.category_id = $stateParams.categoryId;
                sFeed.getFeeds($scope);
            });
        };
        $scope.init();

    });
