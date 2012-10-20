var Canvas = Backbone.Model.extend({

    idAttribute: "id",

     initialize: function() {
         if(this.attributes.markers.length > 0){
             this.set('markerCollection', new MarkerCollection(this.attributes.markers))
         } else {
             this.set('markerCollection', new MarkerCollection())
         }
     },

    urlRoot: function() { return App.baseUrl + 'canvases'},

    sync: function(method, model, options) {
        if (method === "update") method = "create";    // turns PUT into POST
        return Backbone.sync(method, model, options);
    }

});