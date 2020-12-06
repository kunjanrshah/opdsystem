<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("companies/update") : common::getTitle("companies/add"); ?></h4>
            </div>

            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-company',
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

                    <div class="col-md-4 hide">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'address1', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'address1', array('class' => 'form-control',"value"=>"Not available.")); ?>
                            <?php echo $form->error($model, 'address1', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4 hide">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'address2', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'address2', array('class' => 'form-control',"value"=>"Not available.")); ?>
                            <?php echo $form->error($model, 'address2', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4 hide">
                        <div class="form-group">
                            <?php $model->country_id = Countries::DEFAULT_COUNTRY; ?>
                            <?php echo $form->labelEx($model, 'country_id', array('class' => 'control-label')); ?>
                             <?php echo common::select2($model,"country_id",CHtml::ListData(Countries::model()->getCountries(),'id',"country"),array("prompt"=>common::translateText("DROPDOWN_TEXT"),"class"=>"form-control",
                            'ajax' =>
                                array('type'=>'POST',
                                    'url'=>$this->createUrl('common/getstates'), //url to call.
                                    'update'=>'#CompanyMaster_state_id', //selector to update
                                    'data'=>array('id'=>'js:this.value'),
                                )
                            ));?>  
                            <?php echo $form->error($model, 'country_id', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4 hide">
                        <div class="form-group">
                            <?php $model->state_id = States::DEFAULT_STATE; ?>
                            <?php echo $form->labelEx($model, 'state_id', array('class' => 'control-label')); ?>
                            <?php echo common::select2($model,"state_id",CHtml::ListData(States::model()->getStates($model->country_id),"id","name"),array("prompt"=>common::translateText("DROPDOWN_TEXT"),"class"=>"form-control"));?>  
                            <?php echo $form->error($model, 'state_id', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4 hide">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'city', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'city', array('class' => 'form-control','value'=>'Not Available.')); ?>
                            <?php echo $form->error($model, 'city', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4 ">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'phone_number', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'phone_number', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'phone_number', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4 hide">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'email_address', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'email_address', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'email_address', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'contact_person', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'contact_person', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'contact_person', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>
                    <!-- User Group Info  --> 

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-company').submit();">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->