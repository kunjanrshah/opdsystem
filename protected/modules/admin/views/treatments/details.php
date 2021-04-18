<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="tab-content panel" style="padding:10px;">
                    Patient Name : <?php
                    $Patients = Patients::model()->findByPk($model->patient_id);
                    echo $Patients->patient_name . "<br>";
                    echo $Patients->address1 . ",<br>";
                    echo $Patients->AreaRel->area_name . ", ".$Patients->city . "<br>";
                    $contact2 = !empty($Patients->contact_number2) ? "," . $Patients->contact_number2 : "";
                    echo "Contact #  : " . $Patients->contact_number . $contact2 . "<br>Email  : " . CHtml::Link($Patients->email_address, "mailto:" . $Patients->email_address);
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tab-content panel" style="padding:10px;">
                    <?php
                        echo "<b>Allergy : </b> ";
                        echo AllergyMaster::model()->getCSV($Patients->allergy);
                        echo "<br >";
                        echo "<b>Known Cases : </b>";
                        echo AllergyMaster::model()->getCSV($Patients->other_case);
                        echo "<br >";
                        echo "<b>Regular Medicine : </b>";
                        echo RMedicineMaster::model()->getCSV(@$Patients->regular_medicine);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <?php $active1 = empty($id) ? " active" : ""; ?>
            <?php $active2 = !empty($id) ? " active" : ""; ?>
            <ul class="nav nav-tabs">
                <?php if (empty($id)) { ?>
                    <li class="<?php echo $active1; ?>"><a data-toggle="tab" href="#popular">Treatment</a></li>
                <?php } ?>
                <li class="<?php echo $active2; ?>"><a data-toggle="tab" href="#comments">Treatment Histories</a></li>
            </ul>
            <div class="tab-content panel"> 
                <?php if (empty($id)) { ?>
                    <div id="popular" class="tab-pane <?php echo $active1; ?>">
                        <?php $this->renderPartial("_form_treatment", array("model" => $model)); ?>
                    </div>
                <?php } ?>
                <div id="comments" class="tab-pane <?php echo $active2; ?>">
                    <?php $this->renderPartial("_treatment_histories", array("model" => $model, "id" => $id)); ?>
                </div>
            </div>
        </div>
    </div>
</div>