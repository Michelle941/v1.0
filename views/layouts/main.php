<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;

AppAsset::register($this);

$isMobile = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'Mobile');

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

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<link href="<?=Url::to(['css/styles/style.css']);?>" rel="stylesheet">
        <link rel="stylesheet" href="<?=Url::to(['css/fa/css/font-awesome.min.css']);?>">
        <!--[if lt IE 9]>
            <script src="js/html5shiv.min.js"></script>
            <script src="js/html5shiv-printshiv.min.js"></script>
        <![endif]-->

        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>

        <script type="text/javascript" src="<?=Url::to(['js/jquery-1.9.1.min.js']);?>"></script>

<?php
                $controller = Yii::$app->controller;
                $default_controller = Yii::$app->defaultRoute;
                $isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
		$user = \app\models\User::findOne(Yii::$app->user->getId());
?>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>

        .load-more, a.button, div.button, .form .button, .photos__actions a, .form .profile-update-photos__button{
            background: #3B3B3B;
        }
        .fancybox-type-swf{cursor: pointer;}
        #noti_Container {
            position:relative;
        }
        .noti_bubble {
            position: absolute;
            top: -15px;
            right: -15px;
            padding: 5px;
            background-color: red;
            color: white;
            font-weight: bold;
            font-size: 0.95em;
            border-radius: 15px;
            box-shadow: 1px 1px 1px gray;
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

<nav>

        <div class="margins-80">

                <div class="nav-image">

                        <a href="<?=Yii::$app->homeUrl;?>">
                                <img src="<?=Url::to(['images/nav-logo.png']);?>" alt="941 Social Club: Home" />
                        </a>

                </div><!-- nav image -->

                <div class="nav-tagline hidemobile">

                        <img src="<?=Url::to(['images/nav-tagline1.png']);?>" alt="Share Experiences. Share Photos." />

                </div><!-- nav tagline -->

                <div class="nav-link-cell">

                        <a href="<?=Url::to(['/site/parties']);?>">
                                <span>
                                        parties
                                </span>
                        </a>

                </div><!-- nav link cell -->

                <div class="nav-link-cell">

                        <a href="<?=Url::to(['/site/members'])?>">
                                <span>
                                        members
                                </span>
                        </a>

                </div><!-- nav link cell -->

                <div class="nav-link-cell">
                        <?php
                                if($user){
                        ?>
                        <?php
                                }
                                else{
                        ?>
                                        <a href="#join" class="fancybox" id="join-url">
                                        <span>
                                                JOIN
                                        </span>
                                        </a>
                        <?php
                                }
                        ?>
                </div><!-- nav link cell -->

                <div class="nav-link-cell-login">
                        <?php
                                if($user){
                        ?>
                        <nav class="nav nav--right">
                        <ul>
                        <li class="dropdown">
                            <a class="dropdown-toggle profile-link"
                               data-toggle="dropdown"
                               href="#"><?php
                                $user = \app\models\User::findOne(Yii::$app->user->getId());
                                echo $user->name;
				$user_id = $user->id;
                                ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Url::to(['/member/qt' . $user_id]);?>">View my profile</a></li>
                                <li><a href="<?=Url::to(['/user/update']);?>">Update my profile</a></li>
                                <li><a href="/site/pizza-cat" class="fancybox-ajax" id="order-pizza">Order a pizza</a></li>
                                <li><a href="<?=Url::to(['/site/logout']);?>">Log out</a></li>
                            </ul>
                        </li>
                        </ul>
                        </nav>
                        <?php
                                }
                                else{
                        ?>
                                        <a href="#login" class="fancybox" id="login-url">
                                        <button>
                                                login
                                        </button>
                                        </a>
                        <?php
                                }
                        ?>


                </div><!-- nav link cell -->



        </div><!-- margins: nav-->

        <div class="clearfix"></div>

</nav><!-- navigation: fixed -->


<body>

<?php $this->beginBody() ?>
    <div class="page">
        <?= $content ?>
    </div>
    </div>


<?php  if(Yii::$app->user->isGuest) {?>
<section id="call-to-action">

	<div class="margins-80">

		<button action="">

			join the club

		</button>

		<div class="clearfix"></div>

		Already a Club Member? <a href="">Log In</a>!

	</div><!-- margins: call to action -->

</section><!-- call to action section -->
<?php } ?>

 <div class="hidden" style="display:none; position: absolute; left: -9999px" >
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

        <div id="secret" style="display: none;">
            <div class="popup">
                <div class="form">
                    <div style="font-size: 16px; align: center;">941 Social Club is all about sharing the love,<br /> but some things are better kept secret</div>
                    <footer class="popup__footer" style="align: center; font-size:16px">
                        <p>We don't share the names of who is viewing <br /> your profile or following you</p>
                    </footer>
                </div>
            </div>
        </div>
    </div>


<footer>

	<div class="margins-60">

		<div class="footer-left">

			<a>
				<a href="/page/about">About Us</a>
			</a>
			<br />
			
			<a>
				<a href="/page/how-it-works">How it Works</a>
			</a>
			<br />

			<a>
				<a href="/page/contact">Contact</a>
			</a>
			
			<div style="height: 8px;"></div>

			<a href="/page/terms" class="smaller">
				Terms of Use
			</a>

			<br />

			<a href="/page/terms" class="smaller">
				Privacy Policy
			</a>

			<br />

			<span class="smaller">
				&copy;<?php echo date("Y") ?>
			</span>

		</div><!-- footer left -->

		<div class="footer-middle">

			<a href="http://www.youtube.com/941socialclub">
				<i class="fa fa-youtube"></i> /941socialclub 
			</a>
			<br />

			<a href="http://www.instagram.com/marshamello941">
				<i class="fa fa-instagram"></i> @marshamello941 
			</a>
			<br />

			<a href="http://www.facebook.com/yummy.marshamello">
				<i class="fa fa-facebook-official"></i> /yummy.marshamello
			</a>
			<br />

			<a href="http://www.facebook.com/941SocialClub">
				<i class="fa fa-facebook-official"></i> /941SocialClub 
			</a>
			<br />

			<a href="http://www.twitter.com/marshamello941">
				<i class="fa fa-twitter"></i> @marshamello941 
			</a>

		</div><!-- footer middle -->

		<div class="footer-right">

&nbsp;
		</div><!-- footer right -->

	</div><!-- margins: footer -->

	<div class="clearfix"></div>

</footer>

</body>

<div id="nav-scroll" class="hidemobile">

        <div class="margins-80">

                <div class="nav-image nav-image-scroll">

                        <a href="index.php">
                                <img src="<?=Url::to(['images/nav-logo-scroll.png']);?>" alt="941 Social Club: Home" />
                        </a>

                </div><!-- nav image -->

                <div class="nav-tagline nav-tagline-scroll">

                        <img src="<?=Url::to(['images/nav-tagline-scroll.png']);?>" />

                </div><!-- nav tagline -->

                <div class="nav-link-cell nav-link-cell-scroll">

                        <a href="<?=Url::to(['/site/parties']);?>">
                                <span>
                                        parties
                                </span>
                        </a>

                </div><!-- nav link cell -->

                <div class="nav-link-cell nav-link-cell-scroll">

                        <a href="<?=Url::to(['/site/members']);?>">
                                <span>
                                        members
                                </span>
                        </a>
                </div><!-- nav link cell -->

                <div class="nav-link-cell nav-link-cell-scroll">
			 <?php
                                if($user){
                        ?>
                        <?php
                                }
                                else{
                        ?>
                                        <a href="#join" class="fancybox" id="join-url">
                                        <span>
                                                JOIN
                                        </span>
                                        </a>
                        <?php
                                }
                        ?>
                </div><!-- nav link cell -->

                <div class="nav-link-cell-login nav-link-cell-login-scroll">
			 <?php
                                if($user){
                        ?>
                        <nav class="nav nav--right">
                        <ul>
                        <li class="dropdown">
                            <a class="dropdown-toggle profile-link"
                               data-toggle="dropdown"
                               href="#"><?php
                                $user = \app\models\User::findOne(Yii::$app->user->getId());
                                echo $user->name;
				$user_id = $user->id;
                                ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?=Url::to(['/member/qt' . $user_id]);?>">View my profile</a></li>
                                <li><a href="<?=Url::to(['/user/update']);?>">Update my profile</a></li>
                                <li><a href="/site/pizza-cat" class="fancybox-ajax" id="order-pizza">Order a pizza</a></li>
                                <li><a href="<?=Url::to(['/site/logout']);?>">Log out</a></li>
                            </ul>
                        </li>
                        </ul>
                        </nav>
                        <?php
                                }
                                else{
                        ?>
                                        <a href="#login" class="fancybox" id="login-url">
                                        <button>
                                                login
                                        </button>
                                        </a>
                        <?php
                                }
                        ?>

                </div><!-- nav link cell -->

        </div><!-- margins: nav-->

        <div class="clearfix"></div>

</div><!-- scrolling navigation -->

</body>

<script type="text/javascript">
$(window).scroll(function(){
 
if ($(this).scrollTop() > 400) {
$('#nav-scroll').fadeIn();
}
else {
$('#nav-scroll').fadeOut();
}
 
});
</script>

<!-- (c) 2015 941 Social Club
     Made in San Francisco <3
-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
