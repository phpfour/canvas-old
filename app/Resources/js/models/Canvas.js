var Canvas = Backbone.Model.extend({

    idAttribute:"id",

    initialize:function () {
        this.initiateMarkerCollection();
    },

    initiateMarkerCollection: function() {
        if (this.attributes.markers.length > 0) {
            this.set('markers', new MarkerCollection(this.attributes.markers))
        } else {
            this.set('markers', new MarkerCollection())
        }
    },

    urlRoot:function () {
        return App.baseUrl + 'canvases'
    },

    sync:function (method, model, options) {

        if (method === "update") {
            method = "create";
        }    // turns PUT into POST

        if (method == "create") {
            this.url = this.urlRoot()
        }

        return Backbone.sync(method, model, options);
    }

});