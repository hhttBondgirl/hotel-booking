
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. まずはPOSTでデータが届いているかチェック
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $checkin  = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $message  = $_POST['message'];

   // 2. 日付オブジェクトに変換して比較する
   $todayObj = new DateTime('today'); // 今日の00:00:00
   $checkinObj = new DateTime($checkin); // 届いたチェックイン日

   if ($checkinObj < $todayObj) {
       echo "申し訳ございません。過去の日付は選べませんので、もう一度選び直してください。";
       echo '<br><a href="index.php">戻る</a>';
       exit;
   }

} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>予約内容の確認</title>
</head>
<body>
    <h1>予約内容の確認</h1>
    <p>以下の内容でよろしければ「予約を確定する」を押してください。</p>

    <ul>
        <li><strong>お名前：</strong> <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></li>
        <li><strong>メールアドレス：</strong> <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></li>
        <li><strong>チェックイン：</strong> <?php echo htmlspecialchars($checkin, ENT_QUOTES, 'UTF-8'); ?></li>
        <li><strong>チェックアウト：</strong> <?php echo htmlspecialchars($checkout, ENT_QUOTES, 'UTF-8'); ?></li>
        <li><strong>備考：</strong><br><?php echo nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')); ?></li>
    </ul>

    <button type="button" onclick="history.back()">修正する</button>

    <form action="complete.php" method="post">
        <input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="checkin" value="<?php echo htmlspecialchars($checkin, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="checkout" value="<?php echo htmlspecialchars($checkout, ENT_QUOTES, 'UTF-8'); ?>">
        <input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
        
        <button type="submit">予約を確定する</button>
    </form>
</body>
</html>