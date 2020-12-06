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
                            <span class="semibold">&nbsp;&nbsp;<?php echo common::getTitle("emails/index"); ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        if(common::checkActionAccess("emails/add")) :
                            echo CHtml::Link(common::getTitle("emails/add").' <i class="ico-plus"></i>',array("emails/add"),array(
                                "title"=>common::getTitle("emails/add"),
                                "data-placement"=>"bottom",
                                "rel"=>"tooltip", 
                                "class"=>"btn btn-sm btn-default", 
                                "data-original-title"=>common::getTitle("emails/add")
                            )); 
                        endif;
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                <?php
                   $updateRight = common::checkActionAccess("emails/index");
                   $deleteRight = common::checkActionAccess("users/delete");
                   $columnClass = (!$updateRight && !$deleteRight)?"hide":"";
                   $this->widget("zii.widgets.grid.CGridView", array(
                    "id"=>"emails-grid",
                    "dataProvider"=>$model->search(),           
                    "columns"=>array(
                        array(
                            "header"=>"Title",
                            "name"=>"email_title",
                            "value"=>'$data->email_title'
                        ),
                        "email_keyword",
                        "email_subject",
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
                                    "url"=>'Yii::app()->createUrl("/admin/emails/update", array("id"=>$data->id))',
                                    "options"=>array("class"=>"addUpdateRecord mr5","title"=>common::getTitle("users/update")),
                                    "visible"=>($updateRight)?'true':'false',
                                ),
                                "deleteRecord"=>array(
                                    "label"=>'<i class="icon ico-trash"></i> '.common::translateText("DELETE_BTN_TEXT"),
                                    "imageUrl"=>false,
                                    "url"=>'Yii::app()->createUrl("/admin/emails/delete", array("id"=>$data->id))',
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
                            $.fn.yiiGridView.update('emails-grid');
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