<?php

// 1. データベース接続の「鍵」を読み込む
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 2. 確認画面から送られてきたデータを受け取る
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $checkin  = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $message  = $_POST['message'];

    try {
        // 3. 貯金箱にデータを入れるためのSQL（命令書）を準備する
        // Laravelの Eloquent(save()) が裏でやってくれていたことだよ！
        $sql = "INSERT INTO reservations (name, email, checkin, checkout, message) 
                VALUES (:name, :email, :checkin, :checkout, :message)";
        
        $stmt = $pdo->prepare($sql);

        // 4. 命令書の「虫食い部分（:nameなど）」に実際のデータを当てはめる
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':checkin', $checkin, PDO::PARAM_STR);
        $stmt->bindValue(':checkout', $checkout, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);

        // 5. 実行！
        $stmt->execute();

        $success = true;
    } catch (PDOException $e) {
        $success = false;
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約完了</title>
</head>
<body>
    <?php if ($success): ?>
        <h1>予約が完了しました！</h1>
        <p>ご予約ありがとうございます。</p>
        <a href="index.php">入力画面に戻る</a>
        
        <?php else: ?>
        <h1>エラーが発生しました</h1>
        <p>残念ながら予約に失敗いたしました。理由：<?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="index.php">もう一度やり直す</a>
    <?php endif; ?>
</body>
</html>