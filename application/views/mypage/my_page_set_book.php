<!-- set-BOOK -->

<div class="set"><!-- 고유속성 -->

	<!-- log-out 상태 -->
	<div class="log_out"><!-- 상태 -->
		<!--- --->
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td class="h2"><h2>BOOK 최신 도서</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['book'] as $key=>$val) : ?>
			<tr>
				<td>
                    <span><a href="#">-&nbsp;<b><?=$val->name?></b><br>
					- 저자&nbsp;:&nbsp;<?=$val->writer?><br>
					- 정가&nbsp;:&nbsp;<big><?=$val->price?>원</big> (멤버십 회원 0원) <!--em>10% 할인가</em-->
				</td>
            </tr>
            <?php endforeach ;?>
			<tr class="BT_reg">
				<td><a href="/membership/book/booklist/all">전체도서보기</a></td>
			</tr>
	    </table>
    </div><!-- // 상태 -->

    <!-- log-in 상태 -->
    <div class="log_in"><!-- 상태 -->
        <!--- --->
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>BOOK 최신 도서</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['loginInfo']['book'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->name?></b><br>
                    - 저자&nbsp;:&nbsp;<?=$val->writer?><br>
                    - 정가&nbsp;:&nbsp;<big><?=$val->price?>원</big> (멤버십 회원 0원) <em></em>
                </td>
            </tr>
            <?php endforeach ;?>
            <tr class="BT_reg">
                <td><a href="/membership/book/booklist/all">전체도서보기</a></td>
            </tr>
        </table>
    </div><!-- // 상태 -->
</div><!-- 고유속성 -->
