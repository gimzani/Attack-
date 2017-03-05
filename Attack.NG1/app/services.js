(function () {
    //-------------------------------------------------
    'use strict'
    var app = angular.module("attack");
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.factory('storage', [function () {
        //-------------------------------
        var storageKey = "data";
        //---------------------------------------------------
        return {
            store: store,
            retrieve: retrieve,
            destroy: destroy
        };
        //==================================================  private
        //---------------------------------------  store object
        function store(obj) {
            var json = JSON.stringify(obj);
            return localStorage.setItem(storageKey, json);
        }
        //---------------------------------------  retrieve object
        function retrieve() {
            var json = localStorage.getItem(storageKey);
            return JSON.parse(json);
        }
        //---------------------------------------  delete token - (sign-out)
        function destroy() {
            localStorage.removeItem(storageKey);
        }
        //---------------------------------------
    }]);
    //-------------------------------------------------------------------------
    //-------------------------------------------------------------------------
    app.factory('objFactory', ['storage', function (storage) {
        //---------------------------------------------------
        return {
            newPlayer: newPlayer,
            getPlayer:getPlayer,
            newAvatar: newAvatar,
            selectAvatar: selectAvatar
        };
        //==================================================
        function newPlayer(req) {
            var obj = {
                Player: {
                    Player_ID: req.Player_ID,
                    Team: req.Team,
                    selectedAvatar: {}
                },
                Avatars: []
            };
            console.log(obj);
            storage.store(obj);
        }
        //---------------------------------------------------
        function getPlayer(avatar) {
            return storage.retrieve();          
        }
        //---------------------------------------------------
        function newAvatar(Avatar_ID, name, avatar) {
            var obj = storage.retrieve();
            var newAvatar = {
                Avatar_ID: Avatar_ID,
                Book_ID: avatar.Book_ID,
                Name: name,
                Pic: avatar.Pic,
                MaxHp: avatar.HP,
                CurHp: avatar.HP,
                Height:avatar.Height
            };
            obj.Player.selectedAvatar = newAvatar;
            obj.Avatars.push(newAvatar);
            storage.store(obj);
        }
        //---------------------------------------------------
        function selectAvatar(id) {
            var obj = storage.retrieve();
            for (var i = 0; i < obj.Avatars.length; i++) {
                if (obj.Avatars[i].ID == id) {
                    obj.Player.selectedAvatar = obj.Avatars[i];
                    break;
                }                    
            }
            storage.store(obj);
        }
        //---------------------------------------------------
    }]);
    //-------------------------------------------------------------------------
})()