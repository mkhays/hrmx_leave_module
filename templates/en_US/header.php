<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/index.php" style="color:#C0F40B" ><i class="fa fa-home"></i> BIHRIS</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
             <li <?php   if(isset($_GET['link'])){echo "class=".($_GET['link'] == 'leave' ? 'active' : ''); }?> ><a href="index.php?request=leave_form&link=leave&link2=lv_f" id="a"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Leave Management</a></li>
       <li <?php   if(isset($_GET['link'])){echo "class=".($_GET['link'] == 'time' ? 'active' : ''); }?> ><a href="https://hris.baylor-uganda.org/modules/timesheet/index.php?request=view_year&link=time&link2=t_f&yr=<?php echo date('Y'); ?>"><span class="glyphicon glyphicon-time"></span></i>&nbsp;&nbsp;Time Sheet</a></li>
        <li <?php   if(isset($_GET['link'])){echo "class=".($_GET['link'] == 'appraisal' ? 'active' : ''); }?> ><a href="https://hris.baylor-uganda.org/modules/appraisal/index.php/creports/appraisal_instance/" > <i class="fa fa-bar-chart"></i>&nbsp;&nbsp;Performance Management</a></li>
           <li <?php   if(isset($_GET['link'])){echo "class=".($_GET['link'] == 'schedule' ? 'active' : ''); }?> ><a href="https://hris.baylor-uganda.org/modules/schedule/index.php/cforms/leave_sch_frm"><span  style="color:#FF9"><span class="label label-warning">New</span> <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;Leave Schedule</span></a></li>
		           <li <?php   if(isset($_GET['link'])){echo "class=".($_GET['link'] == 'schedule' ? 'active' : ''); }?> ><a href="https://hris.baylor-uganda.org/modules/time/"><span  style="color:#FF9"><span class="label label-warning">New</span> <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;Time and Attendance</span></a></li>
		<li><a href="#"><span class="glyphicon glyphicon-question-sign"></span>&nbsp;&nbsp;help</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="margin-right:4px">
     <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo 'Welcome '. $_SESSION['firstname'] .' '. $_SESSION['lastname'].' '; ?> <span class="glyphicon glyphicon-user"></span><span class="caret"></span></a>
     <ul class="dropdown-menu">
      <li><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-user"></span><strong>&nbsp;<?php echo $_SESSION['position'];  ?></strong></span></li>
       <li class="divider"></li>
          <li style="margin-left:4px; color:#099"><b>Supervisor</b></li>
            <li style="margin-left:4px; color:#099"><i><?php echo $sup_name;   ?></i></li>
          <li class="divider"></li>
          <li><a href="index.php?request=logout">Log Out</a></li>
        </ul>
     </li> 
     </ul>
  </div><!-- /.navbar-collapse -->
</nav>
<div class="well well-sm" id="well"><i class="fa fa-calendar"></i> <?php  echo $main_title; ?></div>					
