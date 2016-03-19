<?php
$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
?>

<?php if ($isMobile): ?>
    <?php if (!$model->instagram_token): ?>
        <p>
            <a id="refresh" href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="ajax-link">Please unblock browser popup for instagram</a>
        </p>
        <script>
            window.open('<?php echo $instagramtUrl; ?>');

            $(window).focus(function () {
                console.log('Focus');
                $("#refresh").trigger("click");
            });
        </script>
        <?php return; ?>
    <?php endif; ?>

    <?php if (isset($images->data) && !empty($images->data)): ?>
        <h2 class="title">Select Image</h2>
        <ul class="instagram-photos" load-more-url="<?php echo isset($images->pagination->next_url) ? $images->pagination->next_url : '' ?>">
            <?php if (isset($images->data) && count($images->data) > 0): ?>
                <?php foreach ($images->data as $photo): ?>
                    <li class="photo">
                        <img src="<?php echo $photo->images->thumbnail->url; ?>" alt=""
                             data-image="<?php echo $photo->images->standard_resolution->url; ?>"
                             data-key="<?php echo @$_GET['key']; ?>" data-type="<?php echo @$_GET['type']; ?>">
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    <?php else: ?>
        <p>
            Sorry but this feature only works </br>
            if your Instagram account is public.
        </p>
    <?php endif; ?>

    <?php return; ?>
<?php endif; ?>

<?php
if (!$model->instagram_token):
    echo '<a id="refresh" href="' . $_SERVER['REQUEST_URI'] . '" class="fancybox-ajax profile-update-photos__button">Please unblock browser popup for instagram</a>';
    $js = <<<JS
    window.open('$instagramtUrl');

    $(window).focus(function() {
        console.log('Focus');
        $( "#refresh" ).trigger( "click" );
    });
JS;
    $this->registerJs($js);
elseif (!isset($images->data) || empty($images->data)):
    ?>
    <div class="popup">
        <p>Sorry but this feature only works </br> if your Instagram account is public.</p>
    </div>
<?php else: ?>
    <section id="join">
        <div class="popup" style="width: 640px;">
            <div class="form">
                <h2 class="popup__title" style:"text-align: center">Select Image</h2>
                <br>
                <div class="members">
                    <ul class="members__list" load-more-url="<?php echo isset($images->pagination->next_url) ? $images->pagination->next_url : '' ?>">
                        <?php
                        if (isset($images->data) && count($images->data) > 0) {
                            foreach ($images->data as $photo) {
                                ?>
                                <li class="members__item" >
                                    <a onclick="saveImage('<?php echo @$_GET['type'] ?>', '<?php echo @$_GET['key'] ?>', '<?= $photo->images->standard_resolution->url; ?>')" href="javascript:void(0)">
                                        <img src="<?= $photo->images->thumbnail->url; ?>" alt="">
                                    </a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <?php
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
