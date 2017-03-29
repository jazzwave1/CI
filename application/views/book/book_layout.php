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
        <?php $this->load->view('book/gnb_book.php'); ?>

		<!--- LNB --->		
        <?php $this->load->view('book/lnb_book.php'); ?>
	</header>

	<!--------------------------- contents --------------------------->
	<div id="CON_sub">


    </div>

	<!--------------------------- footer --------------------------->
	<footer>
        <?php $this->load->view('book/footer1_book.php'); ?>
	</footer>
        <?php $this->load->view('book/footer2_book.php'); ?>

</body>
<!--------------------------- //body --------------------------->
</html>
