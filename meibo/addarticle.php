<?php

//記事、内容の配列$articleにアーティクルタグを追加。
function add_article($article){
    $result = null;

    for($i=0;$i<Count($article);$i++)
    {
        if(isset($article[$i])){
        $result .= "<article>".$article[$i]."</article>";
        }
    }

    return $result;
}