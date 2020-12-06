<div class="container-fluid">
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;<?php echo common::getTitle("notifications/index"); ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        $updateRight = common::checkActionAccess("notifications/index");
                        $deleteRight = common::checkActionAccess("notifications/delete");
						$clearallRight = common::checkActionAccess("notifications/clearall");
                        if ($deleteRight) :
                            echo CHtml::Link('<i class="ico-remove3"></i>', array("/admin/notifications/delete"), array("class" => "ml5 btn btn-sm btn-danger deleteRecord multipleDelete"));
                        endif;
					
                            echo CHtml::Link('Clear All', array("/admin/notifications/clearall"), array("class" => "ml5 btn btn-sm btn-danger clearall multipleDelete"));
                        
                        ?>
                    </div>
                </div>
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $columnClass = (!$updateRight && !$deleteRight) ? "hide" : "";
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "notifications-grid",
                        "dataProvider" => $model->search(),
                        "columns" => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'value' => '$data["id"]',
                                "checkBoxHtmlOptions" => array("name" => "idList[]"),
                            ),
                            array(
                                "name" => "description",
                                "value" => 'CHtml::Link($data->description,array($data->link))',
                                "type" => "raw"
                            ),
                        ),
                    ));
                    Yii::app()->clientScript->registerScript('actions', "
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
                            var totalRecs = $('input[type=checkbox]:checked').not('#notifications-grid_c0_all').length;
                            totalRecs = (totalRecs=='0')?'this':totalRecs;
                            if(!confirm('Are you sure to delete '+totalRecs+' notification ?')) return false;                        
                            var url = $(this).attr('href');
                            $.post(url,idList,function(res){
                                var cnt = Number($('#notificationCount').html());
								$('#notificationCount').html(Number(cnt)-Number(totalRecs));
                                $.fn.yiiGridView.update('notifications-grid');
                                $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow').css('display','block');
								
                            });
                            return false;
                        });
						$('.clearall').live('click',function() 
                        {                            
                            if(!confirm('Are you sure to delete all notification ?')) return false;                        
                            var url = $(this).attr('href');
                            $.post(url,function(res){
                                $.fn.yiiGridView.update('notifications-grid');								
                                $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow').css('display','block');
								
                            });
                            return false;
                        });
                    ");
                    ?>                    
                </div>
            </div> 
        </div>      
    </div>
</div>