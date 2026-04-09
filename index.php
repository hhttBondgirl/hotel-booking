<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>宿泊予約フォーム</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body">
    <main>
        <h1>宿泊予約フォーム</h1>

        <form action="confirm.php" method="post">
            <div class="form-one">
                <label for="name">お名前：</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-one">
                <label for="email">メールアドレス：</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="time-container">
            <div class="date-picker-group">
                <label for="checkin">チェックイン：</label>
                <input type="date" name="checkin" id="checkin" required readonly inputmode="none" autocomplete="off">
                <div class="calendar-host" data-target="checkin">
                    <table class="calendar-table">
                        <thead>
                            <tr>
                                <th class="cal-prev" aria-label="前の月">&laquo;</th>
                                <th class="cal-title" colspan="5"></th>
                                <th class="cal-next" aria-label="次の月">&raquo;</th>
                            </tr>
                            <tr>
                                <th>日</th>
                                <th>月</th>
                                <th>火</th>
                                <th>水</th>
                                <th>木</th>
                                <th>金</th>
                                <th>土</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="date-picker-group">
                <label for="checkout">チェックアウト：</label>
                <input type="date" name="checkout" id="checkout" required readonly inputmode="none" autocomplete="off">
                <div class="calendar-host" data-target="checkout">
                    <table class="calendar-table">
                        <thead>
                            <tr>
                                <th class="cal-prev" aria-label="前の月">&laquo;</th>
                                <th class="cal-title" colspan="5"></th>
                                <th class="cal-next" aria-label="次の月">&raquo;</th>
                            </tr>
                            <tr>
                                <th>日</th>
                                <th>月</th>
                                <th>火</th>
                                <th>水</th>
                                <th>木</th>
                                <th>金</th>
                                <th>土</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            </div>

            <div>
                <label for="message" class="message-label">備考：</label>
                <textarea name="message" id="message" rows="4"></textarea>
            </div>

            <button type="submit" class="submit-button">確認画面へ</button>
        </form>
    </main>

    <script src="main.js"></script>
</body>

</html>