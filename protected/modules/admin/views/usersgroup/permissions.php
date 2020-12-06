<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div class="panel panel-primary">
                <!-- panel toolbar wrapper -->
                <?php $form=$this->beginWidget('CActiveForm', array(
                    'id'=>'form-permissions',
                    'enableAjaxValidation'=>false,
                    'enableClientValidation'=>false,
                    'clientOptions'=>array(
                    'validateOnSubmit'=>true
                ))); ?>
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="btn-group">
                          <h5 class="title semibold"><?php echo $model->group_name;?></h5> 
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <button class="btn btn-sm btn-default" type="reset"><?php echo common::translateText("RESET_BTN_TEXT");?></button>
                        <button class="btn btn-sm btn-success" type="submit"><?php echo common::translateText("UPDATE_BTN_TEXT");?></button>
                    </div>
                </div>
                <!--/ panel toolbar wrapper -->
                <!-- panel body with collapse capabale -->  
                <div class="table-responsive panel-collapse pull out">
                    <table id="users" class="table table-bordered table-hover">
                        <tbody>
                            <!-- list parent row -->
                            <?php if(!empty($permissionsArr)) : foreach($permissionsArr as $parent_id=>$childArr) : ?>
                                <tr>
                                    <td><p class="text-center semibold"><?php echo !empty($parentMenuArr[$parent_id])?$parentMenuArr[$parent_id]:common::translateText("NOT_AVAILABLE_TEXT");?></p></td>
                                <?php if(!empty($childArr)) : foreach($childArr as $id=>$menu_title) : ?>                            
                                <td>
                                    <div class="checkbox custom-checkbox nm text-center">
                                        <p class="text-center"><?php echo $menu_title; ?></p>
                                        <?php echo CHtml::CheckBox("GroupRights[".$id."]",in_array($id,$pastPermissionArr)?true:false,array("id"=>"parent-view-".$id)); ?>
                                        <label for="parent-view-<?php echo $id;?>"></label>   
                                    </div>                                            
                                </td>
                                <?php endforeach; endif; ?>
                            </tr>
                            <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                    <!-- panel toolbar wrapper -->
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar text-right">
                        <button class="btn btn-sm btn-default" type="reset"><?php echo common::translateText("RESET_BTN_TEXT");?></button>
                        <button class="btn btn-sm btn-success" type="submit"><?php echo common::translateText("UPDATE_BTN_TEXT");?></button>
                    </div>
                </div>
                <!--/ panel toolbar wrapper -->
                </div>
                <!--/ panel body with collapse capabale -->
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->