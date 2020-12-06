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
                    'id' => 'form-rmedicine',
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
                                        
                                        if($("#Patients_regular_medicine")){
                                            $("#Patients_regular_medicine").select2("destroy");
                                            $("#Patients_regular_medicine").empty().append(data);
                                            $("#Patients_regular_medicine").select2();
                                        }
                                    }
                                });
                                return false;
                            }
                         }'
                    )
                ));
                ?>
                <div class="row nm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "title", array("class" => "control-label")); ?>
                            <?php echo $form->textField($model, "title", array("class" => "form-control")); ?>
                            <?php echo $form->error($model, "title", array("class" => "parsley-custom-error-message")); ?>                        
                        </div>
                    </div>
                </div>                     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-rmedicine').submit();"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->