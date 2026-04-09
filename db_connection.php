<?php
// db_connection.php

$host = '127.0.0.1'; // DBnginで動いているMySQLの住所 reservationのタブの上のところをクリックすると出てくる
$dbname = 'yoyaku_db'; // さっきTablePlusで作った器の名前
$user = 'root';        // DBnginのデフォルトユーザー
$pass = '';            // DBnginのデフォルトパスワード（空でOK）

try {
    // データベースに接続する（PDO）
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    
    // エラーがあった時に分かりやすく教えてくれる設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    

    
} catch (PDOException $e) {
    // 接続失敗した時に原因を表示する
    die("接続に失敗したよ...: " . $e->getMessage());
}