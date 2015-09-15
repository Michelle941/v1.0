<?php
if(!$model->instagram_token):
    echo '<a id="refresh" href="'.$_SERVER['REQUEST_URI'].'" class="fancybox-ajax profile-update-photos__button">Please unblock browser popup for instagram</a>';
    $js = <<<JS
    window.open('$instagramtUrl');

    $(window).focus(function() {
        console.log('Focus');
        $( "#refresh" ).trigger( "click" );
    });
JS;
    $this->registerJs($js);
elseif(!isset($images->data) || empty($images->data)):?>
  <div class="popup">
      <p>Sorry but this feature only works </br> if your Instagram account is public.</p>
  </div>
<?php else:?>
    <div class="popup" style="width: 640px;">
        <div class="form">
            <h2 class="popup__title">Select Image</h2>
            <div class="members">
                <ul class="members__list" load-more-url="<?php echo isset($images->pagination->next_url) ? $images->pagination->next_url: ''?>">
                    <?php if(isset($images->data) && count($images->data) >0){foreach ($images->data as $photo){?>
                    <li class="members__item" >
                        <a onclick="saveImage('<?php echo @$_GET['type']?>', '<?php echo @$_GET['key']?>', '<?=$photo->images->standard_resolution->url;?>')" href="javascript:void(0)">
                            <img src="<?=$photo->images->thumbnail->url;?>" alt="">
                        </a>
                    </li>
                    <?php }}?>
                </ul>
            </div>
        </div>
    </div>

<?php
    $url = $images->pagination->next_url;
    $js = <<<JS
        function saveImage(type, key, image){
        $('div.popup').html('<div><img src="/images/fancybox_loading.gif"> </div>');
            $.ajax({
              type: "POST",
              url: '/user/save-instagram-image',
              data: {type:type, key:key, image:image},
              success: function(data){
                location.reload();
              },
              dataType: 'json'
            });
        }
    function loadMore(url){
    if(!url){return false;}
        $.ajax({
              type: "get",
              url: '/site/instagram-more-photos',
              data: {url:url},
              dataType: 'json',
              success: function(data){
                $('.members__list').append(data.html);
                if(data.next_url){
                loadMore(data.next_url);
                }
              }
            });
        }
    $(document).ready(function(){
      loadMore($('.members__list').attr('load-more-url'));
    })

JS;
    $this->registerJs($js);
endif;
?>