<!doctype html>
<html lang="utf-8">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Coding Club Admin</title>
	<!-- Bootstrap core CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	<script src="https://code.jquery.com/jquery.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?=HOSTURL?>/static/AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=HOSTURL?>/static/AdminLTE-2.3.0/dist/css/AdminLTE.min.css"> 
  
  <script src="<?=HOSTURL?>/static/AdminLTE-2.3.0/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=HOSTURL?>/static/AdminLTE-2.3.0/plugins/datatables/dataTables.bootstrap.min.js"></script>
</head>
<!--form name="fo" action="submit.php" method="post"-->
<body id="wrapper">

    <nav class="navbar  navbar-inverse navbar-fixed-top" style="background-color:rgba(0,0,0,1); border: 0;">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="" style="color: white;" ><strong>CodingClub Admin</strong></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right" >
            <li><a href="<?=HOSTURL?>/admin/excelDownSummerCampFull" id="bLogout" style="color: white;">썸머캠프 신청자 다운로드</a></li>
            <li><a href="#" id="bLogout" style="color: white;">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div class="container" style="padding-top: 50px; margin-bottom: 50px;">
    <div class="row"style="margin-top: 10px; margin-bottom: 10px; ">
      <div class="col-xs-2">
        <label style="margin-top: 10px;margin-left: 10px;">검색조건</label>
      </div>
      <div class="col-xs-4">
        <div class="form-group">
          <select multiple id="course_idx" name="course_idx" class="form-control">
            <option value="" >프로그램 이름 선택</option>
<?php
            foreach($aCourse as $key=>$val)
            {
              //if($key == $courseIdx)
              if(in_array($key ,$courseIdx))
                echo '<option value="'.$key.'" selected>'.$val.'</option>';
              else
                echo '<option value="'.$key.'">'.$val.'</option>';
            }
?>
          </select>
        </div>
      </div>
      <div class="col-xs-2">
        <button id="bSend" class="btn btn-block btn-default">검색</button>
      </div>
    </div> 
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?php echo $courseName; ?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>신청 프로그램</th>
            <th>이름</th>
            <th>학교</th>
            <th>학년</th>
            <th>부모님이름</th>
            <th>부모님HP</th>
            <th>부모님메일</th>
            <th>상태</th>
            <th>기능</th>
          </tr>
          </thead>
          <tbody>
<?php
        if($aRowData)
        {
          foreach($aRowData as $key=>$val)
          {
            echo "<tr>";
            echo "  <td>".$val->course_idx."</td>"; 
            echo "  <td>".$val->name."</td>"; 
            echo "  <td>".$val->school."</td>"; 
            echo "  <td>".$val->grde."</td>"; 
            echo "  <td>".$val->pname."</td>"; 
            echo "  <td>".$val->php."</td>"; 
            echo "  <td>".$val->pemail."</td>"; 
            echo "  <td>".$val->state."</td>"; 
            echo "  <td><button id='bChangeState' onclick='javascript:changeState(".$val->usn.",".$val->courseIDX.")' class='btn btn-info'>입금확인</button>";
            echo "</tr>";
          }
        }
?>
        </table>  
      </div> 
    </div> 
  
  </div>
  <script>   
  function changeState(usn, course_idx)
  {
    $.post(
      // test code
      "<?=HOSTURL?>/Admin/rpcUpdateState"
      ,{
           "usn" : usn 
          ,"state" : 'CONF' 
          ,"course_idx" : course_idx 
       }
      ,function(data, status) {
        if (status == "success" && data.code == 1)
        {
          alert('변경 되었습니다.'); 
          window.location.reload(); 
        }
      }
    );         
  }     
  
  $(function(){
    $('#bSend').click(function(){
      var courseIDX = '' + $("select[name=course_idx]").val() ;
      var sCourseIDX = ''; 
      var aCourseIDX = courseIDX.split(',');
      for(var i in aCourseIDX)
      {
        sCourseIDX = sCourseIDX + aCourseIDX[i] + '_'; 
      }
      
      if($("select[name=course_idx]").val() == '')
      {
        alert('프로그램 이름을 선택해 주세요');
        $('#course_idx').focus();
        return;
      }
      // test code 
      window.location.replace("<?=HOSTURL?>/admin/userlist/" + sCourseIDX); 
    });
       
    $('#bLogout').click(function(){
        // test code 
        window.location.replace("<?=HOSTURL?>/admin/logout"); 
      });
        
    $("#example1").DataTable();

  });
  </script>
</body>

<!--/form-->
</html>
