<div id="instagram" style="width: 815px;>
<?php
if(!$model->instagram_token):
    echo '<a id="refresh" href="/site/instagram-photos/'.$model->id.'" class="fancybox-ajax">Please unblock browser popup for instagram and Click here</a>';
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
    <div class="popup">
        <div class="form">
            <h2 class="popup__title" style="text-align:center">Select Image</h2>
            <div class="members">
                <ul class="members__list" load-more-url="<?php echo  isset($images->pagination->next_url) ? $images->pagination->next_url: ''?>">
                    <?php if(isset($images->data) && count($images->data) >0){foreach ($images->data as $photo){?>
                    <li class="members__item">
                        <a onclick="saveImage('<?=$photo->images->standard_resolution->url;?>')" href="javascript:void(0)">
                            <img src="<?=$photo->images->thumbnail->url;?>" alt="">
                        </a>
                    </li>
                    <?php }}?>
                </ul>
            </div>
        </div>
    </div>

<?php
    $js = <<<JS
      $.fancybox._setDimension();
      $.fancybox.reposition()
        function saveImage(image){
        $('div.popup').html('<div><img src="/images/fancybox_loading.gif"> </div>');
            $.ajax({
              type: "POST",
              url: '/site/save-instagram-avatar',
              data: {image:image},
              success: function(data){
                console.log(data);
                $('div#instagram').html(data).css('width', '330px');
                $.fancybox._setDimension();
                $.fancybox.reposition();
              }
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
</div>