let url = null;

$(document).ready(() => {
    //sectionを隠す
    $(".sec_hide").ready().fadeIn(500);
    fade_title(2000);

    //最初にtopを読み込む
    $("section").load("title.php");

    //マウスオーバーでポインタ変更
    $(document).on({
        "mouseenter": function () { $(this).css("cursor", "pointer") },
        "mouseleave": function () { $(this).css("cursor", "default") },
    }, "a");

    //リンクがクリックされたらvalue取得。valueをload。
    $(".foot_link").click(function () {
        let val = $(this).attr("value");
        url = val;
        load_section(val);
    });

    //検索時の画面遷移
    $("section").on("click", "input[name='serch']", () => {
        let val = $('input[name="serch_name"]').val();
        let json = {
            "serch_name": val
        };
        load_section_data(url, json);
    });

    //signup時の画面遷移。
    //keyの名前を全部書かねばならないのが良くない。
    $("section").on("click", "input[name='signup']", () => {
        let name = $('input[name="signup_name"]').val();
        let address = $('input[name="signup_address"]').val();
        let mail = $('input[name="signup_mail"]').val();
        let json = {
            "signup": "did",
            "signup_name": name,
            "signup_address": address,
            "signup_mail": mail
        };
        load_section_data(url, json);
    });

    //update内部の詳細クリック時のsubmit設定。
    $("section").on("click", "[name='detail_submit']", function () {
        let num = $(this).attr("value");
        let name = $('input[name="name' + num + '"]').val();
        let address = $('input[name="address' + num + '"]').val();
        let mail = $('input[name="mail' + num + '"]').val();
        let json = {
            "detail": "did",
            "name": name,
            "address": address,
            "mail": mail
        };
        url = "detail.php";
        load_section_data(url, json);
    });

    //更新時のロード遷移
    $("section").on("click", "input[name='update']", function () {
        let name = $('input[name="name"]').val();
        let address = $('input[name="address"]').val();
        let mail = $('input[name="mail"]').val();
        let update_name = $('input[name="update_name"]').val();
        let update_address = $('input[name="update_address"]').val();
        let update_mail = $('input[name="update_mail"]').val();
        let json = {
            "update": "did",
            "name": name,
            "address": address,
            "mail": mail,
            "update_name": update_name,
            "update_address": update_address,
            "update_mail": update_mail
        };
        load_section_data(url, json);
    });

    //delete時のロード遷移
    $("section").on("click", "[name='delete']", function () {
        let name = $('input[name="name"]').val();
        let address = $('input[name="address"]').val();
        let mail = $('input[name="mail"]').val();
        let json = {
            "delete": "did",
            "name": name,
            "address": address,
            "mail": mail
        };
        url = "delconf.php";
        load_section_data(url, json);
    });

    //delconf確認のとき.上とほとんど同じなので関数にしてよい
    $("section").on("click", "[name='conf']", function () {
        let name = $('input[name="name"]').val();
        let address = $('input[name="address"]').val();
        let mail = $('input[name="mail"]').val();
        let json = {
            "conf": "did",
            "name": name,
            "address": address,
            "mail": mail
        };
        url = "delconf.php";
        load_section_data(url, json);
    });

    //topに戻る
    $("section").on("click", "[name='back']", function () {
        url = "title.php";
        load_section(url);
    });
}
);

let count;
function fade_title(time) {

    if (count != null) {
        count++;
    }
    else {
        count = 1;
    }

/*
    $(".title").fadeIn(time / 6, csscheck(count, function () {
        $(".title").fadeOut(time / 6)
    })
    */
       $(".title").fadeOut(time/6,
        function(){

            if(count%3==1){
                $(this).css("color","red");
            }
            else{
                $(this).css("color","black");
            }

            $(this).fadeIn(time/6)
        });

    setTimeout(fade_title, time, time);
}

function load_section(link) {

    $("section").fadeOut(500, () => {
        $("section").load(link, () => {
            $("section").fadeIn(500);
        });
    });
}

function load_section_data(link, data) {

    $("section").fadeOut(500, () => {
        $("section").load(link, data, () => {
            $("section").fadeIn(500);
        });
    });
}