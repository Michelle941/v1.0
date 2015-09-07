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
    <meta name="viewport" content="width=1280">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .load-more, a.button, div.button, .form .button, .photos__actions a, .form .profile-update-photos__button{
            background: #3B3B3B;
        }
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
                                <li><a href="#">Order a pizza</a></li>
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
                    <li class="footer-nav__item"><a href="<?=Url::to(['/site/contact', 'id' => 'about']);?>">Contact</a></li>
                </ul>
            </nav>
            <ul class="social">
                <li class="social__item social__item--fb"><a href="#" rel="nofollow" target="_blank"></a></li>
                <li class="social__item social__item--tw"><a href="#" rel="nofollow" target="_blank"></a></li>
                <li class="social__item social__item--in"><a href="#" rel="nofollow" target="_blank"></a></li>
                <li class="social__item social__item--yt"><a href="#" rel="nofollow" target="_blank"></a></li>
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
</body>
</html>
<?php $this->endPage() ?>
