var MarkerView = Backbone.View.extend({

    container: '#marker-form',

    initialize: function() {
        this.render();
    },

    render: function() {
        this.$el.html(_.template(Templates.MarkerInfo, this.model.toJSON()));
        $(this.container).append(this.$el);
        return this;
    },

    events: {
        'click .delete-marker' : 'deleteMarker',
        'click .update-marker' : 'updateMarker',
        'click .close'         : 'close'
    },

    updateMarker: function(e) {
        App.log('Updating Marker');
    },

    deleteMarker: function(e) {
        App.log('Deleting Marker');
    },

    close: function(){
        $('#' + this.model.id).removeClass('marker3');
        this.unbind();
        this.remove();
    }

});