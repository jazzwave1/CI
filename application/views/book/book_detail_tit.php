<h2><?=$aBookDetailInfo['g_name']?></h2>
<table cellpadding="0" cellspacing="0">
    <th>
        <a href="#"><img src="<?=$aBookDetailInfo['sImgURL']?>" alt="도서 사진" /></a>
    </th>
    <td>
        <b>&nbsp;[저자]</b><?=$aBookDetailInfo['author_name']?><br>
        <b>&nbsp;[정가]</b> <b><big><?=$aBookDetailInfo['price']?></big></b> (맴버쉽 회원 0원) <br>
        <b>&nbsp;[파일형태]</b><?=$aBookDetailInfo['file_form']?><br>
        <b>&nbsp;[지원기기]</b> 아이폰 , 안드로이드폰 <br>
    </td>
</table>
