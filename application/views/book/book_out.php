<html>
<!--------------------------- HEAD --------------------------->  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>::::: Eduniety - BOOK :::::</title>

    <!--- JQUERY --->
    <script src="/js/jq/jquery-1.9.1.min.js"></script>

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
	<!--- //CSS --->

    <link rel="stylesheet" href="/external/Swiper-3.4.1/dist/css/swiper.min.css">
    <link rel="stylesheet" href="/css/swiper.css">

    <script src="/js/jq/jquery-1.9.1.min.js"></script>
    <script src="/js/jq/jquery.cookie.js"></script>
    <script src="/external/Swiper-3.4.1/dist/js/swiper.min.js"></script>

    <!--- 팝업 --->
    <script src="/js/popup/popup.js"></script>

</head>
    
<!--------------------------- BODY ---------------------------> 
<body>

    <?php $this->load->view('book/mypage_div.php'); ?>

	<!--------------------------- header --------------------------->
	<header>		
		<!--- GNB --->
        <?php $this->load->view('book/gnb_book.php'); ?>

		<!--- LNB --->
        <?php $this->load->view('book/lnb_book.php', array('aCategory'=>$aCategory)); ?>
	</header>
    <!--------------------------- 풍선아이콘 --------------------------->
    <div class="I_bubble_back"><a href="javascript:history.back();"><img src="/img/ft_bk.png" alt="뒤로"></a></div>
    <div class="I_bubble_top"><a href="#"><img src="/img/ft_top.png" alt="위로"></a></div>

	<!--------------------------- contents --------------------------->
	<div id="CON_sub">
		<!--- 1col to multi_col 이미지 리스트 --->
        <?=$contents?>
	</div>

	<!--------------------------- footer --------------------------->
	<footer>
        <?php $this->load->view('book/footer1_book.php' , array('isLogin'=>$isLogin)); ?>
	</footer>
        <?php $this->load->view('book/footer2_book.php'); ?>

    <div id="bookPop">
        <?php $this->load->view('book/book_terms.php'); ?>
    </div>
</body>
<!--------------------------- //body --------------------------->
</html>
