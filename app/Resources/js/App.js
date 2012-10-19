var App = {

    appRouter: null,
    formData: new FormData(),
    currentProject: null,

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

    $("#addCanvas").find('.btn-primary').click(function(){

        App.formData.append('title', $("#addCanvas").find('input[name=title]').val());
        App.formData.append('details', $("#addCanvas").find('textarea[name=details]').val());

        if (App.currentProject) {
            App.formData.append('project_id', App.currentProject.id);
        }

        $.ajax({
            url: "/canvases",
            type: "POST",
            data: App.formData,
            processData: false,
            contentType: false,
            success: function (res) {
                console.log(res);
            }
        });

    });

    $("#addCanvas").find("input[type=file]").change(function(){

        var file = this.files[0];

        if (file.type.match(/image.*/)) {
            if (window.FileReader) {
                var reader = new FileReader();
                reader.readAsDataURL(file);
            }
            App.formData.append("image", file);
        }

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
