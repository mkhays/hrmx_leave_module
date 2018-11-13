<li class="nav-header" style=" color:#17AE2B;font-size: 13px;font-weight: 700; margin-left:4px; margin-top:3px;">LEAVE MANAGEMENT</li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">Request Forms</li> 
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'lv_f' ? 'active2' : 'null'); }?> href="index.php?request=leave_form&link=leave&link2=lv_f"><i class="fa fa-file-text"></i> Leave Form</a></li> 
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'out_f' ? 'active2' : 'null'); }?> href="index.php?request=out_of_office&link=leave&link2=out_f"><i class="fa fa-sign-out"></i> Out of Office Form</a></li> 
<li style="margin-left:4px; font-size:13px; color:#C0C;">Requests Feedback</li> 
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'lv_fb' ? 'active2' : 'null'); }?> href="index.php?request=feed_back&link=leave&link2=lv_fb"><span class="badge pull-right"></span><i class="fa fa-pencil-square-o"></i> Leave Activity Feedback</a></li> 
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'out_fb' ? 'active2' : 'null'); }?> href="index.php?request=out_office_feedback&link=leave&link2=out_fb"><span class="badge pull-right"></span><i class="fa fa-share"></i> Out of office Feedback</a></li>
</li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">Supervisor Requests</li> 
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'sup_req' ? 'active2' : 'null'); }?> href="index.php?request=supervis_req&link=leave&link2=sup_req"><span class="badge pull-right"><?php if($num4==0){echo '';}else echo $num4;  ?></span><i class="fa fa-check-circle"></i> Extra work day requests</a></li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">Summary</li>
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'hist' ? 'active2' : 'null'); }?> href="index.php?request=leave_history&link=leave&link2=hist"><i class="fa fa-history"></i> History</a></li>

<!-- SUPERVISOR SECTION-->
<li class="nav-header" style=" color:#17AE2B;font-size: 13px;font-weight: 700; margin-left:3px">SUPERVISOR</li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">Review Staff Requests</li>
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'rev_lv' ? 'active2' : 'null'); }?> href="index.php?request=leave_requests&link=leave&link2=rev_lv&yr=2018"><span class="badge pull-right"><?php if($this->num==0){echo '';}else echo $this->num;  ?></span><i class="fa fa-check-square-o"></i> Review Leave Requests</a></li>
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'rev_out' ? 'active2' : 'null'); }?> href="index.php?request=out_office_requests&link=leave&link2=rev_out"><span class="badge pull-right"><?php if($num2==0){echo '';}else echo $num2;  ?></span><i class="fa fa-check-circle"></i> Review Out of office requests</a></li>
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'rev_res' ? 'active2' : 'null'); }?> href="index.php?request=resumption_yrs&link=leave&link2=rev_res"><span class="badge pull-right"><?php if($num3==0){echo '';}else echo $num3;  ?></span><i class="fa fa-check-circle"></i> Review leave recall requests</a></li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">Request extra work day</li>
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'req_day' ? 'active2' : 'null'); }?> href="index.php?request=xtra_day_form&link=leave&link2=req_day"><i class="fa fa-indent"></i> Extra work day form</a></li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">View Subordinate</li>
<li><a <?php   if(isset($_GET['link2'])){echo "class=".($_GET['link2'] == 'v_stf' ? 'active2' : 'null'); }?> href="index.php?request=view_staff&link=leave&link2=v_stf"><i class="fa fa-users"></i> View staff</a></li>
<li class="nav-header" style=" color:#17AE2B;font-size: 13px;font-weight: 700; margin-left:3px">DOCUMENTATION</li>
<li style="margin-left:4px; font-size:13px; color:#C0C;">Usage SOP</li>
<li><a href="../../docs/leave_mngt_sys_SOP.pdf" target="_blank"><i style="color:#F00" class="fa fa-file-pdf-o"></i> Leave and Out of office SOP</a></li>

 