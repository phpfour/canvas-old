var AppRouter = Backbone.Router.extend({

    routes: {
        ''           : 'home',
        'canvas/:id' : 'showCanvas',
        'logout'     : 'logOut',
        'settings'   : 'accountSettings'
    },

    initialize: function() {
        //_.bindAll(this, 'home','showCanvas', 'accountSettings', 'logout');

        if(typeof App.orphanCanvasList == 'undefined') {
            App.orphanCanvasList = new CanvasCollection();
        }

        if(App.canvasList != 'undefined') {
            App.orphanCanvasList.add(myCanvasList);
            App.canvasList = new CanvasListView({collection: App.orphanCanvasList});
        }
    },

    home: function() {
        App.hideSidebar();
        App.canvasList.render();
    },

    showCanvas: function(canvasId) {
        App.activeCanvas = App.orphanCanvasList.get(canvasId);
        new CanvasView({model: App.activeCanvas});

        App.showSidebar();
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
