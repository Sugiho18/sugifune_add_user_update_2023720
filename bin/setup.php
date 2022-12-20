<?php

/**
 * データベース構築処理
 * 
 * sqlフォルダ内のSQLをすべて実行する。
 * 
 * @since 1.0.0
 */
require_once  dirname(__DIR__) . '/bootstrap.php';
require_once  ROOT_DIR . '/app/Models/DB.php';

// SQLファイル格納フォルダ
define('SQL_DIR', ROOT_DIR . '/sql');

try {
    DB::begin();
    foreach (scandir(SQL_DIR) as $filename) {
        $fullpath = SQL_DIR . '/' . $filename;
        if (is_file($fullpath)) {
            $sql = file_get_contents($fullpath);
            DB::execute($sql);
            echo 'success: ' . $filename . PHP_EOL;
        }
    }
    DB::commit();
} catch (Exception $e) {
    DB::rollback();
    echo 'error: ' . $filename . PHP_EOL;
    echo $e->getMessage();
}
