<?php if (!isset($_SESSION['username'])) {
header('Location: index.php');
} ?>
<!DOCTYPE html>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo TAB_TITLE; ?></title>
<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css" />
<link href="/lib/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css"  rel="stylesheet" />

<link href="./lib/multi_date/css/jquery-ui.css"  rel="stylesheet" />
<link href="./lib/multi_date/css/jquery-ui.structure.css"  rel="stylesheet" />

<link rel="stylesheet" href="css/css.css" />
<link rel="stylesheet" href="/lib/font-awesome-4.1.0/font-awesome-4.1.0/css/font-awesome.css" />
<link rel="stylesheet" href="/lib/chosen_v1.1.0/chosen.css"  />
<link rel="stylesheet" href="/lib/jquery.qtip.custom/jquery.qtip.min.css"  />
<script type='text/javascript' src="/lib/bootstrap/js/modernizr.custom.js"></script>
  <script type='text/javascript' src="/lib/bootstrap/js/css3-mediaqueries.js"></script>
<!--[if lt IE 9]>
<script src="/lib/html5shiv-master/src/html5shiv.js"></script> 
<script src="/lib/bootstrap/js/respond.min.js"></script>
<![endif]-->
</head>

<body>
<?php require('templates/en_US/header.php');   ?> 
<div class="container bs-docs-container">
<?php require('templates/en_US/main_frame.php'); ?>	

</div>
<div class="container-fluid">
<?php include('templates/en_US/footer.php');  ?> 
</div>
<script src=".//lib/jquery-1.12.0.min.js"></script>
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="/lib/jquery.qtip.custom/jquery.qtip.min.js" ></script>

 <script src="/lib/bootstrap-datetimepicker-master/src/js/moment.min.js"></script> 
<script src="/lib/bootstrap-datetimepicker-master/src/js/bootstrap-datetimepicker.js"></script>

<script src=".//lib/multi_date/js/jquery-ui-1.11.1.js"></script>

<script src=".//lib/multi_date/jquery-ui.multidatespicker.js"></script>

<script src="/lib/chosen_v1.1.0/chosen.jquery.js" type="text/javascript"></script>
<script src="/lib/chosen_v1.1.0/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">

</script>
    <script type="text/javascript">
	var disabled_dates = <?php echo json_encode($pub_days ); ?>;
var d = new Date();
var month = <?php  echo date('m'); ?>;
var day = <?php  echo date('d'); ?>;
var year = <?php  echo date('Y') ?>;

$(function() {
    $('#checkboxOne, #checkboxTwo').click(function() {
        var cb1 = $('#checkboxOne').is(':checked');
        var cb2 = $('#checkboxTwo').is(':checked');
        $('#btn3, #comt').prop('disabled', !(cb1 || cb2));
        $('#from, #leave_id2, #to').prop('disabled', !cb1);
        $('#pub_hol3, #day').prop('disabled', !cb2);    
    });
});
            $(function () {
                $('#datetimepicker1').datetimepicker({
					daysOfWeekDisabled:[0,6],
		            format: 'MM/DD/YYYY HH:mm',
                    pickDate: true,
                    pickSeconds: false,
					autoClose: true,
                    pick12HourFormat: false,
					disabledDates: disabled_dates,
					defaultDate: month+"/"+day+"/"+year
					});
            });
			   $(function () {
                $('#datetimepicker2').datetimepicker({
					daysOfWeekDisabled:[0,6],
		            format: 'MM/DD/YYYY HH:mm',
                    pickDate: true,
                    pickSeconds: false,
					autoClose: true,
                    pick12HourFormat: false,
					disabledDates: disabled_dates,
					defaultDate: month+"/"+day+"/"+year
					});
            });
			
        </script>
  <script type="text/javascript">

function daysDisabled(date) {
    for (var i = 0; i < disabled_dates.length; i++) {
        if (new Date(disabled_dates[i]).toString() == date.toString()) {
           return false;
        }
    }
    return true;
}
            $(function () {
     $('#datepicker').datepicker({
         format: 'mm/dd/yyyy',
    startDate: '01/01/1900',
	autoclose: true,
	todayHighlight: true,
	todayBtn: "linked",
	daysOfWeekDisabled: "0,6",
beforeShowDay: daysDisabled
});
				
            });
			   $(function () {
     $('#datepickers').datepicker({
         format: 'mm/dd/yyyy',
    startDate: '01/01/1900',
	autoclose: true,
	todayHighlight: true,
	todayBtn: "linked",
	daysOfWeekDisabled: "0,6",
beforeShowDay: daysDisabled
});
				
            });
        </script>
    
         <script type="text/javascript">
    var config = {
      '#chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	    var config = {
      '#chosen-select1'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
   <script type="text/javascript">
	$('#from-input').multiDatesPicker();
	$('#schedule').multiDatesPicker({
		altField: '#altField',
		maxPicks: 16,
		numberOfMonths: [3,4],
		beforeShowDay: $.datepicker.noWeekends,
		addDisabledDates: disabled_dates
		});
		  </script>
 <script type="text/javascript">
			var s_dates1 = <?php  echo '['.$pre_date.']'; ?>;
			//var dates12 = ['01/08/2016','01/12/2016'];
			//alert(s_dates1);
	$('#schedule3').multiDatesPicker({
		altField: '#altField3',
		maxPicks: 16,
		numberOfMonths: [3,4],
		beforeShowDay: $.datepicker.noWeekends,
		addDisabledDates: disabled_dates,
		addDates: s_dates1
		});
  </script>
</body>
</html>