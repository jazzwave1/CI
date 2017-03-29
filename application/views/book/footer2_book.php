<!--- 붙박이 메뉴 --->
<div class="footer_2">
	<ul class="div_4">
        <li><a href="/membership/mymembership/main">멤버십</a></li>
        <li><a href="/sub/training/myLecture.php">나의강의실</a></li>
		<li><a href="/membership/book/mybook">내서재</a></li><!--- 추후 확인 --->
		<li><a href="#" onclick="javascript:alert('알림이 없습니다.');" ><!--i>100</i-->알림</a></li><!--- 추후 페이지 추가 --->
	</ul>

	<!--- 더보기 하위항목: 추후 토글로 처리; 네이버참조: 처리후, 본 주석은 지울것 ---->
	<ul style="display:none;">
		<li><a href="/sub/BOOK/SAVE_book.php">찜</a></li><!--- 추후 확인 --->
		<li><a href="/sub/BOOK/CART.php">장바구니</a></li>
		<li><a href="/sub/BOOK/BUY_list.php">구매내역</a></li>
		<li><a href="/sub/BOOK/COMMUNITY.php">고객센터</a></li>
	</ul>
</div>

<script>
    $(".footer_2 li a").click(function () {
        $(".footer_2 li a.active").removeClass("active");
        $(this).addClass("active");
    });
</script>
