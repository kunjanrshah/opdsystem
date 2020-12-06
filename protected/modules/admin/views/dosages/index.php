<?php
$deleteRight = common::checkActionAccess("dosages/delete");
?>
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
                            <span class="semibold">&nbsp;&nbsp;<?php echo common::getTitle("dosages/index"); ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        if (common::checkActionAccess("dosages/add")) :
                            echo CHtml::Link(common::getTitle("dosages/add") . ' <i class="ico-plus"></i>', array("dosages/add"), array(
                                "title" => common::getTitle("dosages/add"),
                                "data-placement" => "bottom",
                                "rel" => "tooltip",
                                "class" => "btn btn-sm btn-default addUpdateRecord",
                                "data-original-title" => common::getTitle("dosages/add")
                            ));
                        endif;

                        if ($deleteRight) :
                            echo CHtml::Link('<i class="ico-remove3"></i>', array("/admin/dosages/delete"), array("class" => "ml5 btn btn-sm btn-danger deleteRecord multipleDelete"));
                        endif;
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $updateRight = common::checkActionAccess("dosages/index");
                    $deleteRight = common::checkActionAccess("dosages/delete");
                    $columnClass = (!$updateRight && !$deleteRight) ? "hide" : "";
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "dosage-grid",
                        "dataProvider" => $model->search(),
                        "columns" => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'value' => '$data["id"]',
                                "checkBoxHtmlOptions" => array("name" => "idList[]"),
                            ),
                            "dosage_name",
                            "dosage_description",
                            array(
                                "class" => "CButtonColumn",
                                "header" => "Action",
                                "htmlOptions" => array("width" => "10%", "class" => "text-center $columnClass"),
                                "headerHtmlOptions" => array("width" => "10%", "class" => "text-center $columnClass"),
                                "template" => '<div class="toolbar">
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
                                "buttons" => array(
                                    "updateRecord" => array(
                                        "label" => '<i class="icon ico-pencil"></i> ' . common::translateText("UPDATE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/admin/dosages/update", array("id"=>$data->id))',
                                        "options" => array("class" => "addUpdateRecord mr5", "title" => common::getTitle("dosages/update")),
                                        "visible" => ($updateRight) ? 'true' : 'false',
                                    ),
                                    "deleteRecord" => array(
                                        "label" => '<i class="icon ico-trash"></i> ' . common::translateText("DELETE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/admin/dosages/delete", array("id"=>$data->id))',
                                        "options" => array("class" => "deleteRecord text-danger mr5", "title" => common::getTitle("dosages/delete")),
                                        "visible" => ($deleteRight) ? 'true' : 'false',
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
                    var idList = '';
                        $('.deleteRecord').live('click',function() 
                        {                        
                            if($(this).hasClass('multipleDelete'))
                            {
                                var idList    = $('input[type=checkbox]:checked').serialize();
                                if(!idList){
                                    alert('" . common::translateText("INVALID_SELECTION") . "'); return false;  
                                }
                            }
                            var totalRecs = $('input[type=checkbox]:checked').not('#dosage-grid_c0_all').length;
                            totalRecs = (totalRecs=='0')?'this':totalRecs;
                            if(!confirm('Are you sure to delete '+totalRecs+' area ?')) return false;                                               
                            var url = $(this).attr('href');
                            $.post(url,idList,function(res){
                                $.fn.yiiGridView.update('dosage-grid');
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