<?php /* Smarty version Smarty-3.1.8, created on 2015-11-14 16:31:13
         compiled from "/Users/yajima/Sites Data/localhost/login-manager/templates/manager/login.html" */ ?>
<?php /*%%SmartyHeaderCode:1766520579564753c1a57227-68350957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0a5c71293b1e5b5ca269dc70b1ceb02a0afbbf1' => 
    array (
      0 => '/Users/yajima/Sites Data/localhost/login-manager/templates/manager/login.html',
      1 => 1447514075,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1766520579564753c1a57227-68350957',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_564753c1aa1b35_07904097',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_564753c1aa1b35_07904097')) {function content_564753c1aa1b35_07904097($_smarty_tpl) {?><!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Login</title>
<!-- Bootstrap -->
<link href="../assets/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="text-center">
            <h1>ログインしてください</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?php if (isset($_smarty_tpl->tpl_vars['msg']->value)){?>
            <p class="text-danger"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</p>
            <?php }?>
            <div class="jumbotron">
                <form action="login.php" method="post" class="form" role="form">
                    <div class="form-group">
                        <label for="username" class="control-label">管理ユーザー名</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="ユーザ名" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">管理パスワード</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="パスワード" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="mode" value="login" class="btn btn-primary">管理ログイン</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../assets/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html><?php }} ?>