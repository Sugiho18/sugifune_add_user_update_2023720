<!-- アカウント編集画面 -->
<?php
require_once '../../bootstrap.php';
require_once ROOT_DIR . '/app/Controllers/UserController.php';

$ctrl = new UserController();
$data = $ctrl->confirm();
$form = [
    'name' => '',
    'email' => '',
    'password' => ''
];
?>

<!DOCTYPE html>
<html lang="jp">

<head>
    <?php include HTML_DIR . '/components/head.php' ?>

</head>

<body>
<nav>
    <?php include HTML_DIR . '/components/head.php' ?>
</nav>
    <main>
        <h1>アカウント情報</h1>
        <form action="" method="post" enctype="multipart/form-data"> 
        <!-- ?php if():? -->
        <!-- アカウント情報を更新しました -->
        <!-- ?php endif;? -->

        <dt>＊アカウント名</dt>
        <input type="text" name="name" size="100" maxlength="255" value="<?php echo h($form['name']) ?>"></p>
        <?php if (isset($error['name']) && $error['name'] === 'blank'): ?>
            必須項目です
        <?php endif; ?>


        <dt>＊メールアドレス</dt>

        <input type="text" name="email" size="100" maxlength="255" value="<?php echo h($form['name']) ?>"></p>
        <?php if (isset($error['email']) && $error['email'] === 'blank'): ?>
        必須項目です
        <?php endif; ?>

        正しく入力してください。

        <dt>＊パスワード</dt>
        <input type="password" name="password" size="100" maxlength="255" value="<?php echo h($form['name']) ?>"></p>
        <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
        必須項目です
        <?php endif; ?>

        8文字以上で入力してください。


        <button><a href="#">戻る</a></button>
        <button><a href="#">更新</a></button>

        <p><a href="#">アカウントを削除</a>しますか？</p>
    </main>
    </div>
</body>

</html>