<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB接続
include("functions.php");
$pdo = db_connect();

// POSTリクエストの場合は更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTデータ取得
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $order_pasta = $_POST["order_pasta"];
    $order_pizza = $_POST["order_pizza"];
    $order_curry = $_POST["order_curry"];
    $memo = $_POST["memo"];

    // データ更新SQL作成
    $sql = "UPDATE uniblog_gs_kadai08_db1_table1 SET name = :name, email = :email, order_pasta = :order_pasta, order_pizza = :order_pizza, order_curry = :order_curry, memo = :memo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':order_pasta', $order_pasta, PDO::PARAM_INT);
    $stmt->bindValue(':order_pizza', $order_pizza, PDO::PARAM_INT);
    $stmt->bindValue(':order_curry', $order_curry, PDO::PARAM_INT);
    $stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    // データ更新処理後
    if ($status == false) {
        sql_error($stmt);
    } else {
        redirect("index.php");
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // GETリクエストの場合はオーダー情報を取得
    $id = $_GET['id'];
    $sql = "SELECT * FROM uniblog_gs_kadai08_db1_table1 WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die('オーダーが見つかりません。');
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>オーダー編集</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>オーダー編集</h1>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">
        <div>
            <label>名前</label>
            <input type="text" name="name" value="<?= htmlspecialchars($order['name']) ?>" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($order['email']) ?>" required>
        </div>
        <div>
            <label>パスタ🍝600円</label>
            <input type="number" name="order_pasta" value="<?= htmlspecialchars($order['order_pasta']) ?>" min="0">
        </div>
        <div>
            <label>ピザ🍕700円</label>
            <input type="number" name="order_pizza" value="<?= htmlspecialchars($order['order_pizza']) ?>" min="0">
        </div>
        <div>
            <label>カレー🍛800円</label>
            <input type="number" name="order_curry" value="<?= htmlspecialchars($order['order_curry']) ?>" min="0">
        </div>
        <div>
            <label>備考</label>
            <textarea name="memo"><?= htmlspecialchars($order['memo']) ?></textarea>
        </div>
        <div class="button-group-2">
            <button type="submit">更新</button>
            <form action="index.php" method="get" style="display:inline;">
                <button type="submit">戻る</button>
            </form>
        </div>
    </form>
</body>
</html>

<?php
}
?>
