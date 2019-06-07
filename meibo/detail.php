<?php
if (isset($_POST["detail"]) || isset($_POST["update"])) {

    $err = null;
    $result = null;

    $name = $_POST["name"];
    $address = $_POST["address"];
    $mail = $_POST["mail"];

    //更新処理
    if (isset($_POST["update"])) {

        $upname = $_POST["update_name"];
        $upaddress = $_POST["update_address"];
        $upmail = $_POST["update_mail"];

        //データベース接続
        require_once('dbconnect.php');

        //名前から検索。代入
        $stmt = $pdo->prepare('UPDATE meibo SET name = :upname, address = :upaddress , mail = :upmail WHERE name = :name AND address = :address AND mail = :mail');
        $stmt->bindValue(':upname', $upname, PDO::PARAM_STR);
        $stmt->bindValue(':upaddress', $upaddress, PDO::PARAM_STR);
        $stmt->bindValue(':upmail', $upmail, PDO::PARAM_STR);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':address', $address, PDO::PARAM_STR);
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);

        //実行処理
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }

        //メッセージ代入
        if ($name !== $upname) {
            $result .= "名前:" . $name . "⇒" . $upname . "<br>";
        }
        if ($address !== $upaddress) {
            $result .= "住所:" . $address . "⇒" . $upaddress . "<br>";
        }
        if ($mail !== $upmail) {
            $result .= "メール:" . $mail . "⇒" . $upmail . "<br>";
        }
        if (empty($result)) {
            $result .= '更新データがありません。<br>';
        } else {
            $result .= '更新しました。<br>';
        }

        $name = $upname;
        $address = $upaddress;
        $mail = $upmail;
    }

    //テーブル作成
    //$result .= "<table border=1><tr><th>name</th><th>adress</th><th>mail</th></tr><tr><td>" . $name . "</td><td>" . $address . "</td><td>" . $mail . "</td></tr></table>";
} else {
    exit("エラーです。");
}

$title = 'detail';
$article[0]=  $result;

$article[1]='
名前<br>
<input type="text" name="update_name" value='.$name.'><br>
住所<br>
<input type="text" name="update_address" value='.$address.'><br>
メール<br>
<input type="text" name="update_mail" value='.$mail.'><br>
<input type="hidden" name="name" value='.$name.'>
<input type="hidden" name="address" value='.$address.'>
<input type="hidden" name="mail" value='.$mail.'>
<input type="submit" name="update" value="更新">
';


$article[2]='
<input type="hidden" name="name" value='.$name.'>
<input type="hidden" name="address" value='.$address.'>
<input type="hidden" name="mail" value='.$mail.'>
<input type="submit" name="delete" value="削除">
';


require('addarticle.php');
$content = add_article($article);

echo($content);