var AppRouter = Backbone.Router.extend({

    routes: {
        ''           : 'home',
        'canvas/:id' : 'showCanvas',
        'logout'     : 'logOut',
        'settings'   : 'accountSettings'
    },

    initialize: function() {
        //_.bindAll(this, 'home','showCanvas', 'accountSettings', 'logout');
    },

    home: function() {

    },

    showCanvas: function(canvasId) {
    },

    logOut: function() {
        window.location = App.baseUrl + 'auth/logout';
    },

    accountSettings: function() {
//        var userModel = new User(App.user);
//        console.log(userModel);
//        App.loadView('main', new UserSettingsView({ model : userModel}));
    }

});
