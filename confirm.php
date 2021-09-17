<?php
// フォームのボタンが押されたら
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータを各変数に格納
    $name = $_POST["name"];
    $furigana = $_POST["furigana"];
    $email = $_POST["email"];
    $tel = $_POST["tel"];
    $sex = $_POST["sex"];
    $item = $_POST["item"];
    $comment  = $_POST["comment"];
}

// 送信ボタンが押されたら
if (isset($_POST["submit"])) {
    // 日本語をメールで送る場合のおまじない
    mb_language("ja");
    mb_internal_encoding("UTF-8");

    // 送信ボタンが押された時に動作する処理をここに記述する
    $receiveSubject = "フォームからの問い合わせ";
    $receiveBody = <<< EOM

    {$name} 様から以下のお問い合わせが来ています。

    ===================================================
    【 お名前 】 
    {$name}

    【 ふりがな 】 
    {$furigana}

    【 メール 】 
    {$email}

    【 電話番号 】 
    {$tel}

    【 性別 】 
    {$sex}

    【 項目 】 
    {$item}

    【 内容 】 
    {$comment}
    ===================================================
EOM;


    //mb_send_mail("○○@example.com(問い合わせを受信したいメールアドレス)", "問い合わせメール件名($receiveSubject)", "問い合わせメール本文($receiveBody)");
    mb_send_mail("○○@example.com", "$receiveSubject", "$receiveBody");

    // 件名を変数subjectに格納
    $subject = "［自動送信］お問い合わせ内容の確認";

    // メール本文を変数bodyに格納
    $body = <<< EOM
{$name} 様

お問い合わせありがとうございます。
以下のお問い合わせ内容を、メールにて確認させていただきました。

===================================================
【 お名前 】 
{$name}

【 ふりがな 】 
{$furigana}

【 メール 】 
{$email}

【 電話番号 】 
{$tel}

【 性別 】 
{$sex}

【 項目 】 
{$item}

【 内容 】 
{$comment}
===================================================

内容を確認のうえ、回答させて頂きます。
しばらくお待ちください。
EOM;

    // 送信元(サイト運営側)のメールアドレス(○○@example.com)を変数fromEmailに格納
    $fromEmail = "○○@example.com";

    // 送信元の名前を変数fromNameに格納
    $fromName = "○○";

    // ヘッダ情報を変数headerに格納する		
    $header = "From: " . mb_encode_mimeheader($fromName) . "<{$fromEmail}>";

    // メール送信を行う
    mb_send_mail($email, $subject, $body, $header);

    // サンクスページに画面遷移させる(公開時は本番環境のURLに変更する)
    header("Location: thanks.html"); //ローカル
    // header("Location: https://xxxxxxxxxxx/thanks.html"); //本番
    exit;
}
?>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>○○|お問い合わせ内容確認画面</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="icon" type="image/x-icon" href="atlas.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    <header class="header">
        <h1 class="header-ttl">
            <a href="#">
                <i class="fas fa-atlas"> ○○</i>
            </a>
        </h1>
        <nav class="header-nav">
            <ul class="header-nav-list">
                <li class="header-nav-item"><a href="#">ホーム</a></li>
                <li class="header-nav-item"><a href="#">事業内容</a></li>
                <li class="header-nav-item"><a href="#">会社概要</a></li>
                <li class="header-nav-item"><a href="#">採用情報</a></li>
                <li class="header-nav-item"><a href="contact.html">お問い合わせ</a></li>
            </ul>
        </nav>
        <div class="menu" id="menu">
            <span class="menu-line-top"></span>
            <span class="menu-line-middle"></span>
            <span class="menu-line-bottom"></span>
        </div>
        <nav class="drawer-nav" id="drawer-nav">
            <ul class="drawer-nav-list">
                <li class="drawer-nav-item"><a href="#">ホーム</a></li>
                <li class="drawer-nav-item"><a href="#">事業内容</a></li>
                <li class="drawer-nav-item"><a href="#">会社概要</a></li>
                <li class="drawer-nav-item"><a href="#">採用情報</a></li>
                <li class="drawer-nav-item"><a href="contact.html">お問い合わせ</a></li>
            </ul>
        </nav>
    </header>
    <!-- header end -->

    <!-- page-mv -->
    <h2 class="ttl">お問い合わせ</h2>
    <!-- page-mv end -->
    <main>
        <div class="ptb-m wrap-s">
            <form action="confirm.php" method="post">
                <input type="hidden" name="name" value="<?php echo $name; ?>">
                <input type="hidden" name="furigana" value="<?php echo $furigana; ?>">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="tel" value="<?php echo $tel; ?>">
                <input type="hidden" name="sex" value="<?php echo $sex; ?>">
                <input type="hidden" name="item" value="<?php echo $item; ?>">
                <input type="hidden" name="comment" value="<?php echo $comment; ?>">
                <h3 class="contact-title">お問い合わせ内容確認</h3>
                <p>お問い合わせ内容はこちらで宜しいでしょうか？<br>よろしければ「送信する」ボタンを押して下さい。</p>
                <div class="contact-form">
                    <div>
                        <label>■お名前</label>
                        <p><?php echo htmlspecialchars($name); ?></p>
                    </div>
                    <div>
                        <label>■ふりがな</label>
                        <p><?php echo htmlspecialchars($furigana); ?></p>
                    </div>
                    <div>
                        <label>■メールアドレス</label>
                        <p><?php echo htmlspecialchars($email); ?></p>
                    </div>
                    <div>
                        <label>■電話番号</label>
                        <p><?php echo htmlspecialchars($tel); ?></p>
                    </div>
                    <div>
                        <label>■性別</label>
                        <p><?php echo htmlspecialchars($sex); ?></p>
                    </div>
                    <div>
                        <label>■お問い合わせ項目</label>
                        <p><?php echo htmlspecialchars($item); ?></p>
                    </div>
                    <div>
                        <label>■お問い合わせ内容</label>
                        <p class="comment-wrap"><?php echo htmlspecialchars(nl2br($comment)); ?></p>
                    </div>
                </div>
                <div class="confirm-btn">
                    <input type="button" value="内容を修正する" onclick="history.back()" class="text-submit">
                    <button type="submit" name="submit" class="text-submit">送信する</button>
                </div>
            </form>
        </div>
    </main>

    <!-- footer -->
    <footer class="footer">
        <div class="footer-inner wrap">
            <small class="footer-copyright">&copy; 2021 ○○ inc.</small>
            <nav class="footer-nav">
                <ul class="footer-nav-list">
                    <li class="footer-nav-item"><a href="#">ホーム</a></li>
                    <li class="footer-nav-item"><a href="#">事業内容</a></li>
                    <li class="footer-nav-item"><a href="#">会社概要</a></li>
                    <li class="footer-nav-item"><a href="#">採用情報</a></li>
                    <li class="footer-nav-item"><a href="contact.html">お問い合わせ</a></li>
                </ul>
            </nav>
        </div>
    </footer>
    <!-- footer end -->
    <script src="js/main.js"></script>
</body>

</html>