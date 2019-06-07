<?php
if (isset($_POST["serch_name"])) {

    //エスケープ処理をしていないの注意
    $postname = $_POST["serch_name"];

    //変数宣言　エラーと検索結果
    $err = null;
    $result = null;

    //データベース接続
    require_once('dbconnect.php');

    //名前から検索。代入
    $stmt = $pdo->prepare('SELECT name, address, mail From meibo WHERE name = :name');
    $stmt->bindValue(':name', $postname);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        exit($e->getMessage());
    }

    $data = $stmt->fetchALL();

    //表示用のテーブルの作成
    if (isset($data[0])) {
        require_once('maketable.php');

        $result = maketable($data);
    } else {
        $err .= '検索結果がありませんでした。';
    }
}

$msg=null;
if (isset($result)) {
    $msg = $result;
} else {
    if (isset($err)) {
        $msg = $err;
    }
}

$article[1]= $msg;

$article[0]='
名前検索<br>
<input type="text" name="serch_name" class="test">
<input type="submit" name="serch" value="検索">
';

require('addarticle.php');
$content = add_article($article);

echo($content);