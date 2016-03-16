/**
 * Created by Atiwong on 2/10/2016.
 */
var CameraTool = {
    element: undefined,
    video:undefined,
    status:"uninit",
    state: function(){
        return this.state;
    },
    initCameraOn : function(id) {
        this.element = $("#"+id);
        this.video = $("<video></video>").css({"width":"100%","height":"100%"});
        //this.video = $("<video></video>");
        this.element.addClass("camera").html("").append(this.video);
        navigator.getUserMedia
            = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia;

        if (navigator.getUserMedia) {
            navigator.getUserMedia(
                {audio: true, video: true},
                function (stream) {
                    CameraTool.video.attr("src", window.URL.createObjectURL(stream));
                    CameraTool.video[0].play();
                    CameraTool.status = "on";
                }, handleInitError);
        } else {
            handleInitError();
        }
        function handleInitError() {
            video.remove();
            element.append($("<div>Cannot initialize the video stream</div>"));
        }
    },
    captureTo: function(id){
        var canvas = $("#"+id);
        canvas[0].getContext("2d").drawImage(CameraTool.video[0],0,0,canvas.width(),canvas.height());
        this.status = "loaded";
    },
    hideCamera: function(){
        this.element.html("");
        this.status = "uninit";
    }
};