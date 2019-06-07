<?php

if (isset($_POST["serch"])) {
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
    $stmt->execute();
    $data = $stmt->fetchALL();

    //表示用のテーブルの作成
    if (isset($data[0])) {
        require_once('maketable.php');
        $result = maketable_detail($data);
    } else {
        $err .= '検索結果がありませんでした。';
    }
}

?>

<!Doctype html>
<html>

<head>
    <?php include('head.php'); ?>
    <title>名簿更新</title>
</head>

<body>
    <main>
        <section>
            <article>
                <form method="post">
                    更新検索(名前)<br>
                    <input type="text" name="serch_name">
                    <input type="submit" name="serch" value="検索">
                </form>
            </article>
            <article>
                <?php
                //メッセージ表示
                if (isset($result)) {
                    echo $result;
                } else {
                    if (isset($err)) {
                        echo $err;
                    }
                }
                ?>
            </article>
            <section>
    </main>

    <?php include('footer.php'); ?>

</body>

</html>