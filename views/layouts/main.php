<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta name="viewport" content="width=1280">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .load-more, a.button, div.button, .form .button, .photos__actions a, .form .profile-update-photos__button{
            background: #3B3B3B;
        }
        .fancybox-type-swf{cursor: pointer;}
    </style>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-67013751-1', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>

<?php $this->beginBody() ?>

<div class="wrapper">
    <header class="header">
        <div class="header__inner">
	        <?php
	        $controller = Yii::$app->controller;
	        $default_controller = Yii::$app->defaultRoute;
	        $isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
	        ?>
            <div class="logo">
	            <?php if($isHome == true): ?>
                    <h1>941 Social Club</h1>
	            <?php else: ?>
		            <a href="<?=Yii::$app->homeUrl;?>">941 Social Club</a>
	            <?php endif; ?>
            </div>
            <nav class="nav nav--left">
                <ul>
                    <li><a href="<?=Url::to(['/site/parties']);?>">Parties</a></li>
                    <li><a href="<?=Url::to(['/site/members'])?>">Members</a></li>
                </ul>
            </nav>
            <nav class="nav nav--right">
                <?php
                if(Yii::$app->user->isGuest) {
                    ?>
                    <ul>
                        <li><a href="#join" class="fancybox" id="join-url">Join</a></li>
                        <li><a href="#login" class="fancybox" id="login-url">Log in</a></li>
                    </ul>
                <?php
                }
                else {
                    ?>
                    <ul>
                        <li><a href="<?=Url::to(['/user/dashboard']);?>" class="home-link">Dashboard</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle profile-link"
                               data-toggle="dropdown"
                               href="#"><?php
                                $user = \app\models\User::findOne(Yii::$app->user->getId());
                                echo $user->name;
                                ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Url::to(['/user/tickets']);?>">My tickets</a></li>
                                <li><a href="<?=Url::to(['/user/profile']);?>">View my profile</a></li>
                                <li><a href="<?=Url::to(['/user/update']);?>">Update my profile</a></li>
                                <li><a href="<?=Url::to(['/user/settings']);?>">Update my settings</a></li>
                                <li><a href="/video/_Pizza_Cat_v5.swf" id="order-pizza">Order a pizza</a></li>
                                <li><a href="<?=Url::to(['/site/logout']);?>">Log out</a></li>
                            </ul>
                        </li>
                    </ul>
                    <?php
                }
                ?>
            </nav>
        </div>
    </header>
    <div class="page">
        <?= $content ?>
    </div>
    </div>
    <footer class="footer">
        <div class="footer__inner">
            <div class="copy">
                &copy;2015
            </div>
            <nav class="footer-nav">
                <ul>
                    <li class="footer-nav__item"><a href="<?=Url::to(['/site/page', 'id' => 'terms']);?>">Terms</a></li>
                    <li class="footer-nav__item"><a href="<?=Url::to(['/site/page', 'id' => 'privacy']);?>">Privacy</a></li>
                    <li class="footer-nav__item"><a href="<?=Url::to(['/site/page', 'id' => 'how-it-works']);?>">How it works</a></li>
                    <li class="footer-nav__item"><a href="<?=Url::to(['/site/page', 'id' => 'about']);?>">About</a></li>
                    <li class="footer-nav__item"><a href="<?=Url::to(['/site/page', 'id' => 'contact']);?>">Contact</a></li>
                </ul>
            </nav>
            <ul class="social">
                <li class="social__item social__item--fb"><a href="https://www.facebook.com/yummy.marshamello" rel="nofollow" target="_blank"></a></li>
                <li class="social__item social__item--tw"><a href="https://twitter.com/marshamello941" rel="nofollow" target="_blank"></a></li>
                <li class="social__item social__item--in"><a href="https://instagram.com/marshamello941" rel="nofollow" target="_blank"></a></li>
                <li class="social__item social__item--yt"><a href="https://www.youtube.com/user/941SocialClub" rel="nofollow" target="_blank"></a></li>
            </ul>
        </div>
    </footer>
    <div class="hidden">
        <div id="fake-form">
            <?php
            echo $this->render('/site/fake-form');
            ?>
        </div>
        <?php  if(Yii::$app->user->isGuest) {?>
        <div id="forgot-password">
            <?php
            echo $this->render('/site/_forgotPasswordForm');
            ?>
        </div>
        <div id="login">
            <?php
            echo $this->render('/site/_loginForm');
            ?>
        </div>

        <div id="join">
            <?php
            echo $this->render('/site/_joinForm');
            ?>
        </div>
        <?php }
        else {
            ?>
            <div id="login">
	            <div class="form__result">
                    Hi <?=$user->name;?>. You are already logged into the club
	            </div>
            </div>

            <div id="join">
	            <div class="form__result">
                    Hi <?=$user->name;?>. You are already a member of the club
	            </div>
            </div>

        <?php

        };?>

        <div id="secret">
            <div class="popup">
                <div class="form">
                    <div style="font-size: 16px;">941 Social Club is all about <br/>sharing the love, but some<br/>things are better kept secret</div>
                    <footer class="popup__footer">
                        <p>We don't share the names of who is<br/>viewing your profile or following you</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
<?php $this->endBody() ?>
<script>
    jQuery(document).ready(function ($) {
        $("#order-pizza").fancybox({
            // all your API options here, whatever they are
            fitToView: false,
            width: '90%',
            height: '90%',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none',
            helpers: {
                title: {
                    type: 'outside'
                }
            },
            type: "swf"
        }); // fancybox
    }); // ready
    $( ".fancybox-type-swf" ).delegate( ".fancybox-inner", "click", function() {
        window.location.href = '/parties';
        console.log('Fuck you');
    });

</script>
</body>
</html>
<?php $this->endPage() ?>
