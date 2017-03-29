<html>
<!--------------------------- HEAD --------------------------->  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>::::: Eduniety - 행복한 연수원 :::::</title>
	
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
    <!--- //CSS --->
    
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>

</head>

<!--------------------------- BODY ---------------------------> 
<body>

	<!--------------------------- header --------------------------->
    <header>
        <div class="GNB">
            <ul>
                <li><a href="/POP/myPage_TRAINING_OUT.php" target="_blank"><img src="/img/BT_3line.png" alt="메인메뉴 가기" /></a></li>
                <li><a href="/sub/training/MAIN_all.php"><h1>멤버쉽서비스구매</h1></a></li>
                <li><a href="/index.php"><img src="/img/BT_home.png" alt="홈버튼 가기" /></a></li>
            </ul>
        </div>        

        <div class="LNB_sub">
            <ul class="nav">
                <li><a href="/sub/training/MAIN_all.php" class="active">전체</a></li>
                <li><a href="/sub/training/MAIN_eduOffice.php">교육청</a></li>
                <li><a href="/sub/training/MAIN_field.php">현장</a></li>
                <li><a href="/sub/training/MAIN_inno.php">학교혁신</a></li>
                <li><a href="/sub/training/MAIN_life.php">생활교육</a></li>
            </ul>
        </div>
	</header>

<br>
<br>
<br>
<br>
<br>
    <div class="LECTURE_apply">
        <div id="TABLE_wrap"><strong>멥버쉽서비스정보</strong></div>
    </div>

    <?php foreach($aProductInfo as $key=>$val) :?>
    <div class="LECTURE_apply"><!--- 각 페이지 효과 구분 타 페이징서 공통적인 요소가 있어 구분하는 것 --->
        <div id="TABLE_wrap"><!--- table wrap --->
            <table class="TABLE_1col">
                <tr>
                    <th colspan=2><?=$val->name?></th>
                </tr>
                <tr>
                    <th>사용기간</th>
                    <td>1년( ~ 12.31 )</td>
                </tr>
                <tr>
                    <th>가격</th>
                    <td><?=number_format($val->price)?> 원</td>
                </tr>
                <tr>
                    <td colspan=2 align='center'>서비스 혜택</td>
                </tr>
                <tr>
                    <th>원격 </th>
                    <td>직무/자율, 연수 <?=$val->e_training?>과정 수강 해택</td>
                </tr>
                <tr>
                    <th>현장 </th>
                    <td>직무/자율, 연수 <?=$val->training?>과정 수강 해택</td>
                </tr>
                <tr>
                    <th>BOOK</th>
                    <td><?=$val->training?>종구매</td>
                </tr>
            </table>
        </div> <!-- // table wrap -->
    </div>
    <!-- 최종버튼 -->
    <div id="BT_wrap">
        <span class="BT_reg"><a href="#" onclick="javascript:rpcBuy('<?=$mb_id?>',<?=$val->sale_idx?>)"><img src="/img/myPage/I_pencil.png" alt="아이콘" style="width:10%;height:2%;" /> 구매하기 </a></span>
    </div>
    <br> 
    <!--- // 최종버튼 --->
    <?php endforeach ;?>
    
    <!--------------------------- footer --------------------------->
	<footer>
		<?php include $_SERVER['DOCUMENT_ROOT']."/include/footer1_TRAINING.php"; ?>
	</footer>
		<?php include $_SERVER['DOCUMENT_ROOT']."/include/footer2_TRAINING.php"; ?>
<script>   
function rpcBuy(mb_id, sale_idx)
{
    $.post(
        "/membership/member/rpcBuy"
        ,{
            "mb_id" :mb_id 
            ,"sale_idx" : sale_idx 
        }
        ,function(data, status) {
            if (status == "success" && data.code == 1)
            {
                alert('구매가 완료 되었습니다.'); 
            }
            else
            {
                alert(data.msg);
            }
        }
    );         
}     
</script>
</body>
</html>
