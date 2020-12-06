<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-users mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("medicinegroup/update") : common::getTitle("medicinegroup/add"); ?></h4>
            </div>            
            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-user-group',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                )));
                ?>
                <!-- User Group Info  -->
                <div class="row nm">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                                <?php echo $form->labelEx($model, "name", array("class" => "control-label")); ?>
                            <div class="has-icon pull-left">
                            <?php echo $form->textField($model, "name", array("class" => "form-control")); ?>
                                <i class="ico-users form-control-icon"></i>
                            </div>
                            <?php echo $form->error($model, "name", array("class" => "parsley-custom-error-message")); ?>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <!-- User Group Info  -->                    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-user-group').submit();">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->