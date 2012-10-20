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
        App.editingMarker.set({
            'name': $('#marker-name').val(),
            'type': $('#marker-type').val(),
            'content': $('#marker-content').val()
        });
        App.activeCanvas.save();
    },

    deleteMarker: function(e) {
        App.activeCanvas.save();
    },

    close: function(){
        $('#' + this.model.id).removeClass('marker3');
        this.unbind();
        this.remove();
    }

});