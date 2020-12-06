<div class="panel-heading">
    <h5 class="panel-title">
        Patient Name : <?php
        $Patients = Patients::model()->findByPk($model->patient_id);
        echo $Patients->patient_name;
        ?>
    </h5>
</div>
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo common::getTitle("treatments/update"); ?></h3>
                </div>
                <!--/ panel heading/header -->
                <!-- panel body -->
                <div class="panel-body">
                    <?php $this->renderPartial("_form_treatment", array("model" => $model)); ?>
                </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->
        </div>
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->