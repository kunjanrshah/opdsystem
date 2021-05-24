<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("_search", array("model" => $model)); ?>
    <?php $this->renderPartial("/layouts/_message"); ?>
    <?php
    $appointmentRight = common::checkActionAccess("appointments/index");
    $updateRight = common::checkActionAccess("patients/index");
    $deleteRight = common::checkActionAccess("patients/delete");
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">                
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;<?php echo common::getTitle("patients/index"); ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        if (common::checkActionAccess("patients/add")) {
                            echo CHtml::Link(common::getTitle("patients/add") . ' <i class="ico-plus"></i>', array("patients/add"), array(
                                "title" => common::getTitle("patients/add"),
                                "data-placement" => "bottom",
                                "rel" => "tooltip",
                                "class" => "btn btn-sm btn-default",
                                "data-original-title" => common::getTitle("patients/add")
                            ));
                        }
                        if ($deleteRight) :
                            echo CHtml::Link('<i class="ico-remove3"></i>', array("/admin/patients/delete"), array("class" => "ml5 btn btn-sm btn-danger deleteRecord multipleDelete"));
                        endif;
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $columnClass = (!$updateRight && !$deleteRight && !$appointmentRight) ? "hide" : "";
                    $viewRight = common::checkActionAccess("patients/view");
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "patients-grid",
                        "dataProvider" => $model->search(),
                        "columns" => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'value' => '$data["id"]',
                                "checkBoxHtmlOptions" => array("name" => "idList[]"),
                            ),
                           array(
                               "header" => "&nbsp;",
                               "type" => "raw",
                               "value" => function($data) {
                                   return "<i style=\"cursor:pointer\" data-patient_id=\"$data->id\" class=\"ico-plus expand-collapse\"></i>";
                               },
                               "htmlOptions" => array("width" => "1%", "class" => "text-center")
                           ),
                            array(
                                "header" => "Patient",
                                "name" => "patient_name",
                                "htmlOptions" => array("width" => "25%"),
                                "value" => function($data, $row) {
                                    $patient_name = (FALSE) ? CHtml::Link($data->patient_name, array("/admin/patients/view", "id" => $data->id)) : $data->patient_name;
                                    $ageArr = common::getAgeFromDate($data->birth_date);
                                    $years = !empty($ageArr["years"]) ? $ageArr["years"] + 1 : 0;
                                    $months = !empty($ageArr["months"]) ? $ageArr["months"] : 0;
                                    $days = !empty($ageArr["days"]) ? $ageArr["days"] : 0;
                                    return "<strong>".$patient_name . "</strong> ( <strong>ID : </strong>" . $data->id . " ) <br>" . "<strong>Age : </strong>" . $years . " Years, " . $months . " Months, " . $days . " Days";
                                },
                                        "type" => "raw"
                                    ),
                                    array(
                                        "header" => "Relation",
                                        "name" => "relation_id",
                                        "value" => function($data, $row) {
                                            $family_name = !empty($data->familyRel->patient_name) ? $data->familyRel->patient_name : $data->patient_name;
                                            $relation = !empty($data->relationArr[$data->relation]) ? $data->relationArr[$data->relation] : "Self";
                                            return "<strong>Head : </strong>" . $family_name . "<br><strong>Relation  : </strong>" . $relation;
                                        },
                                        "type" => "raw"
                                    ),
                                    array(
                                        "header" => "Address",
                                        "name" => "address1",
                                        "value" => function($data, $row) {
                                            $area_name = !empty($data->AreaRel->area_name) ? $data->AreaRel->area_name : "N/A";
                                            return "<strong>Address : </strong>" . $data->address1 . "<br><strong>Area  : </strong>" . $area_name;
                                        },
                                        "type" => "raw"
                                    ),
                                    array(
                                        "header" => "Contact Info",
                                        "name" => "address1",
                                        "value" => function($data, $row) {
                                            $contact2 = !empty($data->contact_number2) ? "," . $data->contact_number2 : "";
                                            return "<strong>Contact #  : </strong>" . $data->contact_number . $contact2 . "<br><strong>Email  : </strong>" . CHtml::Link($data->email_address, "mailto:" . $data->email_address);
                                        },
                                        "type" => "raw"
                                    ),
                                    array(
                                        "header" => "Blood",
                                        "name" => "blood_group",
                                        "value" => '!empty($data->bloodGroupArr[$data->blood_group])?$data->bloodGroupArr[$data->blood_group]:"' . common::translateText('NOT_AVAILABLE_TEXT') . '"',
                                        "htmlOptions" => array("class" => "text-center", "width" => "5%."),
                                        "headerHtmlOptions" => array("class" => "text-center")
                                    ),
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
                                                    <li>{addAppointment}</li> 
                                                    <li>{quickAppointment}</li>
                                                    <li>{updateRecord}</li>
                                                    <li>{deleteRecord}</li>
                                                    <!--<li>{familyTree}</li>-->                                                                                                 
                                                </ul>
                                            </div>
                                        </div>',
                                        "buttons" => array(
                                            "updateRecord" => array(
                                                "label" => '<i class="icon ico-pencil"></i> ' . common::translateText("UPDATE_BTN_TEXT"),
                                                "imageUrl" => false,
                                                "url" => 'Yii::app()->createUrl("/admin/patients/update", array("id"=>$data->id))',
                                                "options" => array("class" => "addUpdateRecord mr5", "title" => common::getTitle("patients/update")),
                                                "visible" => ($updateRight) ? 'true' : 'false',
                                            ),
                                            "deleteRecord" => array(
                                                "label" => '<i class="icon ico-trash"></i> ' . common::translateText("DELETE_BTN_TEXT"),
                                                "imageUrl" => false,
                                                "url" => 'Yii::app()->createUrl("/admin/patients/delete", array("id"=>$data->id))',
                                                "options" => array("class" => "deleteRecord text-danger mr5", "title" => common::getTitle("patients/delete")),
                                                "visible" => ($deleteRight) ? 'true' : 'false',
                                            ),
                                            "addAppointment" => array(
                                                "label" => '<i class="icon ico-calendar"></i> ' . common::getTitle("appointments/add"),
                                                "imageUrl" => false,
                                                "url" => 'Yii::app()->createUrl("/admin/appointments/add", array("Appointments[patient_id]"=>$data->id))',
                                                "options" => array("class" => "mr5 addAppointment-No", "title" => common::getTitle("appointments/add")),
                                                //"visible" => (common::isCompounder()) ? 'true' : 'false',
												"visible" => 'false',
                                            ),
                                            "quickAppointment" => array(
                                                "label" => '<i class="icon ico-calendar"></i> ' . common::getTitle("appointments/quick"),
                                                "imageUrl" => false,
                                                "url" => 'Yii::app()->createUrl("/admin/appointments/quick", array("Appointments[patient_id]"=>$data->id))',
                                                "options" => array("class" => "mr5", "title" => common::getTitle("appointments/quick")),
                                                //"visible" => (common::isSuperAdmin() || common::isDoctor()) ? 'true' : 'false',
												//"visible" => 'true',
                                            ),
                                            "familyTree"=>array(
                                                "label"=>'<i class="icon ico-tree"></i> Family Tree',
                                                "imageUrl"=>false,
                                                "url"=>'Yii::app()->createUrl("/admin/family/tree", array("id"=>$data->id))',
                                                "options"=>array("class"=>"mr5","title"=>"Family Tree"),
                                                "visible"=>'true',
                                            ),
                                        ),
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
                            var totalRecs = $('input[type=checkbox]:checked').not('#patients-grid_c0_all').length;
                            totalRecs = (totalRecs=='0')?'this':totalRecs;
                            if(!confirm('Are you sure to delete '+totalRecs+' patient ?')) return false;                        
                            var url = $(this).attr('href');
                            $.post(url,idList,function(res){
                                $.fn.yiiGridView.update('patients-grid');
                                $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow');
                            });
                            return false;
                        });
                        $('.addAppointment').live('click',function() {                        
                            var url = $(this).attr('href');
                            $.post(url,function(html){
                                $('#modalContainer').html(html);
                                $('#modalContainer .modal').modal();              
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

<script type="text/javascript">
    $(".expand-collapse").live('click', function() {
        var obj =  $(this);
        var url = "<?php echo CController::createUrl('common/getpatientchild', array('id' => "patient_id"));?>";
        url = url.replace("patient_id", obj.attr('data-patient_id'));
        var parentObj = $(this).parent().parent();
        if(obj.hasClass('ico-plus')) {
            obj.removeClass('ico-plus');
            obj.addClass('ico-minus');
            $.get(url, function(data) {
                parentObj.after("<tr class='additional-row'><td colspan='8'>"+data+"</td></tr>");
            });
        } else {
            obj.addClass('ico-plus');
            obj.removeClass('ico-minus');
            parentObj.next('.additional-row').remove();
        }
    });
</script>