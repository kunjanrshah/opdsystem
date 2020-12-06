<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">Patient Registration</h3>
                </div>
                <!--/ panel heading/header -->
                <!-- panel body -->
                <div class="panel-body">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'form-patient',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                            'validateOnSubmit' => true
                        ), 'htmlOptions' => array('enctype' => 'multipart/form-data')));
                    echo $form->hiddenField($model, "user_group");
                    echo $form->hiddenField($model, "country_id");
                    echo $form->hiddenField($model, "state_id");
                    echo $form->hiddenField($model, "status");
                    ?>
                    <div class="row nm">
                        <h5 class="semibold mb15">Personal Info:</h5>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "id", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "id", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("id"))); ?>
                                    <i class="ico-user2 form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "id", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "registration_date", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php common::getDatePicker($model, "registration_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("registration_date"))); ?>
                                    <i class="ico-calendar5 form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "registration_date", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "birth_date", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php
                                    common::getDatePicker($model, "birth_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("birth_date"),
                                        "ajax" => array(
                                            "url" => Yii::app()->createUrl("/common/getagefromdate"),
                                            "type" => "POST",
                                            "dataType" => "JSON",
                                            "data" => array("date" => "js:this.value"),
                                            "success" => "js:function(response){
                                                var years = response.years;
                                                var months = response.months;
                                                var days = response.days;
                                                $('#Patients_patient_age_years').val(years);
                                                $('#Patients_patient_age_months').val(months);
                                                $('#Patients_patient_age_days').val(days);
                                            }"
                                        )
                                    ));
                                    ?>
                                    <i class="ico-calendar5 form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "birth_date", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "patient_age", array("class" => "control-label", "readonly" => true, "style" => "margin-left:4%;")); ?>
                                <div class="has-icon pull-left">                              
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model, "patient_age_years", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("patient_age_years"))); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model, "patient_age_months", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("patient_age_months"))); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo $form->textField($model, "patient_age_days", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("patient_age_days"))); ?>
                                    </div>
                                </div>
                                <?php echo $form->error($model, "patient_age", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row nm">
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "patient_name", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "patient_name", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_name"))); ?>
                                    <i class="ico-user2 form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "patient_name", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "family_id", array("class" => "control-label")); ?>
                                <?php echo common::select2($model, "family_id", CHtml::ListData(FamilyMaster::model()->getFamilies(), "id", "family_name"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
                                <?php echo $form->error($model, "family_id", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "relation", array("class" => "control-label")); ?>            
                                <?php echo common::select2($model, "relation", $model->relationArr, array("class" => "form-control", "prompt" => common::translateText("DROPDOWN_TEXT"))); ?>
                                <?php echo $form->error($model, "relation", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "gender", array("class" => "control-label")); ?>
                                <?php echo common::select2($model, "gender", Users::model()->genderArr, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
                                <?php echo $form->error($model, "gender", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "blood_group", array("class" => "control-label")); ?>            
                                <?php echo common::select2($model, "blood_group", $model->bloodGroupArr, array("class" => "form-control", "prompt" => $model->getAttributeLabel("blood_group"))); ?>
                                <?php echo $form->error($model, "blood_group", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "reference_by", array("class" => "control-label")); ?>            
                                <?php echo common::select2($model, "reference_by", CHtml::ListData(ReferencesMaster::model()->findAll(), "id", "reference_name"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>                 
                                <?php echo $form->error($model, "reference_by", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>

                    </div>
                    <!--/ Personal Info  -->
                    <hr>
                    <!-- Contact Info  -->
                    <div class="row nm">
                        <h5 class="semibold mb15">Contact Information</h5>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "address1", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "address1", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address1"))); ?>
                                    <i class="ico-map-marker form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "address1", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "address2", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "address2", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address2"))); ?>
                                    <i class="ico-map-marker form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "address2", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "city", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "city", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("city"))); ?>
                                    <i class="ico-office form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "city", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "email_address", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "email_address", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("email_address"))); ?>
                                    <i class="ico-envelop form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "email_address", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "contact_number", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "contact_number", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("contact_number"))); ?>
                                    <i class="ico-phone2 form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "contact_number", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                    </div>
                    <!--/ Contact Info  -->    
                    <hr>
                    <!-- Security  -->
                    <div class="row nm">
                        <h5 class="semibold mb15">Security:</h5>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "username", array("class" => "control-label")); ?>
                                <?php echo $form->textField($model, "username", array("class" => "form-control")); ?>
                                <?php echo $form->error($model, "username", array("class" => "parsley-custom-error-message")); ?>                                       
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "password", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->passwordField($model, "password", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("password"))); ?>
                                    <i class="ico-key2 form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "password", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "repeat_password", array("class" => "control-label", "placeholder" => $model->getAttributeLabel("repeat_password"))); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->passwordField($model, "repeat_password", array("class" => "form-control")); ?>
                                    <i class="ico-asterisk form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "repeat_password", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                    </div>
                    <!--/ Security  -->
                    <hr>
                    <!-- Photo  -->
                    <div class="row nm">
                        <h5 class="semibold mb15">Patient Photo:</h5>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div>
                                    <div class="btn-group pr5">
                                        <?php $model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : common::translateText("NOT_AVAILABLE_TEXT"); ?>
                                        <img width="70px" alt="" src="<?php echo Patients::model()->getProfilePicture($model->profile_pic, $model->id); ?>" class="img-circle img-bordered">
                                    </div>
                                    <div class="btn-group">
                                        <?php echo $form->fileField($model, "profile_pic"); ?>
                                        <?php echo $form->error($model, "profile_pic", array("class" => "parsley-custom-error-message")); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                  
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
                    </div>
                    <?php
                    $this->endWidget();
                    ?>
                    <hr>
                    <p class="text-muted text-center">Do you want to register as a patient ? 
                        <?php echo CHtml::Link("Already have an account?", array("/admin/login"), array("class" => "semibold")); ?>
                    </p>
                </div>
                <!-- panel body -->
            </div>
            <!--/ END form panel -->
        </div>
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->


