<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Derby Contact</title>

    <!-- Bootstrap core CSS -->
    <?php echo $this->Html->css('bootstrap'); ?>

    <!-- Custom styles for this template -->
    <?php echo $this->Html->css('style'); ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script('html5shiv'); ?>
    <?php echo $this->Html->script('respond.min'); ?>
    <![endif]-->

    <?php echo $this->Html->script('jquery'); ?>
</head>

<body>

<div class="ribbon">
    <a href="#">Beta</a>
</div>

<div class="navbar navbar-default navbar-staic-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">The Little Black Book of Derby</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><?php echo $this->Html->link('Home', '/'); ?></li>
                <li><?php echo $this->Html->link('Contacts', array('controller' => 'contacts', 'action' => 'index')); ?></li>
            </ul>
            <div class="navbar-form navbar-right">
                <?php if ($user): ?>
                    <a href="<?php echo $this->Html->url(array('controller' => 'contacts', 'action' => 'edit')); ?>" class="btn btn-success">
                    <?php echo $user['name']; ?>
                    <?php if (!empty($user['derby_name'])): ?>
                        (<?php echo $user['derby_name']; ?>)
                    <?php endif; ?>
                        </a>
                    <?php echo $this->Html->link('Logout', array('controller' => 'contacts', 'action' => 'logout'), array('class' => 'btn btn-danger')); ?>
                <?php else: ?>
                    <?php echo $this->Html->link('Login', $fb_login_url); ?>
                <?php endif; ?>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</div>

<?php echo $content_for_layout; ?>

    <?php echo $this->element('sql_dump'); ?>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<?php echo $this->Html->script('bootstrap'); ?>
</body>
</html>
