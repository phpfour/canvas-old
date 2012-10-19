var App = {

    init: function() {

        $('#addProjectAction').click(function(){
            App.addProject();
        });

        $('#canvas-img').click(function(e){

            var offset = $(this).position();

            var x = e.pageX - offset.left - 50;
            var y = e.pageY - offset.top - 5;

            console.log(x +', '+ y);

            var newMarker = document.createElement('div');
            var id = Math.round(100 * Math.random());

            $(newMarker).addClass('marker').addClass('marker1')
                        .attr('id', 'clickover' + id)
                        .attr('rel', 'clickover')
                        //.html(id)
                        .css({top: y + 'px', left: x + 'px'});

            $('#canvas-img').append(newMarker);

            console.log(e.target);

        });
    },

    addProject: function() {
        $('#addProject').modal();
    }

};