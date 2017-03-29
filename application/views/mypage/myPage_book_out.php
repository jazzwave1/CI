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
		},
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

    <!--- 메뉴 토글 및 슬라이더 --->
    <link rel="stylesheet" href="/external/Swiper-3.4.1/dist/css/swiper.min.css">
    <link rel="stylesheet" href="/css/swiper.css">
    <script src="/external/Swiper-3.4.1/dist/js/swiper.min.js"></script>

    <script>
    <?php if($myPage_type == 'myPage_OUT') : ?>
         $("#myPage_OUT .log_out").css("display","block");
    <?php else : ?>
         $("#myPage_OUT .log_out").css("display","none");
    <?php endif;?>

    <?php if($myPage_type == 'myPage_IN' && $myPage_state == "_PORTAL" ) : ?>
        $("#myPage_IN ._PORTAL .log_in .BOOK").css("display","none");
    <?php else : ?>
        $("#myPage_IN ._PORTAL .log_in .BOOK").css("display","block");
    <?php endif;?>
    </script>
</head>

	<!--------------------------- BODY ---------------------------> 
	<body>
		<div class="myPage">
            <section id="<?=$myPage_type?>"><!--- 상태 고유속성 --->
				<div class="<?=$myPage_state?>"><!--- 페이지 고유속성 --->

                   <!--- top 메뉴 --->
                   <?php $this->load->view('mypage/my_page_top'); ?>
                    
                    <!--- 아이콘 메뉴 --->
                   <?php $this->load->view('mypage/my_page_menu'); ?>
                    
                    <!--- 광고 or User Info --->
                   <?= $view_userinfo ?>
                    
                    <!--- 맞춤메뉴 --->
                   <?= $view_new_contents ?>
                
                </div><!--- // 페이지 고유속성 --->
			</section><!--- // 상태 고유속성 --->
		</div>
	</body>

</html>

