<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
            <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;Family Tree of <?php echo $patient->patient_name;?></span>  
                        </div>
                    </div>
                </div>
                 <div style="padding:10px;">
                        <?php if(!empty($model)) {
                                foreach($model as $value) {
                                    ?>
                                        <div>
                                            <?php echo $value->patient_name ?>
                                            <?php echo $value->relationArr[$value->relation] ?>
                                        </div>
                                    <?php
                                }     
                            } else {  ?> No family tree found. <?php } ?>
                    </div>
                </div>
            </div> 
        </div>      
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->