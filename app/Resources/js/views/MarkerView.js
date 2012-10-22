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
            'x'       :$('#marker-x').val(),
            'y'       :$('#marker-y').val(),
            'name'    :$('#marker-name').val(),
            'type'    :$('#marker-type').val(),
            'content' :$('#marker-content').val(),
            'canvasId':$('#marker-canvasId').val()
        });

        $('#marker-progress').html(' Saving marker...');

        App.activeCanvas.save({}, {
            success: function(model, response) {
                model.initiateMarkerCollection();
                $('#marker-progress').html(' Marker saved.');
            }
        });
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