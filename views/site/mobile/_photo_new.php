<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="photo-view" data-id="<?php echo $photo->id; ?>" data-party="<?php echo $photo->party_id; ?>">
    <h2 class="modal_popup-title"> ADD PHOTO </h2>
    <figure class="photo">
        <img src="/upload/350x350<?php echo $photo->image; ?>" alt="" width="350" height="350">
    </figure>
    <div class="photo-comment">
        <textarea maxlength="100" placeholder="Say something funny"></textarea>
    </div>
    <div class="buttons photo-view_section">
        <button type="button" class="button" data-action="save">SAVE</button>
        <button type="cancel" class="button" data-action="delete">CANCEL</button>
    </div>
</div>