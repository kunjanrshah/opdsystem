<!-- START Add Edit User -->
<div class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title text-primary"><i class="ico-menu6 mr5"></i><?php echo !$model->isNewRecord?common::getTitle("menus/update"):common::getTitle("menus/add");?></h4>
            </div>
            
            <div class="modal-body">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'form-menu',
                        'enableAjaxValidation'=>true,
                        'enableClientValidation'=>false,
                        'clientOptions'=>array(
                        'validateOnSubmit'=>true
                    ))); ?>
                	<!-- User Group Info  -->
                    <div class="row nm">
                        <div class="col-md-4">
                             <div class="form-group">
                                <?php echo $form->labelEx($model,"parent_id",array("class"=>"control-label"));?>
                                <?php echo common::select2($model,"parent_id",CHtml::ListData(MenusMaster::model()->getParentMenus(),'id','menu_title'),array("prompt"=>common::translateText("DROPDOWN_TEXT"),"class"=>"form-control"));?>
                                <?php echo $form->error($model,"parent_id",array("class"=>"parsley-custom-error-message"));?>                        
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,"menu_title",array("class"=>"control-label"));?>
                                <div class="has-icon pull-left">
                                    <?php echo $form->textField($model,"menu_title",array("class"=>"form-control"));?>
                                    <i class="ico-menu form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model,"menu_title",array("class"=>"parsley-custom-error-message"));?>
                        	</div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,"page_url",array("class"=>"control-label"));?>
                                <div class="has-icon pull-left">
                                     <?php echo $form->textField($model,"page_url",array("class"=>"form-control"));?>
                                    <i class="ico-link form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model,"page_url",array("class"=>"parsley-custom-error-message"));?>
                            </div>
                        </div>
              		</div>
                      <div class="row nm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,"menu_icon",array("class"=>"control-label"));?>
                                <div class="has-icon pull-left">
                                     <?php echo $form->textField($model,"menu_icon",array("class"=>"form-control"));?>
                                    <i class="ico-flag form-control-icon"></i>
                                </div>
                                <?php echo $form->error($model,"menu_icon",array("class"=>"parsley-custom-error-message"));?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?php echo $form->labelEx($model,"show_in_menu",array("class"=>"control-label"));?>
                                <div class="has-icon pull-left">
                                    <div class="checkbox custom-checkbox">
                                        <?php echo $form->checkBox($model,"show_in_menu",array("data-parsley-mincheck"=>"1"));?>
                                        <label for="MenusMaster_show_in_menu">&nbsp;&nbsp;Check if you want to view this in menu.</label>   
                                    </div>
                                </div>
                                <?php echo $form->error($model,"show_in_menu",array("class"=>"parsley-custom-error-message"));?>
                            </div>
                        </div>
                    </div>
                    <!-- User Group Info  -->                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo common::translateText("CANCEL_BTN_TEXT");?></button>
                    <button type="submit" class="btn btn-primary" onclick="$('#form-menu').submit();"><?php echo common::translateText("SUBMIT_BTN_TEXT");?></button>
                </div>
            <?php $this->endWidget(); ?>
		</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--/ END Add Edit User -->