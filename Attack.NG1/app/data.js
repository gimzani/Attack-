(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.factory('data',
    ['$http', function ($http) {

        var root = 'http://www.strayhold.com/attack/';

        return {
            register: function (email) { return $http.get(root + 'signin.php?e=' + email); },
            newAvatar: function (p, b, n) { return $http.get(root + 'new.php?p=' + p + '&b=' + b + '&n=' + n); },
            selectAvatar: function (p, a) { return $http.get(root + 'enter.php?p=' + p + '&a=' + a); },
            findMelee: function (p, lat, long) { return $http.get(root + 'find.php?p=' + p + '&lat=' + lat + '&long=' + long); },
            joinMelee: function (a, t, s) { return $http.get(root + 'join.php?a=' + a + '&t=' + t + '&s=' + s); },
            attack: function (a, t, s) { return $http.get(root + 'atk.php?c=' + c + '&r=' + r + '&a=' + a + '&t=' + t); },
            reset: function (a, t, s) { return $http.get(root + 'reset.php'); }
        }
               

    }]);
    //-------------------------------------------------------------------------
})()