<!DOCTYPE html>
<html  class="<?php echo (Yii::app()->session['menu_view']) ? "sidebar-minimized" : ""; ?>">
    <!-- START Head -->
    <head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="image/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="image/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="image/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="image/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="image/touch/apple-touch-icon.png">
        <!--/ END META SECTION -->

        <!-- START STYLESHEETS -->
        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>stylesheet/style.css">    
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>stylesheet/layout.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>stylesheet/uielement.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/datatables/css/jquery.datatables.min.css">
        <!--/ Application stylesheet -->
        <!-- END STYLESHEETS -->        
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/selectize/css/selectize.min.css">        
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/jqueryui/css/jquery-ui.min.css">
        <link rel="stylesheet" href="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/gritter/css/jquery.gritter.min.css">
        <!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
        <script src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/modernizr/js/modernizr.min.js"></script>
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
        <?php echo $content; ?>
        <!-- START To Top Scroller -->
        <a href="#" class="totop animation" data-toggle="waypoints totop" data-marker="#main" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="-50%"><i class="ico-angle-up"></i></a>
        <!--/ END To Top Scroller -->
        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Library script : mandatory -->
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>library/core/js/core.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>javascript/app.min.js"></script>
        <!--<script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/jqueryui/js/jquery-ui.min.js"></script>-->
        <script type="text/javascript" src="<?php echo Yii::app()->params->ADMIN_BT_URL; ?>plugins/gritter/js/jquery.gritter.min.js"></script>
        <!--/ Library script -->
        <!--/ END JAVASCRIPT SECTION -->
        <script>
            $('.numeric').live("keypress", function (event) {
                if ((event.which != 46 || $(this).val().indexOf('.') != -1) && event.which != 0 && event.which != 8 && (event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
            });/*
            function doAjax() {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl("/common/notify", array("id" => Yii::app()->user->id)); ?>",
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {
                        if (response.length > 0) {
                            $.each(response, function (index, item) {
                                $.gritter.add({
                                    title: item.title,
                                    text: item.text,
                                    sticky: true,
                                });
                            });
                        }
                    },
                    global: false,  
                    complete: function () {
                        setTimeout(doAjax, 1000);
                    }
                });
            }
            doAjax();
*/
$(document).ready(function(){		
    notificationcall();
	appointmentcall();
});
function notificationcall(){
    $.ajax({
   url: '<?php echo Yii::app()->createUrl('admin/notifications/getlivenotification');?>',
   type: 'GET',
   success: function(data) {
       data = JSON.parse(data);
      $("#notificationCount").text(data.count);      
   }
   
});
setTimeout(notificationcall, 10000);
}
function appointmentcall(){
   var count = parseInt($("#notificationCountAppointment").text());	
   var page = "<?php echo Yii::app()->urlManager->parseUrl(Yii::app()->request);?>";
   $.ajax({
   url: '<?php echo Yii::app()->createUrl('admin/notifications/getlivenotification');?>',
   type: 'POST',
   data: {page: page},
   success: function(data) {
       data = JSON.parse(data);
	   if(Number(count) != Number(data.count)){		   
		$("#notificationCountAppointment").text(data.count);
		if(data.page == true)
			location.reload();
	   }
   }
   
});
setTimeout(appointmentcall, 10000);
}
        </script>
		<style>
			.pagination li.selected a {
			  background-color: #f5f5f5;
			  border-color: #c9d4d7;
			  color: #00a5d2;
			}
		</style>
    </body>
    <!--/ END Body -->
</html>