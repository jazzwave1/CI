	<table cellpadding="0" cellspacing="0"><!--- 섹션  --->
      <?php foreach($newlist as $key=>$val) :?>
        <tr>
            <td><a href="/membership/book/detail/<?=$val['g_num']?>"><img src="<?=$val['sImgURL']?>" alt="서적사진" /></a></td>
			<td>
                <h2><?=$val['name']?></h2>
                [저자] <?=$val['author_name']?><br>
                [정가] <b><big><?=$val['price']?>원</big></b><br>
                [종이책정가] <b><big><?=$val['g_price_street']?>원</big></b> <br>
			</td>
		</tr>
      <?php endforeach; ?>
    </table><!--- // 섹션 --->
