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
                <?php echo $form->textField($model, "registration_date", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("registration_date"))); ?>
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
                        ),array('yearRange' => '2005:2099',"maxDate" => 0));
                ?>
                <i class="ico-calendar5 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "birth_date", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="has-icon pull-left">                              
                <div class="col-md-4">
                    <label class="control-label">Year</label>
                    <?php echo $form->textField($model, "patient_age_years", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("patient_age_years"))); ?>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Month</label>
                    <?php echo $form->textField($model, "patient_age_months", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("patient_age_months"))); ?>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Days</label>
                    <?php echo $form->textField($model, "patient_age_days", array("class" => "form-control", "readonly" => true, "placeholder" => $model->getAttributeLabel("patient_age_days"))); ?>
                </div>
            </div>
            <?php echo $form->error($model, "patient_age", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-5">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_name", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "patient_name", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_name"))); ?>
                <i class="ico-user2 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "patient_name", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "family_id", array("class" => "control-label")); ?>
			<?php if (common::checkActionAccess("family/add")): ?>
                <div class="pull-right">
                    <a data-id="#Patients_regular_medicine" href="<?php echo Yii::app()->createUrl("/admin/family/add") ?>" title="Add Medicine" class="pull-left btn-sm btn-default plus-box" id="addMedicine">
                        Add <i class="ico-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
                <?php
            endif;
            ?>
            <?php
            $selectFamilyHeadValue = '';
            if($model->family_id){
            $criteria = new CDbCriteria();
            $criteria->compare("id", $model->family_id);
            $selectFamilyHeadValue = Patients::model()->find($criteria);
            }
                         echo $form->hiddenField($model, 'family_id');
                         $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'selectFamilyHeadValue',
                            'value' => $selectFamilyHeadValue->patient_name_with_id,
                            'source' => CController::createUrl('patients/familyheaddropdown'),
                            'options' => array(
                                'html'=>true,
                                'showAnim' => 'fold',
                                'minLength' => '1',
                                'search' => 'js:function( event, ui ) { $("#Patients_family_id").val(null); }',
                                'select' => 'js:function( event, ui ) {
                                $("#selectFamilyHeadValue").val( ui.item.label );
                                $("#Patients_family_id").val( ui.item.value );
                                $.ajax({
                                   url: "'.CController::createUrl('/common/getPatient').'",
                                   dataType: "json",
                                   type: "POST",
                                   data: {
                                           Patients: {family_id:ui.item.value},
                                   },
                                   success: function (response) {
                                                 if(response.address1){
                                                    $("#Patients_address1").val(response.address1);
                                                 }
                                                 if(response.address2){
                                                    $("#Patients_address2").select2("destroy");
                                                    $("#Patients_address2").val(response.address2);
                                                    $("#Patients_address2").select2();
                                                 }
                                                 if(response.city){
                                                    $("#Patients_city").val(response.city);
                                                 }
                                                 if(response.email_address){
                                                    $("#Patients_email_address").val(response.email_address);
                                                 }
                                                 if(response.contact_number){
                                                     $("#Patients_contact_number").val(response.contact_number)
                                                 }
                                                 if(response.contact_number2){
                                                     $("#Patients_contact_number2").val(response.contact_number2)
                                                 }
                                   }
                                })
                                return false;
                                }',
                            ),
//                             'close' => 'js:function( event, ui ) { $("#selectFamilyHeadValue").val(null); }',
                            'htmlOptions' => array(
//                                'onfocus' => 'js: this.value = null; $("#searchbox").val(null); $("#selectedvalue").val(null);',
                                'onblur' => 'js: if(!$("#Patients_family_id").val()){ $("#selectFamilyHeadValue").val(null); }',
                                'class' => 'form-control',
                                'placeholder' => "Search Family Head ...",
                                'autocomplete'=>'off'
                            ),
                        ));
                        ?>
            <?php
//            echo common::select2($model, 'family_id', CHtml::ListData(Patients::model()->getFamilyHead(), "id", "patient_name_with_id"), array(
//                'prompt' => 'Own', "class" => "form-control",
//                'ajax' => array('type' => 'POST', 'dataType' => 'JSON',
//                    'url' => CController::createUrl('/common/getPatient'),
//                    'success' => 'function(response){
//                        if(response.address1){
//                           $("#Patients_address1").val(response.address1);
//                        }
//                        if(response.address2){
//                           $("#Patients_address2").select2("destroy");
//                           $("#Patients_address2").val(response.address2);
//                           $("#Patients_address2").select2();
//                        }
//                        if(response.city){
//                           $("#Patients_city").val(response.city);
//                        }
//                        if(response.email_address){
//                           $("#Patients_email_address").val(response.email_address);
//                        }
//                        if(response.contact_number){
//                            $("#Patients_contact_number").val(response.contact_number)
//                        }
//                        if(response.contact_number2){
//                            $("#Patients_contact_number2").val(response.contact_number2)
//                        }
//                     }'
//            )));
            ?>  
            <?php echo $form->error($model, "family_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "relation", array("class" => "control-label")); ?>            
            <?php echo common::select2($model, "relation", $model->relationArr, array("class" => "form-control", "prompt" => common::translateText("DROPDOWN_TEXT"))); ?>
            <?php echo $form->error($model, "relation", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-3">
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
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "reference_by", array("class" => "control-label pull-left")); ?>
            <?php if (common::checkActionAccess("references/add")): ?>
                <div class="pull-right">
                    <a data-id="#Patients_reference_by" href="<?php echo Yii::app()->createUrl("/admin/references/add") ?>" title="Add Reference" class="pull-left btn-sm btn-default plus-box" id="addReference">
                        Add <i class="ico-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            <?php endif; ?>
            <?php echo common::select2($model, "reference_by", CHtml::ListData(ReferencesMaster::model()->findAll(), "id", "ref_name_with_contact"), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>                 
            <?php echo $form->error($model, "reference_by", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group custom-select-class">
            <?php echo $form->labelEx($model, "regular_medicine", array("class" => "control-label")); ?>
            <?php if (common::checkActionAccess("rmedicine/add")): ?>
                <div class="pull-right">
                    <a data-id="#Patients_regular_medicine" href="<?php echo Yii::app()->createUrl("/admin/rmedicine/add") ?>" title="Add Medicine" class="pull-left btn-sm btn-default plus-box" id="addMedicine">
                        Add <i class="ico-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
                <?php
            endif;
            ?>
            <?php echo common::select2($model, "regular_medicine", CHtml::ListData(RMedicineMaster::model()->findAll(), "id", "title"), array("class" => "form-control", "multiple" => true));
            ?>
            <?php echo $form->error($model, "regular_medicine", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    
    <div class="col-md-3">
        <div class="form-group custom-select-class">
            <?php echo $form->labelEx($model, "allergy", array("class" => "control-label")); ?>
            <?php if (common::checkActionAccess("allergies/add")): ?>
                <div class="pull-right">
                    <a data-id="#Patients_allergy" href="<?php echo Yii::app()->createUrl("/admin/allergies/add") ?>" title="Add Allergy" class="pull-left btn-sm btn-default plus-box" id="addAllergy">
                        Add <i class="ico-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            <?php endif; ?>
            <?php echo common::select2($model, "allergy", CHtml::ListData(AllergyMaster::model()->findAll(), "id", "title"), array("class" => "form-control", "multiple" => true)); ?>
            <?php echo $form->error($model, "allergy", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group custom-select-class">
            <?php echo $form->labelEx($model, "other_case", array("class" => "control-label")); ?>
            <?php if (common::checkActionAccess("cases/add")): ?>
                <div class="pull-right">
                    <a data-id="#Patients_other_case" href="<?php echo Yii::app()->createUrl("/admin/cases/add") ?>" title="Add Case" class="pull-left btn-sm btn-default plus-box" id="addCase">
                        Add <i class="ico-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            <?php endif; ?>
            <?php echo common::select2($model, "other_case", CHtml::ListData(CaseMaster::model()->findAll(), "id", "title"), array("class" => "form-control", "multiple" => true)); ?>
            <?php echo $form->error($model, "other_case", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
<!--    <div class="col-md-3">
        <div class="form-group">
            <div>
                <div class="btn-group pr5">
                    <?php //$model->profile_pic = !empty($model->profile_pic) ? $model->profile_pic : common::translateText("NOT_AVAILABLE_TEXT"); ?>
                    <img width="60" height="60" alt="Profile Picture" src="<?php //echo Patients::model()->getProfilePicture($model->profile_pic, $model->id); ?>" class="img-circle img-bordered" id="profPic">
                </div>
                <div class="btn-group">
                    <?php //echo $form->fileField($model, "profile_pic"); ?>
                    <?php //echo $form->error($model, "profile_pic", array("class" => "parsley-custom-error-message")); ?>
                </div>
            </div>
        </div>
    </div>-->
</div>
<div class="row nm">
    <h5 class="semibold mb15">Contact Information</h5>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "address1", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "address1", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address1"))); ?>
                <i class="ico-map-marker form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "address1", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "address2", array("class" => "control-label")); ?>
            <?php if (common::checkActionAccess("area/add")): ?>
                <div class="pull-right">
                    <a data-id="#Patients_address2" href="<?php echo Yii::app()->createUrl("/admin/area/add") ?>" title="Add Area" class="pull-left btn-sm btn-default plus-box" id="addArea">
                        Add <i class="ico-plus"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
            <?php endif; ?>
            <?php echo common::select2($model, "address2", CHtml::ListData(AreaMaster::model()->findAll(), "id", "area_name"), array("class" => "form-control", "prompt" => "Select Area")); ?>
            <?php echo $form->error($model, "address2", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-3">
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
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "contact_number", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "contact_number", array("class" => "numeric form-control", "placeholder" => $model->getAttributeLabel("contact_number"))); ?>
                <i class="ico-phone2 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "contact_number", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "contact_number2", array("class" => "numeric control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "contact_number2", array("class" => "numeric form-control", "placeholder" => $model->getAttributeLabel("contact_number2"))); ?>
                <i class="ico-phone2 form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "contact_number2", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<!--/ Contact Info  -->    
<!-- Security  -->
<div class="row nm hide">
    <h5 class="semibold mb15">Security:</h5>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "username", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "username", array("class" => "form-control")); ?>
            <?php echo $form->error($model, "username", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>    
    <?php if ($model->isNewRecord) : ?>
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
    <?php endif; ?>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, "status", array("class" => "control-label")); ?>
            <?php echo common::select2($model, "status", Users::model()->statusArr, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
            <?php echo $form->error($model, "status", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php
$this->endWidget();
Yii::app()->clientScript->registerScript('actions', "
    $('#addFamily,#addReference, #addArea,#addAllergy,#addCase,#addMedicine').live('click',function() {
        var url = $(this).attr('href')+'?selected='+$($(this).data('id')).val();
        $.post(url,function(html){
            $('#modalContainer').html(html);
            $('#modalContainer .modal').modal();              
        });
        return false;
    });
");
?>
<style>
    .pull-left.plus-box{line-height: 1 !important;}
    .custom-select-class .select2-container{border: none;}
    .custom-select-class .select2-choices{border-radius: 4px;min-height: 34px;border: 1px solid #cfd9db;}
</style>
<script type="text/javascript">
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profPic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("input:file").change(function () {
        readURL(this);
    })
</script>