(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.controller('registrationCtrl',
    ['$scope', '$state', 'data', 'objFactory',
    function ($scope, $state, data, objFactory) {

        $scope.email = '';

        console.log($scope.$parent.playerData);


        $scope.validate = function (inputForm) {
            if (inputForm.$valid) {
                data.register($scope.email).success(function (res) {
                    console.log(res);
                    objFactory.newPlayer(res[0]);
                    $state.go('selectAvatar');
                }).error(function (res) { console.log(res) });
            }
        }

    }]);
    //-------------------------------------------------------------------------
})()