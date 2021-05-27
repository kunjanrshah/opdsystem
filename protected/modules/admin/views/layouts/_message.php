<div id="flash-message">
    <?php
    foreach (Yii::app()->user->getFlashes() as $class => $message) {
        echo common::getMessage($class, $message) . "\n";
    }
    ?>
</div>
<div class="indicator" id="ajaxLoader"><span class="spinner spinner7"></span></div>
    <?php
    Yii::app()->clientScript->registerScript(
            'myHideEffect', 'setInterval(function(){ 
                if($(".alert").is(":visible")) {
                    $(".alert").animate({opacity: 1.0}, 5000).fadeOut("slow");
                }
             }, 1000)', CClientScript::POS_READY
    );
    ?>
<script>
//    $('#ajaxLoader').bind('ajaxStart', function () {
//        $(this).addClass("show");
//    }).bind('ajaxStop', function () {
//        $(this).removeClass("show");
//    });
</script>