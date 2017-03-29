<!--------------------------- BOOK footer_1 ---------------------------> 
<div>
    <ul class="BT_1">
        <?php if($isLogin) : ?> 
        <li><a href="/process/PORTAL/logout.php">로그아웃</a></li>
        <?php else :?>
        <li><a href="/sub/PORTAL/MEMBER_login.php?url=/">로그인</a></li>
        <?php endif;?> 
        <li><a href="/sub/PORTAL/MEMBER_myInfo_modify.php">개인정보관리</a></li>
		<li><a href="/sub/training/COMMUNITY_appguide.php">고객센터</a></li>
	</ul>
</div>

<div>
	<ul class="BT_2">
		<li><a href="/sub/PORTAL/INFO_eduniety.php">에듀니티소개</a></li>
		<li class="popBtn"><a>BOOK 이용약관</a></li>
		<li><a href="/POP/privacy.php">개인정보취급방침</a></li>
	</ul>

	<br />

	<span class="TXT">Copyright © EDUNIETY co., ltd. All Rights Reserved.</span>
</div>

<br />
<br />
<br />
