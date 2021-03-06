<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-users mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("area/update") : common::getTitle("area/add"); ?></h4>
            </div>            
            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-area',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
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
                                        if($("#area-grid") && $("#area-grid").length){
                                            $.fn.yiiGridView.update("area-grid");
                                        } else {
                                            if($("#Patients_area_id")){
                                                $("#Patients_address2").select2("destroy");
                                                $("#Patients_address2").empty().append(data);
                                                $("#Patients_address2").select2();
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
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, "area_name", array("class" => "control-label")); ?>
                            <div class="has-icon pull-left">
                                <?php echo $form->textField($model, "area_name", array("class" => "form-control")); ?>
                                <i class="ico-users form-control-icon"></i>
                            </div>
                            <?php echo $form->error($model, "area_name", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <!-- User Group Info  -->                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-area').submit();">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->