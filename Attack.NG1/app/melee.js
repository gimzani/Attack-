(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.controller('meleeCtrl',
    ['$scope', '$http',
    function ($scope, $http) {

        $scope.restrictions = ["Green"];
        $scope.range = 0;
        $scope.currentEnemy = {
            Name: "Bob",
            Book_ID: 1,
            MaxHP: 12,
            CurHP: 8,
            Height: 8,
            State: 57
        }
        
        function getByRange(range) {
            $scope.availableAttacks = [];
            for (var i = 0; i < $scope.attacks.length; i++) {
                if (range==1 && $scope.attacks[i].Style == "Extended Range") {
                    $scope.availableAttacks.push($scope.attacks[i]);
                } else if (range == 0 && $scope.attacks[i].Style != "Extended Range") {
                    $scope.availableAttacks.push($scope.attacks[i]);
                } 
            }
            console.log($scope.availableAttacks);
        }
                
        function restrictAttacks() {
            var attacks = [];
            for (var i = 0; i < $scope.availableAttacks.length; i++) {
                var addIt = true;
                for (var j = 0; j < $scope.restrictions.length; j++) {
                    if ($scope.restrictions[j] == $scope.availableAttacks[i].Type) {
                        addIt = false;
                        break;
                    }
                }
                if (addIt) {
                    attacks.push($scope.availableAttacks[i]);
                }
            }
            $scope.availableAttacks = attacks;
        }


        function renderRound(restrictions) {
            getByRange($scope.range);
            restrictAttacks(restrictions);
        }

        function loadAttacks() {
            $http.get('/content/data/attacks.json').success(function (res) {
                $scope.attacks = res;
                console.log($scope.attacks);
                renderRound();
            }).error(function (res) { console.log(res); });
        }

        function Init() {
            loadAttacks();
        }
        Init();


    }]);
    //-------------------------------------------------------------------------
})()