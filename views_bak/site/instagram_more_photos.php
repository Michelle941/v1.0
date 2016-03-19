<?php
$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile');
?>
<?php if (isset($images->data) && !empty($images->data)): ?>
    <?php if (isset($images->data) && count($images->data) > 0): ?>
        <?php foreach ($images->data as $photo): ?>
            <?php if ($isMobile): ?>
                <li class="photo">
                    <img src="<?php echo $photo->images->thumbnail->url; ?>" alt=""
                         data-image="<?php echo $photo->images->standard_resolution->url; ?>"
                         data-key="<?php echo @$_GET['key']; ?>" data-type="<?php echo @$_GET['type']; ?>">
                </li>
            <?php else: ?>
                <li class="members__item">
                    <a onclick="saveImage('<?= $photo->images->standard_resolution->url; ?>')" href="javascript:void(0)">
                        <img src="<?= $photo->images->thumbnail->url; ?>" alt="">
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>