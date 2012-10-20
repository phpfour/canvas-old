var Canvas = Backbone.Model.extend({

    idAttribute: "id",

     initialize: function() {
         if(this.attributes.markers.length > 0){
             this.set('markerCollection', new MarkerCollection(this.attributes.markers))
         } else {
             this.set('markerCollection', new MarkerCollection())
         }
     },

    urlRoot: function(){
        return App.baseUrl + 'canvases'
    }

});