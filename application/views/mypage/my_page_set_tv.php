<!-- set-TV -->

<div class="set"><!-- 고유속성 -->

	<!-- log-out 상태 -->
	<div class="log_out"><!-- 상태 -->
		<!--- --->
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>TV</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['tv'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->groupcat_name?></b><em><?=$val->content_cnt?>개</em></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
        </table>
    </div><!-- // 상태 -->

    <!-- log-in 상태 -->
    <div class="log_in"><!-- 상태 -->
        <!--- --->
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>TV</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['loginInfo']['tv'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->groupcat_name?></b><em><?=$val->content_cnt?>개</em></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
        </table>
    </div><!-- // 상태 -->
</div><!-- 고유속성 -->
