<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Edit party: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Party manage', 'url' => ['pages']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pages-update">

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="<?=($tab == 1)? 'active' : '';?>">
                <a data-toggle="tab" href="#tab_1" aria-expanded="false">Main info</a>
            </li>
            <li class="<?=($tab == 2)? 'active' : '';?>">
                <a data-toggle="tab" href="#tab_2" aria-expanded="true">Flash Sale</a>
            </li>
            <li class="<?=($tab == 3)? 'active' : '';?>">
                <a data-toggle="tab" href="#tab_3" aria-expanded="true">Regular Sale</a>
            </li>
            <li class="<?=($tab == 4)? 'active' : '';?>">
                <a data-toggle="tab" href="#tab_4" aria-expanded="true">Past Party</a>
            </li>
            <li class="">
                <a href="<?=\yii\helpers\Url::to(['/admin/party-photo', 'id' => $model->id]);?>" >Photo</a>
            </li>
            <li class="<?=($tab == 5)? 'active' : '';?>">
                <a data-toggle="tab" href="#tab_5" aria-expanded="true">Attach members profile</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab_1" class="tab-pane <?=($tab == 1)? 'active' : '';?>">
                <br><br>
                <?= $this->render('_formParty', [
                    'model' => $model,
                    'contact' => $contact,
                    'members' => $members,
                    'staff'   => $staff
                ]) ?>
            </div>
            <div id="tab_2" class="tab-pane <?=($tab == 2)? 'active' : '';?>">
                <?php echo $this->render('add-sale', ['model' => $flashSale, 'tab' => 2]);?>
            </div>

            <div id="tab_3" class="tab-pane <?=($tab == 3)? 'active' : '';?>">
                <?php echo $this->render('add-sale', ['model' => $regSale, 'tab' => 3]);?>
            </div>
            <div id="tab_4" class="tab-pane <?=($tab == 4)? 'active' : '';?>">
                <?php echo $this->render('past-party-banners', ['model' => $model, 'tab' => 4]);?>
            </div>
            <div id="tab_5" class="tab-pane <?=($tab == 5)? 'active' : '';?>">
                <div class="pages-form">
                    <div class="row">
                    <h2>Attach members profile</h2>
                    <p><?= Html::button(
                            'Add',
                            ['value' => Url::to(['attach-user', 'partyID'=> $model->id]),
                                'class' => 'btn btn-success modalButton'
                            ]) ?>
                    </p>
                    <div class="col-md-12" id="attached">
                        <?php
                        echo $this->render('_members2party', ['members' => $members, 'id' => $model->id]);
                        ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'modal'
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>