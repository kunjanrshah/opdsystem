<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                 <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i><?php echo!$model->isNewRecord ? common::getTitle("complains/update") : common::getTitle("complains/add"); ?></h4>
            </div>

            <div class="modal-body">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'form-complains',
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
                            <?php echo $form->labelEx($model, 'complain_title', array('class' => 'control-label')); ?>
                            <?php echo $form->textField($model, 'complain_title', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'complain_title', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>

                    <!-- User Group Info  --> 

                    <div class="col-md-8">
                        <div class="form-group">
                            <?php echo $form->labelEx($model, 'description', array('class' => 'control-label')); ?>
                            <?php echo $form->textArea($model, 'description', array('class' => 'form-control')); ?>
                            <?php echo $form->error($model, 'description', array('class' => 'parsley-custom-error-message')); ?>
                        </div>
                    </div>


                    <!-- User Group Info  --> 

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="$('#form-complains').submit();">Submit</button>
            </div>
            <?php $this->endWidget(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->