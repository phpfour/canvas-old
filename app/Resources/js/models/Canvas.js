var Canvas = Backbone.Model.extend({

    idAttribute: "id",

    urlRoot: function(){
        return App.baseUrl + 'canvases'
    }

});