<?php
//DBを呼ぶ機能
function dbConnect()
{
    $db = new mysqli('localhost:3306', 'root', '', 'taskemon');
    if (!$db) {
        die($db->error);
    }
    return $db;
}
//PDOに接続する関数
function pdo()
{
    $db = 'mysql:host=localhost:3306; dbname=taskemon';
    $user = 'root';
    $password = '';
    try {
        $pdo = new PDO($db, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("接続エラー: " . $e->getMessage());
    }

    return $pdo;
}
//DBからアカウント情報取得
function getUserData($user_id){
$pdo = pdo();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
if (!$stmt) {
    die('接続エラー');
}
//登録するデータをセット
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$result = $stmt->execute();
if ($result) { //fetch();でデータ取り出し
    $data = $stmt->fetch();
}
$oldname=$data['name'];
$oldmail=$data['email'];
//DBの接続解除
$pdo = null;
return array($oldname,$oldmail);
}