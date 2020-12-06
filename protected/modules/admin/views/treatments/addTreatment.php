<div class="panel-heading">
    <h5 class="panel-title">
        Patient Name : <?php
        $Patients = Patients::model()->findByPk($model->patient_id);
        echo $Patients->patient_name."<br>";
        echo $Patients->address1.",<br>";
        echo $Patients->address2.",";
        echo $Patients->city."<br>";
        $contact2 = !empty($Patients->contact_number2)?",".$Patients->contact_number2:"";
        echo "Contact #  : ".$Patients->contact_number.$contact2."<br>Email  : ".CHtml::Link($Patients->email_address,"mailto:".$Patients->email_address);
        ?>
    </h5>
</div>
<div class="panel panel-default">
    <!-- panel heading/header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo common::getTitle("treatments/add"); ?></h3>
    </div>
    <!--/ panel heading/header -->
    <!-- panel body -->
    <div class="panel-body">
        <?php $this->renderPartial("_form_treatment", array("model" => $model)); ?>
    </div>
    <!-- panel body -->
</div>
