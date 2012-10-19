var CanvasListView = Backbone.View.extend({

    el: '#main',

    initialize: function() {
        this.render();
    },

    render: function() {
        var canvasListItems = '';
        App.orphanCanvasList.each(function(canvas) {
            canvasListItems += '<li  class="span3 canvas-thumb"><a href="#canvas/'+ canvas.id +'" class="thumbnail">'
            canvasListItems += '<img src="'+ App.baseUrl + App.IMG_ROOT + canvas.get('image') +'" alt="" /></a>';
            canvasListItems += canvas.get('title') +'</li>'
        });

        $(this.el).html(_.template(Templates.CanvasList, {canvasList: canvasListItems}));
        return this;
    },

    events: {
        //'click .canvas-thumb' : 'showCanvas'
    },

    initScrollEvent:function () {
        var self = this;
        $(this.el).scroll(function () {
            var divHeight = parseInt($(self.el).scrollTop()) + parseInt($(self.el).height()) + 1;
            if (divHeight == $(self.el)[0].scrollHeight) {
                var renderedSeekers = '';
                var limit = $(self.el).find(".job:last").attr('limit');
                var start = parseInt($(self.el).find(".job:last").attr('start')) + parseInt(limit);
                $.getJSON('/jobs' + "?limit=" + limit + "&start=" + start, function (jobs) {
                    App.jobs.add(jobs);
                    App.seeker_limit = limit;
                    App.seeker_start = start;
                    _.each(jobs, function (job) {
                        var jobModel = new Job(job);
                        var jobData = jobModel.toJSON();
                        jobData.limit = App.provider_limit;
                        jobData.start = App.provider_start;
                        renderedSeekers += _.template(Templates.JobListItem, jobData);

                    });

                    $(self.el).find(".job:last").after(renderedSeekers);
                });

            }
        });
    }




});