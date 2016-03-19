<?php
use app\models\Config;
/* @var $this yii\web\View */
$this->title = '941 Social Club';
?>
<style>
    .home .home__item{height:315px;width: 460px;}
</style>
<section class="home">
    <?php
    for($i=1; $i<5; $i++)
    {
        ?>
        <article class="home__item">
            <a href="<?=Config::getValue('mainPage', 'url'.$i);?>" <?php if(Config::getValue('mainPage', 'is_popup'.$i)) echo 'class="fancybox"'; ?>>
                <div class="home__text">
                        <img src="<?=Yii::$app->params['flayerPath'];?>/<?=Config::getValue('mainPage', 'image'.$i.'hover');?>" alt="" width="460" class="grayscale grayscale-fade">
                        <?=Config::getValue('mainPage', 'text'.$i);?>
                </div>
                <img src="<?=Yii::$app->params['flayerPath'];?>/<?=Config::getValue('mainPage', 'image'.$i);?>" alt="" width="460" class="grayscale grayscale-fade">
            </a>
        </article>
        <?php
    }
    ?>
</section>
<?php
if(isset($loginForm) && $loginForm === true){
    $js = <<<JS
    $(function() {
      $( "#login-url" ).trigger( "click" );
    });

JS;
    $this->registerJs($js);
}
?>