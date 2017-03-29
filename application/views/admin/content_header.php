          <h1>
            <?=$bTitle?> 
            <small><?=$sTitle?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i><?=$navi[0]?></a></li>
            <?php
              for($i=1 ; $i < count($navi) ; $i++)
              {
                echo '<li class="active">'.$navi[$i].'</li>';
              }
            ?>
          </ol>

          <!--h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol-->
 
