<?

//session_start();
//set_session('ss_mb_id', $p_userid);
/*if($_SESSION['ss_mb_id'])
{
	$user_id = $_SESSION['ss_mb_id'];
}*/

//echo $user_id."araeftgf";


?>
<script language="javascript" type="text/javascript">
var isBrowserType = 0; //0:desktop, 1:Android, 2:Ios

	function CheckBrowserType(){
		var uagent = navigator.userAgent.toLowerCase();
		if( uagent.search("android")  >  -1 ){
			isBrowserType= 1;
		}else if( uagent.search("iphone")  >  -1  ||  uagent.search("ipad")  >  -1   ) {
			isBrowserType= 2;
		} else {
			isBrowserType= 0;
		}
	}

	function OnSetup(){
		CheckBrowserType();

		if(isBrowserType == 1) { // 안드로이드
			window.android.goSetting();
		} else if(isBrowserType == 2) {  //아이폰
			//document.location = "jscall://goContentPlayCDE:"+ url;
			window.location.href = "jscall://goSetting:";
		} else {
			alert("앱기능입니다.");
		}
	}	

</script>
<div class="top"><!--- 페이지 고유속성 --->

	<!------------------- log-out 상태 ------------------->
	<div class="log_out"><!------------ 상태 ------------>

		<!------ 포탈 ------> <!---ch--->
		<section class="PORTAL"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기전" /></li>
							<li>
								<h1>MY PAGE</h1> <!---ch--->
								<span class="BT_reg"><a href="/sub/PORTAL/MEMBER_login.php?url=/">로그인</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
							<li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>
		</section><!--- // 고유속성 --->

		<!------ 연수 ------> <!---ch--->
		<section class="TRAINING"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[행복한연수원]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/sub/PORTAL/MEMBER_login.php?url=/">로그인</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
	                        <li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>
		</section><!--- // 고유속성 --->

		<!------ BOOK ------> <!---ch--->
		<section class="BOOK"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[BOOK]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/sub/PORTAL/MEMBER_login.php?url=/">로그인</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
                            <li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>
		</section><!--- // 고유속성 --->

		<!------ TV ------> <!---ch--->
		<section class="TV"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[TV]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/sub/PORTAL/MEMBER_login.php?url=/">로그인</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
                            <li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>
		</section><!--- // 고유속성 --->

	</div><!------------ // 상태 ------------>

<!-------------------------------------------------------------------------------------------->

	<!------------------- log-in 상태 ------------------->
	<div class="log_in"><!------------ 상태 ------------>

		<!------ 포탈 ------> <!---ch--->
		<section class="PORTAL"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기 전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[에듀니티포탈]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/process/PORTAL/logout.php">로그아웃</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
                            <li><img src="/img/BT_setup.png" alt="마이페이지 설정" onclick= 'OnSetup();' /></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>		
		</section><!--- // 고유속성 --->

		<!------ 연수 ------> <!---ch--->
		<section class="TRAINING"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기 전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[행복한연수원]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/process/PORTAL/logout.php">로그아웃</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
                            <li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>		
		</section><!--- // 고유속성 --->

		<!------ BOOK ------> <!---ch--->
		<section class="BOOK"><!--- 고유속성 ---> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기 전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[BOOK]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/process/PORTAL/logout.php">로그아웃</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
                            <li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>		
		</section>

		<!------ TV ------> <!---ch--->
		<section class="TV"> <!---ch--->
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<ul class="member">
							<li><img src="/img/img_member.png" alt="회원사진 넣기 전" /></li>
							<li>
								<h1>MY PAGE</h1><!--h2>[TV]</h2--> <!---ch--->
								<span class="BT_reg"><a href="/process/PORTAL/logout.php">로그아웃</a></span> <!---ch--->
							</li>
							<li style="clear:both; color:#fff;"></li>
						</ul>
					</td>

					<td>
						<ul class="BTs">
                            <li><img src="/img/BT_setup.png" alt="마이페이지 설정"  onclick= 'OnSetup();'/></li>
                            <li><a href="#" onclick="javascript:CloseMyPage();"><img src="/img/BT_close.png" alt="페이지 닫기 아이콘" /></a></li>
						</ul>
					</td>
				</tr>
			</table>		
		</section><!--- //고유속성 --->

	</div><!------------ // 상태 ------------>

</div><!--- // 페이지 고유속성 --->
