<style>
    #pizacat-video{cursor: pointer;}
    .fancybox-skin{padding: 0px !important;}
</style>

<link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="//vjs.zencdn.net/4.12/video.js"></script>
<video id="pizacat-video" class="video-js vjs-default-skin" loop autoplay controls preload="auto" width="100%" height="100%"'>
    <source src="/video/-Pizza_Cat_v5.mov" type='video/mp4' />
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>

<script>
    $('#pizacat-video').on('click', function(){
        window.location = '/parties';
    })
</script>