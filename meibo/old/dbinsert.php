<?php

if (isset($_POST["signup"])) {
    //変数宣言　エラーと実行結果
    $err = null;
    $result = null;

    //入力チェック
    if (empty($_POST["signup_name"])) {
        $err .= "名前が入力されていません。<br>";
    }

    if (empty($_POST["signup_address"])) {
        $err .= "住所が入力されていません。<br>";
    }

    if (empty($_POST["signup_mail"])) {
        $err .= "メールが入力されていません。<br>";
    }

    //入力チェックでエラーが発生してない場合に処理を開始
    if ($err === null) {
        //エスケープ処理をしていないの注意
        $name = $_POST["signup_name"];
        $address = $_POST["signup_address"];
        $mail = $_POST["signup_mail"];

        //データベース接続
        require_once('dbconnect.php');

        //名前から検索。代入
        $stmt = $pdo->prepare('INSERT INTO meibo(name,address,mail) VALUES(:name,:address,:mail)');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);

        //実行処理
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        $result .= '追加しました。';
    }
}

$msg[0]='
<div>
<form method="post">
    名前<br><input type="text" name="signup_name"><br>
    住所<br><input type="text" name="signup_address"><br>
    メール<br><input type="text" name="signup_mail"><br>
    <input type="submit" name="signup" value="登録">
</form>
</div>';

$msg[1] = null;
if (isset($result)) {
    $msg = $result;
} else {
    if (isset($err)) {
        $msg = $err;
    }
}

?>

<!Doctype html>
<html>

<head>
    <?php include('head.php'); ?>
    <title>名簿登録</title>
</head>

<body>
    <main>
        <section class="main_content">
            <article>
                <?=$msg[0]?>
            </article>
            <article>
                <?=$msg[1] ?>
            </article>
        </section>
    </main>
    <?php include('footer.php'); ?>

</body>

</html>