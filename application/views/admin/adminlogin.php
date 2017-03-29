<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Codinglcub</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=HOSTURL?>/img/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=HOSTURL?>/img/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?=HOSTURL?>/img/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <!-- jQuery 2.1.4 -->
    <script src="<?=HOSTURL?>/img/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=HOSTURL?>/img/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?=HOSTURL?>/img/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

    <!-- 커스텀 스타일 -->
    <link rel="stylesheet" href="<?=HOSTURL?>/static/css/summercamp.css">

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo"><b>CodingClub</b>
      <br>
      <br>
      <div class="login-logo">Admin Login
      </div><!-- /.login-logo -->
     
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
          
        <div class="form-group has-feedback">
          <input type="email" id="account_id" class="form-control" placeholder="ID">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" id="passwd" class="form-control" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="btn_area">
          <div class="w50">
            <button id="bLogin" class="btn btn-primary btn-block btn-flat">로그인</button>
          </div>
          <!--div class="w50">
            <button class="btn btn-primary-line">회원가입</button>
          </div--><!-- /.col -->
        </div>
      </div><!-- /.login-box-body -->

    <script>
      $(function(){
        $('#bLogin').click(function(){
        
          $.post(
            "<?=HOSTURL?>/Admin/rpcAdminLogin"
            ,{
               "account_id" : $('#account_id').val()
              ,"passwd" : $('#passwd').val()
            }
            ,function(data, status){
              if(status == 'success' && data.code == 1)
              {
                window.location.replace("<?=HOSTURL?>/admin/userlist"); 
              }
              else
              {
                alert('아이디 / 비밀번호를 다시 확인 부탁 드립니다');
              }
            }
          );
        });
      });
    </script>

    </div><!-- /.login-box -->
    <!-- value test code setting-->

  </body>
</html>
