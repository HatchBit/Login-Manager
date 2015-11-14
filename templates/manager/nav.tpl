<header>
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
