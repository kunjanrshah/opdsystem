<?php $dataProvider = $model->search(); ?>
<div class="container-fluid">    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-toolbar-wrapper pl0 pt5 pb5">
                    <div class="panel-toolbar pl10">
                        <div class="pull-left">
                            <span class="semibold">&nbsp;&nbsp;<?php
                                echo common::getTitle("treatments/index");
                                echo ($model->today) ? " ( " . count($dataProvider->getData()) . " ) " : "";
                                ?></span>  
                        </div>
                        <div class="panel-toolbar text-right">
                            <?php
                            if ($model->today && common::checkActionAccess("treatments/index")):
                                echo CHtml::Link(common::translateText("VIEW_MORE_LABEL") . ' <i class="ico-search"></i>', array("treatments/index"), array(
                                    "title" => common::translateText("VIEW_MORE_LABEL"),
                                    "class" => "btn btn-sm btn-default",
                                ));
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">                  
                    <?php
                    $detailRights = common::checkActionAccess("treatments/details");
                    $columnClass = (!$detailRights) ? "hide" : "";
                    $this->widget("zii.widgets.grid.CGridView", array(
                        "id" => "treatments-grid",
                        "dataProvider" => $dataProvider,
                        "columns" => array(
                            array(
                                'header' => 'Date Time',
                                'name' => 'created_dt',
                                'value' => '$data->created_dt'
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
                                        return $patient_name . " ( ID : " . $data->patientRel->id . " ) <br>" . "Age : " . $years . " Years, " . $months . " Months, " . $days . " Days";
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
//                                    $family = !empty($data->patientRel->familyRel->patient_name) ? @$data->patientRel->familyRel->patient_name : common::translateText('NOT_AVAILABLE_TEXT');
//                                    $relation = !empty($data->patientRel->relationArr[@$data->patientRel->relation]) ? @$data->patientRel->relationArr[@$data->patientRel->relation] : common::translateText('NOT_AVAILABLE_TEXT');
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
                                    return common::EmailAddress(@$data->patientRel->email_address, true) . "<br>" . @$data->patientRel->contact_number;
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
                                "template" => '{viewTreatments}',
                                "buttons" => array(
                                    "viewTreatments" => array(
                                        "label" => '<i class="icon ico-search"></i>',
                                        "imageUrl" => false,
                                        "url" => 'Yii::app()->createUrl("/admin/treatments/details", array("id"=>$data->id,"Treatments[patient_id]"=>$data->patient_id,"Treatments[appointment_id]"=>$data->appointment_id))',
                                        "options" => array("class" => "mr5", "title" => common::getTitle("treatments/index")),
                                        "visible" =>  '( "'.$detailRights.'" && !$data->is_treatment_given) ? true : false',
                                    ),
                                ),
                            ),
                        ),
                    ));
                    ?>                    
                </div>
                <!--/ panel body with collapse capabale -->
            </div> 
        </div>      
    </div>
    <!--/ END row -->
</div>
<!--/ END Template Container -->