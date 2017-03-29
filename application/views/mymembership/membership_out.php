<html>
<!--------------------------- HEAD --------------------------->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>::::: Eduniety - Membership :::::</title>
    <!--- 서체 --->
    <link href='http://fonts.googleapis.com/earlyaccess/nanumgothic.css' rel='stylesheet' type='text/css'>
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.4.10/webfont.js"></script>
    <script type="text/javascript">
        WebFont.load({
            // For google fonts
            google: {
                families: ['Droid Sans', 'Droid Serif']
            }
            // For early access or custom font
            custom: {
                families: ['Nanum Gothic'],
                urls: ['http://fonts.googleapis.com/earlyaccess/nanumgothic.css']
            }
        });
    </script>
    <!--- // 서체 --->

    <!--- CSS --->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/book_style.css">
    <link rel="stylesheet" href="/membership/static/css/membership.css">
    <!--- //CSS --->

    <link rel="stylesheet" href="/external/Swiper-3.4.1/dist/css/swiper.min.css">
    <link rel="stylesheet" href="/css/swiper.css">

    <script src="/js/jq/jquery-1.9.1.min.js"></script>
    <script src="/js/jq/jquery.cookie.js"></script>
    <script src="/external/Swiper-3.4.1/dist/js/swiper.min.js"></script>
    <script src="/js/chart/core.js"></script>
    <script src="/js/chart/chart.js"></script>
    <!--- 팝업 --->
    <script src="/js/popup/popup.js"></script>
</head>

<!--------------------------- BODY --------------------------->
<body>

<!--------------------------- header --------------------------->
<header>
    <!--- GNB --->
    <?php $this->load->view('mymembership/gnb_membership.php'); ?>
</header>
<div class="dimmed"></div>
<!--------------------------- contents --------------------------->
<div id="member_CON_sub">
    <?=$contents?>
</div>

    <?php $this->load->view('book/footer2_book.php'); ?>

</body>
<!--------------------------- //body --------------------------->
</html>
