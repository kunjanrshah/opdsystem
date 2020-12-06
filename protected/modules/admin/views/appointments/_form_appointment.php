<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title text-primary"><i class="ico-calendar mr5"></i>
                <?php
                echo!$model->isNewRecord ? common::getTitle("appointments/update") : common::getTitle("appointments/add");
                echo "&nbsp;( From: ";
                echo common::getDateTime($model->shiftTimeRange[0]["start"], Yii::app()->params->timeFormatPHP) . " To: " . common::getDateTime($model->shiftTimeRange[0]["end"], Yii::app()->params->timeFormatPHP);
                echo " ) &nbsp;  &amp;  ";
                echo "&nbsp;( From: ";
                echo common::getDateTime($model->shiftTimeRange[1]["start"], Yii::app()->params->timeFormatPHP) . " To: " . common::getDateTime($model->shiftTimeRange[1]["end"], Yii::app()->params->timeFormatPHP);
                echo " )";
                ?> 
            </h4>
        </div>
        <div class="modal-body">
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'form-appointment',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'clientOptions' => array(
                    'validateOnSubmit' => true
            )));
            $hide = !$model->isNewRecord ? "hide" : "";
            ?>
            <!-- User Group Info  -->
            <div class="row nm">    
                <div class="col-md-4 <?php echo $hide; ?>">
                    <div class="form-group">
                        <?php echo $form->labelEx($model, "appointment_title", array("class" => "control-label")); ?>
                        <div class="has-icon pull-left">
                            <?php echo $form->textField($model, "appointment_title", array("class" => "form-control")); ?>
                            <i class="ico-health form-control-icon"></i>
                        </div>
                        <?php echo $form->error($model, "appointment_title", array("class" => "parsley-custom-error-message")); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">                                
                        <?php echo $form->labelEx($model, "appointment_date", array("class" => "control-label")); ?>
                        <div class="has-icon pull-left">                                
                            <?php common::getDatePicker($model, "appointment_date", array("class" => "form-control", "readonly" => false, "placeholder" => $model->getAttributeLabel("appointment_date"))); ?>
                            <i class="ico-calendar5 form-control-icon"></i>
                        </div>
                        <?php echo $form->error($model, "appointment_date", array("class" => "parsley-custom-error-message")); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">                                
                        <?php echo $form->labelEx($model, "appointment_time", array("class" => "control-label")); ?>
                        <?php $model->appointment_time = $model->appointment_time_db ?>
                        <?php echo common::select2($model, "appointment_time", Appointments::model()->getAppointmentTimeRange($model->appointment_date), array("class" => "form-control", 'options' => $model->getFixedAppointments($model->appointment_date), "prompt" => common::translateText("DROPDOWN_TEXT"))); ?>
                        <?php echo $form->error($model, "appointment_time", array("class" => "parsley-custom-error-message")); ?>
                    </div>
                </div>
            </div>
            <?php if (!$this->isPatient): ?>
                <div class="row nm  <?php echo $hide; ?>">                    
                    <div class="col-md-4">
                        <div class="form-group">                                
                            <?php echo $form->labelEx($model, "patient_id", array("class" => "control-label")); ?>
                            <?php echo common::select2($model, "patient_id", Patients::model()->getPatientsList(), array("class" => "form-control", "prompt" => common::translateText("DROPDOWN_TEXT"))); ?>
                            <?php echo $form->error($model, "patient_id", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>                    
                    <div class="col-md-8 hide">
                        <div class="form-group">                                
                            <?php echo $form->labelEx($model, "is_confirmed", array("class" => "control-label")); ?>
                            <?php echo common::select2($model, "is_confirmed", array(1 => "Yes", 0 => "No"), array("class" => "form-control")); ?>                                    
                            <?php echo $form->error($model, "is_confirmed", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>
                </div> 
                <?php
            else :
                echo $form->hiddenField($model, "patient_id", array("value" => Yii::app()->user->id));
                echo $form->hiddenField($model, "is_confirmed", array("value" => 1));
            endif;
            ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onclick="history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
            <button type="submit" class="btn btn-primary" onclick="$('#form-appointment').submit();"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
