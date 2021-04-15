<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("references/update") : common::getTitle("references/add"); ?></h4>
            </div>

            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-references',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => 'js:function(form, data, hasError){
                            if(!hasError){
                                $.ajax({
                                    url:form.attr("action"),
                                    type:"POST",
                                    dataType:"JSON",
                                    data:form.serialize(),
                                    success:function(response){
                                        var success = response.success;
                                        var message = response.message;
                                        var data = response.data;
                                        $(".close").trigger("click");
                                        $("#flash-message").html(message).show();                                        
                                        if($("#reference-grid") && $("#reference-grid").length){
                                            $.fn.yiiGridView.update("reference-grid");
                                        } else {
                                            if($("#Patients_reference_id")){
                                                $("#Patients_reference_id").select2("destroy");
                                                $("#Patients_reference_id").empty().append(data);
                                                $("#Patients_reference_id").select2();
                                            }
                                        }
                                    }
                                });
                                return false;
                            }
                         }'
                    )
                ));
                ?>
                <!-- User Group Info  -->
                <div class="row nm">                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "reference_name", array("class" => "control-label")); ?>
                            <div class="has-icon pull-left">
                                <?php echo $form->textField($model, "reference_name", array("class" => "form-control")); ?>
                                <i class="ico-menu form-control-icon"></i>
                            </div>
                            <?php echo $form->error($model, "reference_name", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "profession", array("class" => "control-label")); ?>
                            <div class="has-icon pull-left">
                                <?php echo $form->textField($model, "profession", array("class" => "form-control")); ?>
                                <i class="ico-menu form-control-icon"></i>
                            </div>
                            <?php echo $form->error($model, "profession", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>
                    <div class="row nm">   
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model, "contact_number", array("class" => "control-label")); ?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model, "contact_number", array("class" => "form-control")); ?>
                                    <i class="ico-link form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model, "contact_number", array("class" => "parsley-custom-error-message")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "address1", array("class" => "control-label")); ?>
                            <div class="has-icon pull-left">
                                <?php echo $form->textField($model, "address1", array("class" => "form-control")); ?>
                                <i class="ico-link form-control-icon"></i>
                            </div>
                            <?php echo $form->error($model, "address1", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>           
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
                    <button type="submit" class="btn btn-primary" onclick="$('#form-references').submit();"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
                </div>
                <?php $this->endWidget(); ?>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!--/ END Add Edit User -->