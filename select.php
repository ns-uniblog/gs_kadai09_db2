<?php
function selectOrders() {
// DB接続
include("functions.php"); //外部ファイルを読み込む
$pdo= db_connect();

    $sql = "SELECT * FROM uniblog_gs_kadai08_db1_table1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // 連想配列として返す
}
?>
