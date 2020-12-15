<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("family/update") : common::getTitle("family/add"); ?></h4>
            </div>

            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-family',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    )
                ));
                ?>
                <div class="row nm">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'family_name', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'family_name', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'family_name', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'address1', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'address1', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'address1', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'address2', array('class' => 'control-label')); ?>
                            <?php echo $form->dropdownList($model, "address2", CHtml::ListData(AreaMaster::model()->findAll(), "id", "area_name"), array("class" => "form-control", "prompt" => "Select Area")); ?>
                            <?php echo $form->error($model, 'address2', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>      
                </div>
                <div class="row nm">
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'city', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'city', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'city', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'contact_number', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'contact_number', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'contact_number', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'email_address', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'email_address', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'email_address', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>      
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-family').submit();">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>