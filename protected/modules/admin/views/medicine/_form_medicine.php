<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("medicine/update") : common::getTitle("medicine/add"); ?></h4>
            </div>

            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-medicine',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    )
                ));
                ?>
                <!-- User Group Info  -->
                <div class="row nm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "medicine_name", array("class" => "control-label")); ?>
                            <?php echo $form->textField($model, "medicine_name", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "medicine_name", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "company_id", array("class" => "control-label")); ?>
                            <?php echo common::select2($model, "company_id", CHtml::ListData(CompanyMaster::model()->getCompanies(), 'id', 'company_name'), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>
                            <?php echo $form->error($model, "company_id", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>
                </div>    
                <div class="row nm">
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "drug_id", array("class" => "control-label")); ?>
                            <?php echo common::select2($model, "drug_id", CHtml::ListData(DrugsMaster::model()->getDrugs(), 'id', 'drug_name'), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>
                            <?php echo $form->error($model, "drug_id", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>      
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "stock", array("class" => "control-label")); ?>
                            <?php echo $form->textField($model, "stock", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "stock", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "is_internal", array("class" => "control-label")); ?>
                            <?php echo common::select2($model, "is_internal", $model->isInternalArr, array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "is_internal", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>    
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "is_vaccine", array("class" => "control-label")); ?>
                            <?php echo common::select2($model, "is_vaccine", array(0 => "No", 1 => "Yes"), array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "is_vaccine", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>
                </div>
                <!-- User Group Info  -->                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-medicine').submit();"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->