<div class="container-fluid">
    <?php
	
	
    if (!$model->today):
        $this->renderPartial("application.modules.admin.views.appointments._search", array("model" => $model));
    endif;
    $this->renderPartial("application.modules.admin.views.layouts._message");
    $updateRight = common::checkActionAccess("appointments/index");
    $deleteRight = common::checkActionAccess("appointments/delete");
	
    $columnClass = (!$updateRight && !$deleteRight) ? "hide" : "";
    $viewRight = common::checkActionAccess("patients/view");
    $treatmentRight = common::checkActionAccess("treatments/details");
    $dataProvider = $model->search();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;<?php
                                echo common::getTitle("appointments/index");
                                //echo ($model->today) ? " ( <span id='attnCnt'>" . count($dataProvider->getData()) . "</span> ) " : "";
                                ?></span>  
                        </div>
                    </div>
                    <div class="panel-toolbar text-right">
                        <?php
                        if ($model->today && common::checkActionAccess("appointments/index")):
                            echo CHtml::Link(common::translateText("VIEW_MORE_LABEL") . ' <i class="ico-search"></i>', array("appointments/index"), array(
                                "title" => common::translateText("VIEW_MORE_LABEL"),
                                "class" => "btn btn-sm btn-default",
                            ));
                        endif;
                        //if ($deleteRight && !$model->today) :
						if ($deleteRight) :
                            echo CHtml::Link('<i class="ico-remove3"></i>', array("/admin/appointments/delete"), array("class" => "ml5 btn btn-sm btn-danger deleteRecord multipleDelete"));
                        endif;
                        ?>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "appointments-grid",
                        "dataProvider" => $dataProvider,
//                        'rowCssClassExpression' => '!empty($data->is_treatment_given)?"success":""',
                        'rowCssClassExpression' => 'empty($data->is_treatment_given)?"success":""',
                        "columns" => array(
                            array(
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => 2,
                                'value' => '$data["id"]',
                                "checkBoxHtmlOptions" => array("name" => "idList[]"),
                            ),
                            array(
                                "header" => "#",
                                "name" => "token_number",
                                "value" => '!empty($data->token_number)?$data->token_number:"' . common::translateText("NOT_AVAILABLE_TEXT") . '"'
                            ),
                            array(
                                'header' => 'Date Time',
                                'name' => 'appointment_time',
                                'value' => function($data, $row) {
                                    return $data->appointment_date . " " . $data->appointment_time;
                                }
                            ),
                            array(
                                "header" => "Patient",
                                "name" => "patient_id",
                                "value" => function($data, $row) {
                                    $patient_name = !empty($data->patientRel->patient_name) ? @$data->patientRel->patient_name : common::translateText("NOT_AVAILABLE_TEXT");
                                    if (!empty($data->patientRel->birth_date)):
                                        $ageArr = common::getAgeFromDate(@$data->patientRel->birth_date);
                                        $years = !empty($ageArr["years"]) ? $ageArr["years"] : 0;
                                        $months = !empty($ageArr["months"]) ? $ageArr["months"] : 0;
                                        $days = !empty($ageArr["days"]) ? $ageArr["days"] : 0;
                                        return $patient_name . "<br>" . "Age : " . $years . " Years, " . $months . " Months, " . $days . " Days";
                                    else:
                                        return $patient_name;
                                    endif;
                                },
                                "type" => "raw",
                                "htmlOptions" => array("class" => "text-center"),
                                "headerHtmlOptions" => array("class" => "text-center")
                            ),
                            array(
                                "header" => "Family",
                                "name" => "patientRel.family_id",
                                "value" => function($data, $row) {
                                   // $family = !empty($data->patientRel->familyRel->patient_name) ? @$data->patientRel->familyRel->patient_name : common::translateText('NOT_AVAILABLE_TEXT');
                                   // $relation = !empty($data->patientRel->relationArr[@$data->patientRel->relation]) ? @$data->patientRel->relationArr[@$data->patientRel->relation] : common::translateText('NOT_AVAILABLE_TEXT');
                                    $family = !empty($data->patientRel->familyRel->patient_name) ? @$data->patientRel->familyRel->patient_name : @$data->patientRel->patient_name;
                                    $relation = !empty($data->patientRel->relationArr[@$data->patientRel->relation]) ? @$data->patientRel->relationArr[@$data->patientRel->relation] : "Own";
                                    return $family . "<br />" . $relation;
                                },
                                "type" => "raw",
                                "htmlOptions" => array("class" => "text-center"),
                                "headerHtmlOptions" => array("class" => "text-center")
                            ),
                            array(
                                "header" => "Contact",
                                "name" => "patientRel.email_address",
                                "value" => function($data, $row) {
                                    $contact2 = !empty($data->patientRel->contact_number2) ? "," . $data->patientRel->contact_number2 : "";
                                    return common::EmailAddress(@$data->patientRel->email_address, true) . "<br>" . @$data->patientRel->contact_number . $contact2;
                                },
                                "type" => "raw"
                            ),
                            array(
                                "name" => "patientRel.blood_group",
                                "value" => '!empty($data->patientRel->bloodGroupArr[@$data->patientRel->blood_group])?@$data->patientRel->bloodGroupArr[@$data->patientRel->blood_group]:"' . common::translateText('NOT_AVAILABLE_TEXT') . '"',
                                "htmlOptions" => array("class" => "text-center"),
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
                                                    <li>{treatments}</li>
                                                    <li>{updateRecord}</li>
                                                    <li>{deleteRecord}</li>
                                                </ul>
                                            </div>
                                        </div>',
                                "buttons" => array(
                                    "updateRecord" => array(
                                        "label" => '<i class="icon ico-pencil"></i> ' . common::translateText("UPDATE_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/admin/appointments/update", array("id"=>$data->id))',
                                        "options" => array("class" => "NoaddUpdateRecord mr5", "title" => common::getTitle("patients/update")),
                                        "visible" => ($updateRight) ? 'empty($data->is_treatment_given) ? true : false' : 'false',
                                    ),
                                    "treatments" => array(
                                        "label" => '<i class="icon ico-eyedropper2"></i> ' . common::getTitle("treatments/details"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/admin/treatments/details", array("Treatments[appointment_id]"=>$data->id,"Treatments[patient_id]"=>$data->patient_id))',
                                        "options" => array("class" => "mr5", "title" => common::getTitle("treatments/details")),
                                        "visible" => '( "' . $treatmentRight . '" && !$data->is_treatment_given && (common::isSuperAdmin() || common::isDoctor())) ? true : false',
                                    ),
                                    "deleteRecord" => array(
                                        "label" => '<i class="icon ico-cancel"></i> ' . common::translateText("CANCEL_BTN_TEXT"),
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/admin/appointments/delete", array("id"=>$data->id))',
                                        "options" => array("class" => "deleteRecord text-danger mr5", "title" => common::getTitle("patients/delete")),
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
                            var totalRecs = $('input[type=checkbox]:checked').not('#appointments-grid_c0_all').length;
                            totalRecs = (totalRecs=='0')?'this':totalRecs;
                            if(!confirm('Are you sure to delete '+totalRecs+' appointments ?')) return false;                                               
                            var url = $(this).attr('href');
                            $.post(url,idList,function(res){
                                $.fn.yiiGridView.update('appointments-grid');
                                $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow');
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