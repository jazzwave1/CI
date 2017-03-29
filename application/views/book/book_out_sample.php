<html>
<!--------------------------- HEAD --------------------------->  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>::::: Eduniety - BOOK :::::</title>
	
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
	<!--- //CSS --->
  </head>

<!--------------------------- BODY ---------------------------> 
<body>

	<!--------------------------- header --------------------------->
	<header>		
		<!--- GNB --->
        &#65279;<?php $this->load->view('book/gnb_book.php'); ?>

		<!--- LNB --->		
        &#65279;<?php $this->load->view('book/lnb_book.php'); ?>
	</header>

	<!--------------------------- contents --------------------------->
	<div id="CON_sub">
		<!--- 검색바 --->
        &#65279;<?php $this->load->view('book/search_bar.php'); ?>

		<!--- 흐르는 공지 --->
        &#65279;<?php $this->load->view('book/notice_flow_book.php'); ?>

		<div class="BAN_slide">
			<img src="/img/BOOK/BANNER/BANNER_1.png" alt-="BOOK 광고배너_1" style="width:100%;"/><!--- 예제이니 추후 슬라이딩 이미지 적용 후 삭제한다 ---> 
		</div>

		<!--- 1col to multi_col 이미지 리스트 --->
        &#65279;<?php $this->load->view('book/book_list.php'); ?>
	</div>

	<!--------------------------- footer --------------------------->
	<footer>
        &#65279;<?php $this->load->view('book/footer1_book.php'); ?>
	</footer>
        &#65279;<?php $this->load->view('book/footer2_book.php'); ?>

</body>
<!--------------------------- //body --------------------------->
</html>
