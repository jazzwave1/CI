<!--li class="active treeview">
  <a href="#">
    <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
    <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
  </ul>
</li>
<li class="treeview">
  <a href="#">
    <i class="fa fa-files-o"></i>
    <span>Layout Options</span>
    <span class="label label-primary pull-right">4</span>
  </a>
  <ul class="treeview-menu">
    <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
    <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
    <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
  </ul>
</li-->
            <?php
              foreach($aMenu as $key=>$val)
              {
                if(count($val['child'] > 0))
                {
                  if($val['active'])
                    echo '<li class="active treeview">';
                  else
                    echo '<li class="treeview">';
                  
                  echo '  <a href="#">';
                  echo '    <i class="'.$val['title_class'].'"></i>';
                  echo '      <span>'.$val['title'].'</span>';
                  echo '  </a>';
                  
                  if(is_array($val['child']))
                  {
                    echo '<ul class="treeview-menu">';
                    foreach($val['child'] as $k=>$v)
                    {
                      echo '<li><a href="'.$v['link'].'"><i class="fa fa-circle-o"></i>'.$v['title'].'</a></li>';
                    }
                    echo '  </ul>';
                    echo '</li>';
                  }
                }
              }
            ?> 
 
