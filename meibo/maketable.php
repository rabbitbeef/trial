<?php
//MSQLにてselect、fetchallで抽出した配列に対してテーブルを作成
function maketable($array)
{
    $result = '<table border = "1"><tr>';

    //thの作成
    $keys = array_keys($array[0]);
    foreach ($keys as $value) {
        $result .= '<th>' . $value . '</th>';
    }
    $result .= '</tr>';

    $result .= maketd($array);

    $result .= '</table>';

    return $result;
}

//tableの一行の作成。<tr><td>…</td></tr>出力。
function maketd($array)
{
    $result = null;
    //tdの作成
    foreach ($array as $value) {
        $result .= '<tr>';
        foreach ($value as $content) {
            $result .= '<td>' . $content . '</td>';
        }
        $result .= '</tr>';
    }

    return $result;
}

//詳細付きのテーブル作成
//$arrayは検索結果の配列。
//2人ならば$arrayに[0]=>[name:"aaa"   adress:"aa"  mail:"aa"] [1]=>[name:"aaa"   adress:"aa"  mail:"aa"]
//となる。
function maketable_detail($array)
{
    $add = '詳細';

    $result = '<table border = "1"><tr>';

    //thの作成
    $keys = array_keys($array[0]);
    foreach ($keys as $value) {
        $result .= '<th>' . $value . '</th>';
    }
    $result .= '<th>' . $add . '</th>';
    $result .= '</tr>';

    //以下trの作成
    //foreach内部で検索結果の数を記録し、番号付けする。
    $i=0;
    foreach ($array as $value) {
        //tdの中身
        $addtd = null;
        
        
        $result .= '<tr>';

        //テーブルの中身の作成
        foreach ($value as $content) {
            $result .= '<td>' . $content . '</td>';
        }

        //hiddenとしてname等のデータを詳細画面にポストするためのtdを追加。
        //$iを付与して番号を識別
        foreach ($value as $key => $value) {
            $addtd .= '<input type="hidden" name = '.$key.$i. ' value = ' . $value . '>';
        }

        //リンクにpostを埋め込む。valueに$iを使用して番号を識別
        //classのdetail_submitをjq.jsのjqueryでajax通信させる。
        $addtd .= '<a name="detail_submit" value=' . $i . '>' . $add . '</a>';
        $result .= '<td>' . $addtd . '</td>';
        $result .= '</tr>';
    }


    $result .= '</table>';

    return $result;
}
