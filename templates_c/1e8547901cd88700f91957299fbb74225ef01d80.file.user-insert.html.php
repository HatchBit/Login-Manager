<?php /* Smarty version Smarty-3.1.8, created on 2015-11-14 19:38:28
         compiled from "/Users/yajima/Sites Data/localhost/login-manager/templates/manager/user-insert.html" */ ?>
<?php /*%%SmartyHeaderCode:157645053856477f816410e5-84583467%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1e8547901cd88700f91957299fbb74225ef01d80' => 
    array (
      0 => '/Users/yajima/Sites Data/localhost/login-manager/templates/manager/user-insert.html',
      1 => 1447526305,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157645053856477f816410e5-84583467',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_56477f816a5389_00050682',
  'variables' => 
  array (
    'msg' => 0,
    'm' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56477f816a5389_00050682')) {function content_56477f816a5389_00050682($_smarty_tpl) {?><!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Login</title>
<!-- Bootstrap -->
<link href="../assets/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
<?php echo $_smarty_tpl->getSubTemplate ('manager/nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('pagetitle'=>'ユーザ登録'), 0);?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <?php if (count($_smarty_tpl->tpl_vars['msg']->value)>0){?>
            <?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['m']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
$_smarty_tpl->tpl_vars['m']->_loop = true;
?>
            <div class="alert alert-<?php echo $_smarty_tpl->tpl_vars['m']->value['style'];?>
" role="alert"><?php echo $_smarty_tpl->tpl_vars['m']->value['value'];?>
</div>
            <?php } ?>
            <?php }?>
            <form method="post" action="user-insert.php" class="form">
                <div class="form-group">
                    <label for="username" class="control-label">ユーザー名</label>
                    <input type="text" name="username" id="username" value="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">パスワード</label>
                    <input type="password" name="password" id="password" value="" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="status" class="control-label">状態</label>
                    <select name="status" class="form-control">
                        <option value="0">停止</option>
                        <option value="1" selected>通常</option>
                        <option value="9">管理</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="mode" value="insert" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../assets/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html><?php }} ?>