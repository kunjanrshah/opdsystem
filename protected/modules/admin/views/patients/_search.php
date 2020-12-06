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
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                         echo $form->hiddenField($model, 'id');
                         $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'selectPatientValue',
                            'value' => isset($_GET['selectPatientValue'])?$_GET['selectPatientValue']:'',
                            'source' => CController::createUrl('patients/patientdropdown'),
                            'options' => array(
                                'html'=>true,
                                'showAnim' => 'fold',
                                'minLength' => '1',
                                'search' => 'js:function( event, ui ) { $("#Patients_id").val(null); }',
                                'select' => 'js:function( event, ui ) {
                                $("#selectPatientValue").val( ui.item.label );
                                $("#Patients_id").val( ui.item.value );
                                return false;
                                }',
                            ),
                            'htmlOptions' => array(
//                                'onfocus' => 'js: this.value = null; $("#searchbox").val(null); $("#selectedvalue").val(null);',
                                'onblur' => 'js: if(!$("#Patients_id").val()){ $("#selectPatientValue").val(null); }',
                                'class' => 'form-control',
                                'placeholder' => "Search Patient ...",
                                'autocomplete'=>'off'
                            ),
                        ));
                        ?>
                        <?php // echo common::select2($model, "id", CHtml::ListData(Patients::model()->findAll(), "id", "patient_name_with_id"), array("prompt" => "Patients", "class" => "chzn-select", "style" => "width:100%;")); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php
                         echo $form->hiddenField($model, 'family_id');
                         $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'selectFamilyHeadValue',
                            'value' => isset($_GET['selectFamilyHeadValue'])?$_GET['selectFamilyHeadValue']:'',
                            'source' => CController::createUrl('patients/familyheaddropdown'),
                            'options' => array(
                                'html'=>true,
                                'showAnim' => 'fold',
                                'minLength' => '1',
                                'search' => 'js:function( event, ui ) { $("#Patients_family_id").val(null); }',
                                'select' => 'js:function( event, ui ) {
                                $("#selectFamilyHeadValue").val( ui.item.label );
                                $("#Patients_family_id").val( ui.item.value );
                                return false;
                                }',
                            ),
                            'htmlOptions' => array(
//                                'onfocus' => 'js: this.value = null; $("#searchbox").val(null); $("#selectedvalue").val(null);',
                                'onblur' => 'js: if(!$("#Patients_family_id").val()){ $("#selectFamilyHeadValue").val(null); }',
                                'class' => 'form-control',
                                'placeholder' => "Search Family Head ...",
                                'autocomplete'=>'off'
                            ),
                        ));
                        ?>
<?php // echo common::select2($model, "family_id", CHtml::ListData(Patients::model()->getFamilyHead(), "id", "patient_name_with_id"), array("prompt" => $model->getAttributeLabel("family_id"), "class" => "chzn-select", "style" => "width:100%;")); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
<?php echo common::select2($model, "blood_group", $model->bloodGroupArr, array("prompt" => $model->getAttributeLabel("blood_group"), "style" => "width:100%;")); ?>
                    </div>
                </div>  

            </div></div>
        <div class="row">
            <!--<br>-->
            <div class="col-md-8">
                <div class="col-md-4">
                    <div class="form-group">
<?php echo $form->textField($model, "address1", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address1"))); ?> 
                    </div>
                </div> 
                <div class="col-md-4">
                    <div class="form-group">
<?php echo $form->textField($model, "address2", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("address2"))); ?> 
                    </div>
                </div>                  
                <div class="col-md-4">
                    <div class="form-group">
<?php echo $form->textField($model, "contact_number", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("contact_number"))); ?> 
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="col-md-12">
                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary"><i class="ico-loop4 mr5"></i><?php echo common::translateText("SEARCH_BTN_PATIENT_TEXT"); ?></button>
                        <a href="<?php echo $this->createUrl("/admin/patients/index") ?>" class="btn btn-primary"><i class="ico-loop4 mr5"></i>Reset</a>
                    </div>
                </div>
            </div>
        </div>
<?php $this->endWidget(); ?>
    </div>
</div>