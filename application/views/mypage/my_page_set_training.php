<!-- set-BOOK -->

<div class="set"><!-- 고유속성 -->
    <!-- ad list -->
	<!-- log-out 상태 -->
	<div class="log_out"><!-- 상태 -->
		<!--- --->
        <?php if($aMyContentsInfo['logoutInfo']['aTraining']['etlist']) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>원격연수</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['aTraining']['etlist'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val['name']?><br> &nbsp;&nbsp;&nbsp;(<?=$val['term']?>)</b><em><?=$val['state']?></em></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
            <tr class="BT_reg">
                <td><a href="/sub/training/MAIN_all.php">전체교육일정 보기</a></td>
            </tr>
           
        </table>
        <?php endif ;?>

        <?php if($aMyContentsInfo['logoutInfo']['aTraining']['elist']) : ?>
        <!--table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>현장연수</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['aTraining']['elist'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val['name']?> <br> &nbsp;&nbsp;&nbsp;(<?=$val['term']?>)</b><em><?=$val['state']?></em></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
            <tr class="BT_reg">
                <td><a href="#">전체교육일정 보기</a></td>
            </tr>
        </table-->
        <?php endif ;?>
 


    </div><!-- // 상태 -->

    <!-- log-in 상태 -->
    <div class="log_in"><!-- 상태 -->
   
    </div><!-- // 상태 -->
</div><!-- 고유속성 -->
