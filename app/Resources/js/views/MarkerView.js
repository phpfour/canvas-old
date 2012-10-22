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

        var modelId = this.model.id;

        App.editingMarker = App.activeCanvas.get('markers').get(modelId).set({
            'x'       : $('#marker-x').val(),
            'y'       : $('#marker-y').val(),
            'name'    : $('#marker-name').val(),
            'type'    : $('#marker-type').val(),
            'details' : $('#marker-content').val(),
            'canvasId': $('#marker-canvasId').val()
        });

        App.log(App.editingMarker);

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