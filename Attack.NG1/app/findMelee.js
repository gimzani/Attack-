(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.controller('findMeleeCtrl',
    ['$scope', 'data', 'objFactory',
    function ($scope, data, objFactory) {



        function findMelees() {

            $scope.playerData = objFactory.getPlayer();

            data.findMelee($scope.playerData.Player.Player_ID).success(function (res) {
                $scope.melees = res;
                console.log($scope.melees);
            }).error(function (res) { console.log(res)});

        }


        function Init() {
            findMelees();
        }
        Init();


    }]);
    //-------------------------------------------------------------------------
})()