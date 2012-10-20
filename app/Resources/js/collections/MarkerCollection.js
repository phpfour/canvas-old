var MarkerCollection = Backbone.Collection.extend({
    model: Marker,
    url: function(){
        return App.baseUrl + 'markers'
    }
});