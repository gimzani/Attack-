(function () {
    //-------------------------------------------------
	'use strict'
	var app = angular.module("attack", ['ui.router', 'oc.lazyLoad']);
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
	app.config(
    ['$stateProvider', '$urlRouterProvider',
    function ($stateProvider, $urlRouterProvider) {
        
	    $urlRouterProvider.otherwise('/');

	    $stateProvider
        .state('mainMenu', {
            url: '/',
            templateUrl: "app/views/mainMenu.html",
            controller: 'mainMenuCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                    return $ocLazyLoad.load('app/mainMenu.js');
                }]
            }
        })
        .state('registration', {
            url: '/registration',
            templateUrl: "app/views/registration.html",
            controller: 'registrationCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                    return $ocLazyLoad.load('app/registration.js');
                }]
            }
        })
        .state('createAvatar', {
            url: '/createAvatar',
            templateUrl: "app/views/createAvatar.html",
            controller: 'createAvatarCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                    return $ocLazyLoad.load('app/createAvatar.js');
                }]
            }
        })
        .state('selectAvatar', {
            url: '/selectavatar',
            templateUrl: "app/views/selectAvatar.html",
            controller: 'selectAvatarCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                    return $ocLazyLoad.load('app/selectAvatar.js');
                }]
            }
        })
        .state('findMelee', {
            url: '/findmelee',
            templateUrl: "app/views/findMelee.html",
            controller: 'findMeleeCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                    return $ocLazyLoad.load('app/findMelee.js');
                }]
            }
        })
        .state('melee', {
            url: '/melee',
            templateUrl: "app/views/melee.html",
            controller: 'meleeCtrl',
            resolve: {
                deps: ['$ocLazyLoad', function ($ocLazyLoad) {
                    return $ocLazyLoad.load('app/melee.js');
                }]
            }
        });
	}]);
    //-------------------------------------------------------------------------
})()