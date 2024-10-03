<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// POSTデータ取得
$id = $_POST["id"];

// DB接続
include("functions.php");
$pdo = db_connect();

// データ削除SQL作成
$sql = "DELETE FROM uniblog_gs_kadai08_db1_table1 WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ削除処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("index.php");
}
?>
