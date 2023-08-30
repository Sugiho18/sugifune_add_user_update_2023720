<!-- アカウント更新情報保存 -->
<?php
require('library.php'); //DBを呼ぶ
require_once '../../bootstrap.php';
require_once ROOT_DIR . '/app/Controllers/UserController.php';

//ユーザーIDの取得
$user_id = Auth::getUserId();
//フォームからのデータがあるか確認 無ければ不正アクセスと見なしダッシュボードへ
if (isset($_POST)) {
    $form = $_POST;
} else {
    header('Location: index.php');
    exit();
}
//フォーム確認用　前のメールアドレス取得
list($oldname, $oldmail) = getUserData($user_id);
// フォームの内容をチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    if ($form['name'] === '') {
        $error['name'] = 'blank';
    } else if (mb_strlen($form['name']) > 20) {
        $error['name'] = 'length';
    }
    $form['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if ($form['email'] === '') {
        $error['email'] = 'blank';
    } else {
        $pdo = pdo();
        $stmt = $pdo->prepare('select * from users where email=:email');
        $stmt->bindValue('email', $form['email'], PDO::PARAM_STR);
        $stmt->execute();
        $cnt = $stmt->rowCount();

        if (isset($cnt) && $cnt > 0 && $form['email'] !== $oldmail) {
            $error['email'] = 'duplicate';
        }
    }

    $form['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if ($form['password'] === '') {
        $error['password'] = 'blank';
    } else if (strlen($form['password']) < 8) {
        $error['password'] = 'length';
    }

    //エラーが無ければ受け取ったデータとIDを元にユーザーデータをアップデート
    if (empty($error)) {
        //日付の取得
        $now = new DateTime();
        $date = $now->format('Y-m-d H:i:s');
        //パスワードを暗号化
        $hashPassword = password_hash($form['password'], PASSWORD_DEFAULT);
        //PDO接続
        $pdo = pdo();
        $stmt = $pdo->prepare("UPDATE users SET name =:name ,email=:email , updated_at=:updated_at ,password=:password WHERE id= :id ");
        $stmt->bindParam('name', $form['name'], PDO::PARAM_STR);
        $stmt->bindParam('email', $form['email'], PDO::PARAM_STR);
        $stmt->bindParam('password', $hashPassword, PDO::PARAM_STR);
        $stmt->bindParam('updated_at', $date, PDO::PARAM_STR);
        $stmt->bindParam('id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        unset($_SESSION['error']);
        header('Location: usersetting.php');
        exit();
    } else {
        $_SESSION['form'] = $form;
        $_SESSION['error'] = $error;
        header('Location: usersetting.php');
        exit();
    }

}