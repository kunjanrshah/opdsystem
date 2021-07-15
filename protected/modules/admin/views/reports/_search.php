<div class="page-header page-header-block">
    <div class="page-header-section">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#search_form').submit(function(){
                    $.fn.yiiGridView.update('appointments-grid', {
                        data: $('#search_form').serialize()
                    });
                    return false;
            });
            $('#exportdata').click(function(){
                    var url = '".Yii::app()->createAbsoluteUrl('admin/reports/export')."?'+$('#search_form').serialize();
                    //console.log('".Yii::app()->createAbsoluteUrl('admin/reports/export')."');
                    //console.log(url); 
                    window.open(url,'_blank');
                    return false;
            });
        ");
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'search_form',
            'method' => 'get',
            'clientOptions' => array('validateOnSubmit' => true)
        ));
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-2">				
                    <?php common::getDatePicker($model, "start_date",array( "class" => "form-control","placeholder" => $model->getAttributeLabel("start_date")),array('yearRange' => '2005:2099','onSelect'=>'js:function( selectedDate ) {$("#Treatments_end_date").datepicker( "option", "minDate", selectedDate );}')); ?>					
                </div>
                <div class="col-xs-2">
                    <?php common::getDatePicker($model, "end_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("end_date")),array('yearRange' => '2005:2099','onSelect'=>'js:function( selectedDate ) {$("#Treatments_start_date").datepicker( "option", "maxDate", selectedDate );}')); ?>
                </div>   
                <div class="col-xs-2">
                    <?php
                         echo $form->hiddenField($model, 'patient_id');
                         $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'selectPatientValue',
                            'value' => isset($_GET['selectPatientValue'])?$_GET['selectPatientValue']:'',
                            'source' => CController::createUrl('patients/patientonlynamedropdown'),
                            'options' => array(
                                'html'=>true,
                                'showAnim' => 'fold',
                                'minLength' => '1',
                                'search' => 'js:function( event, ui ) { $("#Treatments_patient_id").val(null); }',
                                'select' => 'js:function( event, ui ) {
                                $("#selectPatientValue").val( ui.item.label );
                                $("#Treatments_patient_id").val( ui.item.value );
                                return false;
                                }',
                            ),
                            'htmlOptions' => array(
//                                'onfocus' => 'js: this.value = null; $("#searchbox").val(null); $("#selectedvalue").val(null);',
                                'onblur' => 'js: if(!$("#Treatments_patient_id").val()){ $("#selectPatientValue").val(null); }',
                                'class' => 'form-control',
                                'placeholder' => "Search Patient ...",
                                'autocomplete'=>'off'
                            ),
                        ));
                        ?>
                    <?php // echo common::select2($model, "patient_id", Patients::model()->getPatientsList(), array("prompt" => "Patients", "class" => "chzn-select", "style" => "width:100%;")); ?>
                </div>   
                <div class="col-xs-2">
                    <?php echo common::select2($model, "diagnosis_id", CHtml::ListData(DiagnosisMaster::model()->findAll(), "id", "diagnosis_title"), array("prompt" => "All Diagnosis", "class" => "chzn-select", "style" => "width:100%;")); ?>
                </div> 
				<!-- Charges Dropdown
				<div class="col-xs-2">
                    <php echo common::select2($model, "treatmentChargesRel", CHtml::ListData(ChargesMaster::model()->findAll(), "id", "charge_title"), array(//"prompt" => "All Charges", "class" => "chzn-select", "style" => "width:100%;")); ?>
                </div> 	 -->			
                <div class="col-xs-2">
                    <button type="submit" class="btn btn-primary"><i class="ico-loop4 mr5"></i><?php echo common::translateText("SEARCH_BTN_TEXT"); ?></button>
                </div>
                <div class="col-xs-2">
                    <a id="exportdata" class="button btn btn-primary"><i class="glyphicon glyphicon-download-alt"> </i> Export</a>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>