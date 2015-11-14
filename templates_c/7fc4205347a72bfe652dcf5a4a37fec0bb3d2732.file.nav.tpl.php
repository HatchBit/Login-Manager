<?php /* Smarty version Smarty-3.1.8, created on 2015-11-14 19:50:59
         compiled from "/Users/yajima/Sites Data/localhost/login-manager/templates/manager/nav.tpl" */ ?>
<?php /*%%SmartyHeaderCode:45625229156477e2641f4e1-47507039%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fc4205347a72bfe652dcf5a4a37fec0bb3d2732' => 
    array (
      0 => '/Users/yajima/Sites Data/localhost/login-manager/templates/manager/nav.tpl',
      1 => 1447527056,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45625229156477e2641f4e1-47507039',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_56477e264269b8_00065145',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56477e264269b8_00065145')) {function content_56477e264269b8_00065145($_smarty_tpl) {?><header>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="top.php">ログイン管理</a>
            </div>
            <ul class="nav navbar-nav navbar-left">
                <li><a href="top.php">一覧 (top)</a></li>
                <li><a href="user-insert.php">追加</a></li>
            </ul>
            <form action="login.php" method="get" class="navbar-form navbar-right" role="form">
                <input type="hidden" name="logout" value="logout">
                <button type="submit" class="btn btn-danger">ログアウト</button>
            </form>
        </div>
    </nav>
</header>
<?php }} ?>