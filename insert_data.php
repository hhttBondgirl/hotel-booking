<?php
$host = '127.0.0.1';
$db   = 'yoyaku_db';
$user = 'root';
$pass = ''; // パスワード設定してなければ空
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
try {
    $pdo = new PDO($dsn, $user, $pass);

    // 1. 命令の「形」を準備（これはループの外で1回だけ！）
    $sql = "INSERT INTO reservations (name, email, checkin, checkout, message) 
            VALUES (:name, :email, :checkin, :checkout, :message)";
    $stmt = $pdo->prepare($sql);

    // 1件追加したい時#13
    //  $stmt->execute([
    //     ':name' => 'バニラ 太郎',
    //     ':email' => 'vanilla@example.com',
    //     ':checkin' => '2026-04-09',
    //     ':checkout' => '2026-04-09',
    //     ':message' => 'PHPファイルから送ったよ！'
    // ]);

    // 2. ここからループで「中身」を入れ替えながら実行！
    for ($i = 1; $i <= 10; $i++) {
        $stmt->execute([
            ':name'     => "テストユーザー{$i}",
            ':email'    => "test{$i}@example.com",
            ':checkin'  => '2026-04-09',
            ':checkout' => '2026-04-09',
            ':message'  => "ループの{$i}回目だよ"
        ]);
    }

    echo "一気に10人追加されたよ！TablePlusを見てみて！";

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
}