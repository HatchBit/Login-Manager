<?php /* Smarty version Smarty-3.1.8, created on 2015-11-14 19:34:48
         compiled from "/Users/yajima/Sites Data/localhost/login-manager/templates/manager/top.html" */ ?>
<?php /*%%SmartyHeaderCode:10486768985647547d531bc8-07791183%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12bfafb022d4c49b5c10f9cd3202c57efcfbf6e4' => 
    array (
      0 => '/Users/yajima/Sites Data/localhost/login-manager/templates/manager/top.html',
      1 => 1447526073,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10486768985647547d531bc8-07791183',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5647547d5ae9b9_83751056',
  'variables' => 
  array (
    'users' => 0,
    'u' => 0,
    'pages' => 0,
    'p' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5647547d5ae9b9_83751056')) {function content_5647547d5ae9b9_83751056($_smarty_tpl) {?><!doctype html>
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
<?php echo $_smarty_tpl->getSubTemplate ('manager/nav.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('pagetitle'=>'管理トップ'), 0);?>

    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ユーザ名</th>
                        <th>状態</th>
                        <th>最終更新</th>
                        <th>更新</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $_smarty_tpl->tpl_vars['u'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['u']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['users']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['u']->key => $_smarty_tpl->tpl_vars['u']->value){
$_smarty_tpl->tpl_vars['u']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['u']->value['username'];?>
</td>
                        <td><span class="statuscolor-<?php echo $_smarty_tpl->tpl_vars['u']->value['status'];?>
"><?php echo $_smarty_tpl->tpl_vars['u']->value['statusstr'];?>
</span></td>
                        <td><?php echo $_smarty_tpl->tpl_vars['u']->value['modified'];?>
</td>
                        <td><a href="user-update.php?user_id=<?php echo $_smarty_tpl->tpl_vars['u']->value['id'];?>
" class="btn btn-warning">更新</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if (count($_smarty_tpl->tpl_vars['pages']->value)>0){?>
        <div class="col-sm-12">
            <nav>
                <ul class="pagination">
                    <?php  $_smarty_tpl->tpl_vars['p'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['p']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['pages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['p']->key => $_smarty_tpl->tpl_vars['p']->value){
$_smarty_tpl->tpl_vars['p']->_loop = true;
?>
                    <?php if ($_smarty_tpl->tpl_vars['p']->value['type']=='prev'){?>
                    <li><a href="top.php?p=<?php echo $_smarty_tpl->tpl_vars['p']->value['pagenum'];?>
" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                    <?php }elseif($_smarty_tpl->tpl_vars['p']->value['type']=='next'){?>
                    <li><a href="top.php?p=<?php echo $_smarty_tpl->tpl_vars['p']->value['pagenum'];?>
" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                    <?php }elseif($_smarty_tpl->tpl_vars['p']->value['type']=='current'){?>
                    <li class="active"><a href="top.php?p=<?php echo $_smarty_tpl->tpl_vars['p']->value['pagenum'];?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value['pagenum'];?>
</a></li>
                    <?php }else{ ?>
                    <li><a href="top.php?p=<?php echo $_smarty_tpl->tpl_vars['p']->value['pagenum'];?>
"><?php echo $_smarty_tpl->tpl_vars['p']->value['pagenum'];?>
</a></li>
                    <?php }?>
                    <?php } ?>
                </ul>
            </nav>
        </div>
        <?php }?>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../assets/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
</body>
</html><?php }} ?>