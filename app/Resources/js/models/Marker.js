var Marker = Backbone.Model.extend({

    idAttribute: "id",

    defaults: {
        "type" : "text"
    },

    urlRoot: function(){
        return App.baseUrl + 'markers'
    }

});