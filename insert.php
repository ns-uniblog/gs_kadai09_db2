<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// POSTデータ取得
$date = date("Y-m-d H:i:s");
$name = $_POST["name"];
$email = $_POST["email"];
$order_pasta = $_POST["order_pasta"];
$order_pizza = $_POST["order_pizza"];
$order_curry = $_POST["order_curry"];
$memo = $_POST["memo"];

// DB接続
include("functions.php"); //外部ファイルを読み込む
$pdo= db_connect();

// データ登録SQL作成
$sql = "INSERT INTO uniblog_gs_kadai08_db1_table1(date, name, email, order_pasta, order_pizza, order_curry, memo) VALUES(:date, :name, :email, :order_pasta, :order_pizza, :order_curry, :memo)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':date', $date, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':order_pasta', $order_pasta, PDO::PARAM_INT);
$stmt->bindValue(':order_pizza', $order_pizza, PDO::PARAM_INT);
$stmt->bindValue(':order_curry', $order_curry, PDO::PARAM_INT);
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if($status == false) {
    sql_error($stmt);
} else {
    redirect("index.php");
}
?>
