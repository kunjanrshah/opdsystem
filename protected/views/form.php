<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i>Title</h4>
            </div>

            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-company-master',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    )
                ));
                ?>
                <!-- User Group Info  -->
                <div class="row nm">

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'company_name', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'company_name', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'company_name', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'address1', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'address1', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'address1', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'address2', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'address2', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'address2', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'country_id', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'country_id', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'state_id', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'state_id', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'state_id', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'city', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'city', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'city', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'phone_number', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'phone_number', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'phone_number', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'email_address', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'email_address', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'email_address', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'website', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'website', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'website', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'deleted', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'deleted', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'deleted', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'created_dt', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'created_dt', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'created_dt', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'created_by', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'created_by', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'created_by', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'updated_dt', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'updated_dt', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'updated_dt', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'updated_by', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'updated_by', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'updated_by', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-medicine').submit();">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->