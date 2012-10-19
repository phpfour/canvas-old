var App = {

    init: function() {

        App.adjustStyle();
        App.bindGlobalEvents();

        this.appRouter = new AppRouter();
        Backbone.history.start();
    },



    addProject: function() {
        $('#addProject').modal();
    },

    addCanvas: function() {
        $('#addCanvas').modal();
    }

};

App.HEADER_HEIGHT = 40;
App.IMG_ROOT      = 'uploads/';

App.adjustStyle = function() {
    $('#content').css('height', $(window).height() - App.HEADER_HEIGHT + 'px'); // 41 is navbar height
}

App.bindGlobalEvents = function() {
    $('[rel=tooltip]').tooltip();

    $('#add-project').click(function(){
        App.addProject();
    });

    $('#add-canvas').click(function(){
        App.addCanvas();
    });

    $('#canvas').click(function(e){
        //If clicked on existing marker, return
        if($(e.target).attr('id') != 'canvas') return;

        var offset = $(e.target).position();

        var x = e.pageX - (offset.left + 35); // 40 = 30 for adjustment + 10 for to make center
        var y = e.pageY - (offset.top + 40);

        App.log(offset);
        App.log(e.pageX +', '+ e.pageY);

        var newMarker = document.createElement('div');
        var id = Math.round(100 * Math.random());

        $(newMarker).addClass('marker marker1')
                    .attr('id', 'clickover-'+ x +'-'+ y)
                    .attr('rel', 'clickover')
                    //.html(id)
                    .css({top: y + 'px', left: x + 'px'});

        $(e.target).append(newMarker);
    });

    $('.marker').live('click', function(e){
        e.stopPropagation();
        alert('Edit Marker info');
    });
}

App.showSidebar = function(){
    $('#sidebar-right').show();
    $('#main').animate({width: '45%'});
}

App.hideSidebar = function(){
    $('#main').animate({width: '65%'}, {complete: function(){$('#sidebar-right').hide();}});
}


App.log = function(objectToLog) {
    if(typeof console != 'undefined' && typeof console.log == 'function') {
        console.log(objectToLog);
    }
}
