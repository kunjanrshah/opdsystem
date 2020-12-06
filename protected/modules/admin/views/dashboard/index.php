<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php 
	
	
	$this->renderPartial("/layouts/_message"); ?>
    <?php
        if(!$this->isPatient):
            $this->renderPartial("application.modules.admin.views.patients._search", array("model" => new Patients())); 
        endif;
    ?>
    <div class="row">
        <!-- START Left Side -->
        <div class="col-md-12">
            <?php $this->renderPartial("_todays_appointments"); ?>
        </div>
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->