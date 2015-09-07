<?php
foreach($staff as $s)
{
    ?>
    <div class="col-lg-6">
        <img src="/upload/50x50<?=$s->user->avatar;?>">
    </div>
    <div class="col-lg-6">
        <?=$s->user->name.' '.$s->user->last_name;?>
    </div>
<?php
}