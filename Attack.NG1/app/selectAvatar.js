(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.controller('selectAvatarCtrl',
    ['$scope', '$state', '$http', 'data','objFactory',
    function ($scope, $state, $http, data, objFactory) {
        //-------------------------------------------------
        $scope.cycleAvatar = function (dir) {
            cycleAvatar(dir);
        }
        //-------------------------------------------------
        $scope.selectAvatar = function (form) {
            //--------------------------
            if (form.$valid) {
                selectAvatar();
            }
            //--------------------------
        }

        //-------------------------------------------------
        //-------------------------------------------------
        function selectAvatar() {
            //--------------------------
            var obj = objFactory.getPlayer();
            //--------------------------
            data.newAvatar(obj.Player.Player_ID, $scope.selectedAvatar.Book_ID, $scope.avatarName).success(function (res) {
                //--------------------------
                var Avatar_ID = res;

                console.log(res);

                objFactory.newAvatar(Avatar_ID, $scope.avatarName, $scope.selectedAvatar);
                //--------------------------
                data.selectAvatar(obj.Player.Player_ID, Avatar_ID).success(function (res) {
                    console.log(res);
                    $state.go("findMelee");
                }).error(function (res) { console.log(res); });
                //--------------------------
            }).error(function (res) { console.log(res); });
        }
        //-------------------------------------------------
        function cycleAvatar(dir) {
            $scope.avatarIndex += dir;
            if ($scope.avatarIndex >= $scope.playerData.Avatars.length) {
                $scope.avatarIndex = 0;
            } else if ($scope.avatarIndex < 0) {
                $scope.avatarIndex = $scope.playerData.Avatars.length - 1
            }
            $scope.selectedAvatar = $scope.playerData.Avatars[$scope.avatarIndex];

            console.log($scope.selectedAvatar);
        }
        //-------------------------------------------------
        function getArchtypes() {
            $scope.avatarIndex =0;
            $scope.playerData = objFactory.getPlayer();

            $scope.selectedAvatar = $scope.playerData.Avatars[$scope.avatarIndex];

            console.log($scope.selectedAvatar);
        }
        //-------------------------------------------------
        function Init() {
            getArchtypes();
        }
        Init();
        //-------------------------------------------------
    }]);
    //-------------------------------------------------------------------------
})()