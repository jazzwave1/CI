<!-- set-PORTAL -->

<div class="set"><!-- 고유속성 -->

	<!-- log-out 상태 -->
	<div class="log_out"><!-- 상태 -->
		<!--- --->
        <?php if($aMyContentsInfo['logoutInfo']['portal']['etlist']) : ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>원격연수</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['portal']['etlist'] as $key=>$val) : ?>
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

        <?php if($aMyContentsInfo['logoutInfo']['portal']['elist']) : ?>
        <!--table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>현장연수</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['portal']['elist'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val['name']?> <br> &nbsp;&nbsp;&nbsp;(<?=$val['term']?>)</b><em><?=$val['state']?></em></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
            <tr class="BT_reg">
                <td><a href="/sub/training/MAIN_all.php">전체교육일정 보기</a></td>
            </tr>
        </table-->
        <?php endif ;?>
        


        <!-- BOOK & TV 잠시 막아 둡니다query 확인후 다시 처리함-->

        <!--table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>BOOK</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['portal']['booklist'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val['name']?></b><em><?=$val['cnt']?>개</em></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
        </table>
        
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>TV</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['logoutInfo']['portal']['tvlist'] as $key=>$val) : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val['name']?> (<?=$val['term']?>)</b></a></span>
                </td>
            </tr>
            <?php endforeach ;?>
        </table-->
    </div><!-- // 상태 -->

    <!-- log-in 상태 -->
    <div class="log_in"><!-- 상태 -->
        <!--- --->

        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>원격연수(직무)<!-- (직무+자율) --></h2></td-->
            </tr>
            <?php foreach($aMyContentsInfo['loginInfo']['portal'] as $key=>$val) : ?>
            <?php   if($val->type=='et') : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->name?></b><em><?=$val->cnt?><!-- 개 -->학점</em></a></span>
                </td>
            </tr>
            <?php   endif ;?>
            <?php endforeach ;?>
        </table>

        <!--table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>현장연수(직무+자율)</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['loginInfo']['portal'] as $key=>$val) : ?>
            <?php   if($val->type=='t') : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->name?></b><em><?=$val->cnt?>개</em></a></span>
                </td>
            </tr>
            <?php   endif ;?>
            <?php endforeach ;?>
        </table-->
        
       
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>BOOK</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['loginInfo']['portal'] as $key=>$val) : ?>
            <?php   if($val->type=='b') : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->name?></b><em><?=$val->cnt?>개</em></a></span>
                </td>
            </tr>
            <?php   endif ;?>
            <?php endforeach ;?>
        </table>
        
        <!--table cellpadding="0" cellspacing="0">
            <tr>
                <td class="h2"><h2>TV</h2></td>
            </tr>
            <?php foreach($aMyContentsInfo['loginInfo']['portal'] as $key=>$val) : ?>
            <?php   if($val->type=='tv') : ?>
            <tr>
                <td>
                    <span><a href="#">-&nbsp;<b><?=$val->name?></b><em><?=$val->cnt?>개</em></a></span>
                </td>
            </tr>
            <?php   endif ;?>
            <?php endforeach ;?>
        </table-->

    </div><!-- // 상태 -->
</div><!-- 고유속성 -->
