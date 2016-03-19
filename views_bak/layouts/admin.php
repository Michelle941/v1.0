<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue">
<?php $this->beginBody() ?>

<!-- header logo: style can be found in header.less -->
<header class="header">
<a href="<?=Url::to('/admin/index');?>" class="logo">
    <!-- Add the class icon to your logo image or logo icon to add the margining -->
    941 Social Club
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
</a>
<div class="navbar-right">
<ul class="nav navbar-nav">
<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-warning"></i>
        <span class="label label-warning">2</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have 2 notifications</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <li>
                    <a href="#">
                        <i class="ion ion-ios7-people info"></i> 5 new members joined today
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                    </a>
                </li>
            </ul>
        </li>
        <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>

<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span><?=Yii::$app->session->get('user_name');?> <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="<?=Url::to('/admin/profile');?>" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="<?=Url::to('/admin/logout');?>" class="btn btn-default btn-flat">LogOut</a>
            </div>
        </li>
    </ul>
</li>
</ul>
</div>
</nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>Hello, <?=Yii::$app->session->get('user_name');?></p>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="active">
                    <a href="<?=Url::to('/admin/index');?>">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to('/admin/party');?>">
                        <i class="fa fa-glass"></i> <span>Party</span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to('/admin/orders');?>">
                        <i class="fa fa-shopping-cart"></i> <span>Orders</span>
                    </a>
                </li>
<!--                <li>-->
<!--                    <a href="index.html">-->
<!--                        <i class="fa fa-picture-o"></i> <span>Photos</span>-->
<!--                    </a>-->
<!--                </li>-->
                <li>
                    <a href="<?=Url::to('/admin/user');?>">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to('/admin/pages');?>">
                        <i class="fa fa-file"></i> <span>Content Pages</span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to('/admin/email');?>">
                        <i class="fa fa-envelope-o"></i> <span>Mail</span>
                    </a>
                </li>
                <li>
                    <a href="<?=Url::to('/admin/config');?>">
                        <i class="fa fa-cogs"></i> <span>Config</span>
                    </a>
                </li>
<!--                <li class="treeview">-->
<!--                    <a href="#">-->
<!--                        <i class="fa fa-key"></i>-->
<!--                        <span>Allow acsess</span>-->
<!--                        <i class="fa fa-angle-left pull-right"></i>-->
<!--                    </a>-->
<!--                    <ul class="treeview-menu">-->
<!--                        <li><a href="--><?//=Url::to('/permit/access/role');?><!--"><i class="fa fa-angle-double-right"></i>Role</a></li>-->
<!--                        <li><a href="--><?//=Url::to('/permit/access/permission');?><!--"><i class="fa fa-angle-double-right"></i>Rule</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?=$this->title;?>
            </h1>
            <ol class="breadcrumb">
                <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if(Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
