var CanvasCollection = Backbone.Collection.extend({
    model: Canvas,
    url: function(){
        return App.baseUrl + 'canvases'
    }
});