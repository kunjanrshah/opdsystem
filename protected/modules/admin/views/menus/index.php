<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("application.modules.admin.views.common._search", array("field"=>"menu_title", "id"=>"menu-grid", "model" => $model));?>
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;<?php echo common::getTitle("menus/index"); ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        if(common::checkActionAccess("menus/add")) :
                            echo CHtml::Link(common::getTitle("menus/add").' <i class="ico-plus"></i>',array("menus/add"),array(
                                "title"=>common::getTitle("menus/add"),
                                "data-placement"=>"bottom",
                                "rel"=>"tooltip", 
                                "class"=>"btn btn-sm btn-default addUpdateRecord", 
                                "data-original-title"=>common::getTitle("menus/add")
                            )); 
                        endif;
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                <?php
                    $this->widget('ext.groupgridview.GroupGridView', array(
                    "id"=>"menu-grid",
                    "dataProvider"=>$model->search(),
                    "itemsCssClass"=>"table table-bordered table-hover dataTable",
                    "htmlOptions"=>array("class"=>"dataTables_wrapper"),
                    "enablePagination"=>true,
                    "template"=>'<div class="table-responsive">{items}</div><div class="row"><div class="col-sm-6">{pager}</div><div class="col-sm-6">{summary}</div></div>',
                    "summaryText"=>"Showing {start} to {end} of {count} entries",
                    "summaryCssClass"=>"dataTables_info",
                    "emptyText"=>"No records found.",
                    "enableSorting"=>true,
                    "pagerCssClass"=>"dataTables_paginate paging_bootstrap",
                    "pager"=>array(
                        "header"         => "",
                        "firstPageLabel" => "First",
                        "prevPageLabel"  => "Previous",
                        "nextPageLabel"  => "Next",
                        "lastPageLabel"  => "Last",
                        "htmlOptions"=>array("class"=>"pagination")
                    ), 
                    'mergeColumns' => array('parent_id'),              
                    "columns"=>array(
                        array(
                            "name"=>"parent_id",
                            "value"=>function($data,$row){
                                return $data->parentRel->menu_title;
                            },
                            "type"=>'raw'
                        ),
                        "menu_title",
                        "page_url",
                        array(
                            "name"=>"show_in_menu",
                            "value"=>'!empty($data->show_in_menu)?"'.common::translateText("YES_LABEL").'":"'.common::translateText("NO_LABEL").'"'
                        ),
                        array( 
                            "class"=>"CButtonColumn",
                            "header"=>"Action",
                            "htmlOptions"=>array("width"=>"10%","class"=>"text-center"),  
                            "headerHtmlOptions"=>array("width"=>"10%","class"=>"text-center"),
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
                                    "url"=>'Yii::app()->createUrl("/admin/menus/update", array("id"=>$data->id))',
                                    "options"=>array("class"=>"addUpdateRecord mr5","title"=>common::getTitle("menus/update"))
                                ),
                                "deleteRecord"=>array(
                                    "label"=>'<i class="icon ico-trash"></i> '.common::translateText("DELETE_BTN_TEXT"),
                                    "imageUrl"=>false,
                                    "url"=>'Yii::app()->createUrl("/admin/menus/delete", array("id"=>$data->id))',
                                    "options"=>array("class"=>"deleteRecord text-danger mr5","title"=>common::getTitle("menus/delete"))
                                ),
                            ),

                        ),
                    ),
                ));
                Yii::app()->clientScript->registerScript('actions', "
                    $('.addUpdateRecord').live('click',function() {                        
                        var url = $(this).attr('href');
                        $.post(url,function(html){
                            $('#modalContainer').html(html);
                            $('#modalContainer .modal').modal();              
                        });
                        return false;
                    });
                    $('.deleteRecord').live('click',function() {
                        if(!confirm('".common::translateText("DELETE_CONFIRM")."')) return false;                        
                        var url = $(this).attr('href');
                        $.post(url,function(res){
                            $.fn.yiiGridView.update('menu-grid');
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