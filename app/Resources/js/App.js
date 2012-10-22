var App = {

    appRouter: null,
    formData: new FormData(),
    currentProject: null,

    init: function() {

        this.editingMarker = null;

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

    $('.marker').live('click', function(e) {
        if(App.editingMarker != null){
            App.editingMarkerView.close();
        }

        var modelId = $(e.target).attr('id');
        App.log(App.activeCanvas.get('markers'));
        App.editingMarker = App.activeCanvas.get('markers').get(modelId);
        App.editingMarkerView = new MarkerView({model:App.editingMarker});
        $('#'+modelId).addClass('marker3');
        //App.activeCanvas.get('markers').add(App.editingMarker);
    });

    $("#addCanvas").find('.btn-primary').click(function(){

        App.formData.append('title', $("#addCanvas").find('input[name=title]').val());
        App.formData.append('details', $("#addCanvas").find('textarea[name=details]').val());

        if (App.currentProject) {
            App.formData.append('project_id', App.currentProject.id);
        }

        $('#canvas-progress').html("Uploading canvas...");

        $.ajax({
            url: "/canvases",
            type: "POST",
            data: App.formData,
            processData: false,
            contentType: false,
            success: function (res) {
                $('#addCanvas').modal('hide')
                App.orphanCanvasList.add(res);
                App.canvasList.render();
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

App.showSidebar = function(canvas){

    App.log(canvas);

    $('#canvas-info').find('h4').text(canvas.get('title')).end()
                     .find('p').text(canvas.get('details'));

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