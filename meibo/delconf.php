<?php

$result = "URLから直接飛ばないで下さい。";

//確認後、それでも削除するとき
if (isset($_POST["conf"])) {

    $name = $_POST["name"];
    $address = $_POST["address"];
    $mail = $_POST["mail"];

    //データベース接続
    require_once('dbconnect.php');

    //削除実行
    $stmt = $pdo->prepare('DELETE FROM meibo WHERE name = :name AND address = :address AND mail = :mail');
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':address', $address, PDO::PARAM_STR);
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    $result = "削除しました。";
}

//確認
if (isset($_POST["delete"])) {
    $result = '本当に消しますか？<br>
               <input type="hidden" name="name" value=' . $_POST["name"] . '>
               <input type="hidden" name="address" value=' . $_POST["address"] . '>
               <input type="hidden" name="mail" value=' . $_POST["mail"] . '>
               <input type="submit" name="conf" value = "削除">
               <input type="submit" name="back" value = "中止">
               ';
}


$title = 'index';
$article[0]= $result;
require('addarticle.php');
$content = add_article($article);

echo($content);