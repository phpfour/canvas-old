var CanvasView = Backbone.View.extend({

    el: '#main',

    initialize: function() {
        this.render();
    },

    render: function() {
        var json =  _.extend(this.model.toJSON(), {markersHtml: this.getMarkersHtml()});
        $(this.el).html(_.template(Templates.Canvas, json));
        return this;
    },

    events: {
        'click #canvas' : 'addMarker'
    },

    addMarker: function(e) {

        //If clicked on existing marker, return
        if ($(e.target).attr('id') != 'canvas') {
            return;
        }

        var offset = $(e.target).position();

        var x = Math.round(e.pageX - (offset.left + 10)); // 40 = 30 for adjustment + 10 for to make center
        var y = Math.round(e.pageY - (offset.top + 40));

        var newMarker = document.createElement('div');
        var id = 'marker-'+ x +'-'+ y;

        $(newMarker).addClass('marker marker1')
                    .attr('id', id)
                    .css({top: y + 'px', left: x + 'px'});

        $(e.target).append(newMarker);

        App.activeCanvas.get('markers').add(new Marker({
            'x'       : x,
            'y'       : y,
            'id'      : id,
            'type'    : $('.create-marker.active').eq(0).data('marker-type'),
            'name'    : 'Marker ' + (App.activeCanvas.get('markers').length + 1),
            'details' : '',
            'canvasId': App.activeCanvas.id
        }));

        $(newMarker).click();

        App.activeCanvas.save({}, {
            success: function(model, response) {
                model.initiateMarkerCollection();
            }
        });

    },

    getMarkersHtml: function() {

        var output = '';

        this.model.get('markers').each(function(marker) {
            output += _.template(Templates.Marker, marker.toJSON());
        });

        return output;
    }

});