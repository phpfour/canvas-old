var Project = Backbone.Model.extend({

    idAttribute: "id",

    urlRoot: function(){
        return App.baseUrl + 'projects'
    }

});