<!-- アカウント編集画面 -->
<?php
require('library.php'); //DBを呼ぶ
require_once '../../bootstrap.php';
require_once ROOT_DIR . '/app/Controllers/UserController.php';

$error = [];
//ユーザーIDの取得
$user_id = Auth::getUserId();
//DBからアカウント情報取得
list($oldname, $oldmail) = getUserData($user_id);
//保存完了表示のためのURL取得
$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL;
$get_url = parse_url($url);

if (isset($_SESSION['error']) && $get_url['path'] == '/user/usersetting.php') {
    $error = $_SESSION['error'];
    $form = $_SESSION['form'];
} else {
    //初期表示DBから持ってきたデータを格納
    $form = [
        'name' => $oldname,
        'email' => $oldmail,
        'password' => ''
    ];
}
$title = "アカウント編集";
?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <?php include HTML_DIR . '../components/head.php' ?>
</head>

<body class="text-body bg-light">
    <div class="d-flex">

        <?php include HTML_DIR . '../components/sidenav.php' ?>

        <div class="container p-3">
            <h2 class="fs-4 mb-4">
                <?= $title ?>
            </h2>

            <form id="user.update" action="check.php" method="POST" class="card-body">
                <br>
                <div class="card-text text-start mb-5">

                    <div id="message">
                    <?php if (empty($error) && $get_url['path'] == '/user/usersetting.php'): ?>
                        <input id="update" type="button" value="アカウント情報を更新しました ×" onclick="closeMessage()" />
                    <?php elseif (isset($error) && $get_url['path'] == '/user/usersetting.php'): ?>
                        <input id="error" type="button" value="アカウント情報の更新に失敗しました。 ×" onclick="closeMessage()" />
                    <?php endif; ?>
                    </div>
                    
                    <br>
                    <label for="name" class="form-label">
                        <span class="text-danger">*</span> アカウント名
                    </label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= $form['name'] ?>">
                    <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
                        <div class="text-danger">必須項目です</div>
                    <?php elseif (isset($error['name']) && $error['name'] === 'length'): ?>
                        <div class="text-danger">20文字以内で入力してください。</div>
                    <?php endif; ?>

                    <br>

                    <label for="email" class="form-label">
                        <span class="text-danger">*</span> メールアドレス
                    </label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $form['email'] ?>">
                    <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
                        <div class="text-danger">必須項目です</div>
                    <?php elseif (isset($error['email']) && $error['email'] === 'duplicate'): ?>
                        <div class="text-danger">既に登録されています</div>
                    <?php endif; ?>

                    <br>

                    <label for="password" class="form-label">
                        <span class="text-danger">*</span> パスワード
                    </label>
                    <input type="password" name="password" class="form-control" id="password">
                    <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
                        <div class="text-danger">必須項目です</div>
                    <?php elseif (isset($error['password']) && $error['password'] === 'length'): ?>
                        <div class="text-danger">8文字以上で入力してください。</div>
                    <?php endif; ?>
                </div>
                <br>
                <div class="w-100 mb-4">
                    <button type="button" onclick="location.href='../index.php'"
                        class="btn btn-outline-secondary">戻る</button>
                    <button type="submit" class="btn btn-outline-primary">更新</button>
                </div>
            </form>
            <div class="w-100 text-muted">
                <p><a href="#" class="card-link">アカウントを削除</a>しますか？</p>
            </div>

        </div>
        <?php include HTML_DIR . '../components/footer.php' ?>
</body>

</html>