(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.controller('mainMenuCtrl',
    ['$scope', 'objFactory',
    function ($scope, objFactory) {

        $scope.showContinue = false;
        $scope.playerData = objFactory.getPlayer();
        if ($scope.playerData) {
            $scope.showContinue = true;
        }

    }]);
    //-------------------------------------------------------------------------
})()