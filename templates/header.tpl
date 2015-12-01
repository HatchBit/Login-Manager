<header>
    <div class="row">
        <div class="col-xs-12">
            <h1>トップ</h1>
        </div>
        <div class="col-xs-9">
            <ul class="nav nav-pills">
                <li role="presentation" class="active"><a href="/login-manager/top.php" class="btn">トップ</a></li>
                <li role="presentation"><a href="/check-insertion-word/" class="btn">近接共起語チェック</a></li>
                {if isset($smarty.session.managerlogin) and $smarty.session.managerlogin eq '1'}
                <li role="presentation"><a href="/index-check-by-aol/" class="btn">AOLインデックスチェックツール</a></li>
                {/if}
            </ul>
        </div>
        <div class="col-xs-3 text-right">
            <ul class="nav nav-pills">
                {if isset($smarty.session.managerlogin) and $smarty.session.managerlogin eq '1'}
                <li role="presentation"><a href="/login-manager/manager/top.php">ユーザー管理</a></li>
                <li role="presentation"><a href="/login-manager/manager/login.php?logout=logout" class="btn btn-danger">ログアウト</a></li>
                {else}
                <li role="presentation"><a href="/login-manager/login.php?logout=logout" class="btn btn-danger">ログアウト</a></li>
                {/if}
            </ul>
        </div>
    </div>
</header>
