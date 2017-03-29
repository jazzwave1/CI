<?php
header( "Content-type: application/vnd.ms-excel" );
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = CodingClubUserList.xls" );
header( "Content-Description: PHP4 Generated Data" );
?>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>참여자명단</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>학부모성명</th>
        <th>학부모전화번호</th>
        <th>학부모Email</th>
        <th>학부모직업&전공</th>
        <th>거주지역</th>
        <th>학생성명</th>
        <th>학생학년</th>
        <th>학생학교</th>
        <th>신청프로그램</th>
        <th>참가했던 프로그램</th>
        <th>참가경험이 있다면 피드백 및 건의 사항</th>
        <th>참가동기, 목적</th>
        <th>교육경험</th>
        <th>학생의 성향및성격</th>
        <th>선호하거나 싫어 하는 것은</th>
        <th>프로그램에바라는점</th>
        <th>알게된경로</th>
        <th>코딩클럽에바라는점</th>
        <th>문의사항</th>
      </tr>
    </thead>
    <tbody>
<?php 
    foreach($aUserList as $key=>$val)
    { 
      echo '<tr>
        <td>'.$val->pname.'</td>
        <td>'.$val->php.'</td>
        <td>'.$val->pemail.'</td>
        <td>'.$val->pjob.'</td>
        <td>'.$val->addrcode.'</td>
        <td>'.$val->name.'</td>
        <td>'.$val->grde.'</td>
        <td>'.$val->school.'</td>
        <td>'.$val->course_idx.'</td>
        <td>'.$val->exprogram.'</td>
        <td>'.$val->recommend.'</td>
        <td>'.$val->motive.'</td>
        <td>'.$val->experience.'</td>
        <td>'.$val->nature.'</td>
        <td>'.$val->favor.'</td>
        <td>'.$val->jr_hope.'</td>
        <td>'.$val->channel.'</td>
        <td>'.$val->club_hope.'</td>
        <td>'.$val->inquiry.'</td>
      </tr>';
      }
?>
    </tbody>
  </table>
</div>

</body>
</html>

