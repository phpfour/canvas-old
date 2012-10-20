var CanvasView = Backbone.View.extend({

    el: '#main',

    initialize: function() {
        this.render();
    },

    render: function() {
        $(this.el).html(_.template(Templates.Canvas, this.model.toJSON()));
        return this;
    },

    events: {
        'click #canvas' : 'addMarker'
    },

    addMarker: function(e) {
        //If clicked on existing marker, return
        if($(e.target).attr('id') != 'canvas') return;

        var offset = $(e.target).position();

        var x = e.pageX - (offset.left + 20); // 40 = 30 for adjustment + 10 for to make center
        var y = e.pageY - (offset.top + 40);

        App.log(offset);
        App.log(e.pageX +', '+ e.pageY);

        var newMarker = document.createElement('div');
        var id = 'clickover-'+ x +'-'+ y;

        $(newMarker).addClass('marker marker1')
                    .attr('id', id)
                    .attr('rel', 'clickover')
                    .css({top: y + 'px', left: x + 'px'});

        $(e.target).append(newMarker);
        App.activeCanvas.get('markerCollection').add(new Marker({
            'id': id,
            'x': x,
            'y': y,
            'canvasId': App.activeCanvas.id
        }));
    }

});