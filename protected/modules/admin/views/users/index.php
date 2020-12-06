<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
            <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;<?php echo common::getTitle("users/index"); ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                         if(common::checkActionAccess("users/add")) :
                            echo CHtml::Link(common::getTitle("users/add").' <i class="ico-plus"></i>',array("users/add"),array(
                                "title"=>common::getTitle("users/add"),
                                "data-placement"=>"bottom",
                                "rel"=>"tooltip", 
                                "class"=>"btn btn-sm btn-default", 
                                "data-original-title"=>common::getTitle("users/add")
                            )); 
                         endif;
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                <?php
                   $updateRight = common::checkActionAccess("users/index");
                   $deleteRight = common::checkActionAccess("users/delete");
                   $columnClass = (!$updateRight && !$deleteRight)?"hide":"";
                   $this->widget("zii.widgets.grid.CGridView", array(
                    "id"=>"users-grid",
                    "dataProvider"=>$model->search(),           
                    "columns"=>array(                        
                        array(
                            "header"=>"",
                            "type"=>"raw",
                            "value"=>'"<div class=\"media-object\">".CHtml::Image(Yii::app()->user->getProfilePicture($data->profile_pic,$data->id),"",array("class"=>"img-circle"))."</div>"',
                            "htmlOptions"=>array("width"=>"1%","class"=>"text-center")
                        ),
                        array(
                            "header"=>"Name",
                            "name"=>"first_name",
                            "value"=>'$data->first_name." ".$data->last_name'
                        ),
                        "phone_number",
                        "email_address",
                        array(
                            "header"=>"Role",
                            "name"=>"user_group",
                            "value"=>'$data->usersGroupRel->group_name'
                        ),
                        array(
                            "name"=>"status",
                            "value"=>'!empty(Users::model()->statusArr[$data->status])?Users::model()->statusArr[$data->status]:"'.common::translateText('NOT_AVAILABLE_TEXT').'"'
                        ),
                        array( 
                            "class"=>"CButtonColumn",
                            "header"=>"Action",
                            "htmlOptions"=>array("width"=>"10%","class"=>"text-center $columnClass"),  
                            "headerHtmlOptions"=>array("width"=>"10%","class"=>"text-center $columnClass"),
                            "template"=>'<div class="toolbar">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-default" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-sm btn-default dropdown-toggle" type="button">
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>{updateRecord}</li>
                                                    <li>{deleteRecord}</li>
                                                </ul>
                                            </div>
                                        </div>',
                            "buttons"=>array(
                                "updateRecord"=>array(
                                    "label"=>'<i class="icon ico-pencil"></i> '.common::translateText("UPDATE_BTN_TEXT"),
                                    "imageUrl"=>false,
                                    "url"=>'Yii::app()->createUrl("/admin/users/update", array("id"=>$data->id))',
                                    "options"=>array("class"=>"addUpdateRecord mr5","title"=>common::getTitle("users/update")),
                                    "visible"=>($updateRight)?'true':'false',
                                ),
                                "deleteRecord"=>array(
                                    "label"=>'<i class="icon ico-trash"></i> '.common::translateText("DELETE_BTN_TEXT"),
                                    "imageUrl"=>false,
                                    "url"=>'Yii::app()->createUrl("/admin/users/delete", array("id"=>$data->id))',
                                    "options"=>array("class"=>"deleteRecord text-danger mr5","title"=>common::getTitle("users/delete")),
                                    "visible"=>($deleteRight)?'true':'false',
                                ),
                            ),

                        ),
                    ),
                ));
                Yii::app()->clientScript->registerScript('actions', "
                    $('.deleteRecord').live('click',function() {
                        if(!confirm('".common::translateText("DELETE_CONFIRM")."')) return false;                        
                        var url = $(this).attr('href');
                        $.post(url,function(res){
                            $.fn.yiiGridView.update('users-grid');
                            $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow');
                        });
                        return false;
                    });
                ");
                ?>                    
                </div>
                <!--/ panel body with collapse capabale -->
            </div> 
        </div>      
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->