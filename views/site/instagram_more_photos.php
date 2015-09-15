<?php if(isset($images->data) && !empty($images->data)):?>
    <?php if(isset($images->data) && count($images->data) >0){foreach ($images->data as $photo){?>
    <li class="members__item">
        <a onclick="saveImage('<?=$photo->images->standard_resolution->url;?>')" href="javascript:void(0)">
            <img src="<?=$photo->images->thumbnail->url;?>" alt="">
        </a>
    </li>
    <?php }}?>
<?php endif;?>