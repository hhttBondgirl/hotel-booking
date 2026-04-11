<?php

// Railwayの環境変数があるかチェック、なければローカルの設定を使う
// MYSQLHOST が取れない場合は、MYSQL_HOST や RAILWAY_PRIVATE_DOMAIN も探す設定
$host = getenv('MYSQLHOST') ?: (getenv('RAILWAY_PRIVATE_DOMAIN') ?: '127.0.0.1');
$dbname = getenv('MYSQLDATABASE') ?: 'yoyaku_db';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';
$port = getenv('MYSQLPORT') ?: '3306';

try {
    // データベースに接続する（PDO）
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    
    // エラー設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // --- 【ここから追加】テーブルがなかったら自動で作る魔法 ---
    $table_sql = "CREATE TABLE IF NOT EXISTS reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        checkin DATE NOT NULL,
        checkout DATE NOT NULL,
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    
    $pdo->exec($table_sql);
    // ---------------------------------------------------
    
} catch (PDOException $e) {
    die("接続に失敗しました: " . $e->getMessage());
}