<div class="page-header page-header-block">
    <div class="page-header-section">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'search-form',
            'method' => 'get',
            'action' => array("patients/index"),
            'clientOptions' => array('validateOnSubmit' => true)
        ));
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-2">
                    <?php echo common::select2($model, "id", Patients::model()->getPatientsList(), array("prompt" => "Patients", "class" => "chzn-select", "style" => "width:100%;")); ?>
                </div>
                <div class="col-xs-2">
                    <?php echo common::select2($model, "family_id", CHtml::ListData(Patients::model()->getFamilyHead(), "id", "patient_name_with_id"), array("prompt" => $model->getAttributeLabel("family_id"), "class" => "chzn-select", "style" => "width:100%;")); ?>
                </div>
                <div class="col-xs-2">
                    <?php echo common::select2($model, "blood_group", $model->bloodGroupArr, array("prompt" => $model->getAttributeLabel("blood_group"), "style" => "width:100%;")); ?>
                </div>  
                <div class="col-xs-2">
                    <?php echo $form->textField($model, "address2", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address2"))); ?> 
                </div>
                <div class="col-xs-2">
                    <?php echo $form->textField($model, "city", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("city"))); ?> 
                </div>   
                <div class="col-xs-2">
                    <?php echo $form->textField($model, "contact_number", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("contact_number"))); ?> 
                </div>                        
            </div></div>
        <div class="row text-center">
            <br>
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary"><i class="ico-loop4 mr5"></i><?php echo common::translateText("SEARCH_BTN_PATIENT_TEXT"); ?></button>
                <?php if (common::checkActionAccess("patients/add")) : ?>
                    <a href="<?php echo Yii::app()->createUrl("/admin/patients/add") ?>"><button type="button" class="btn btn-primary"><i class="ico-plus mr5"></i><?php echo common::getTitle("patients/add"); ?></button></a>
                        <?php endif; ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>