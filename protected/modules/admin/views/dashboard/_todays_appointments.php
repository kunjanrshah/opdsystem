<?php


$currentPatients = Patients::model()->getUpcomingPatients();
$updateAppRight = common::checkActionAccess("appointments/index");
$deleteAppRight = common::checkActionAccess("appointments/delete");
?>
<div class="row">
    <div class="col-lg-12">
        <!-- START panel -->
        <div class="panel panel-default">
            <!-- panel heading/header -->
            <div class="panel-heading">
                <h3 class="panel-title ellipsis"><i class="ico-user2 mr5"></i>Today's Appointments (<span id="countContainer"><?php echo count($currentPatients); ?></span>)</h3>
                <!-- panel toolbar -->
                <div class="panel-toolbar text-right">
                    <!-- option -->
                    <?php
                    if (common::checkActionAccess("appointments/add")) :
                        echo CHtml::Link(common::getTitle("appointments/add") . ' <i class="ico-plus"></i>', array("appointments/add"), array(
                            "title" => common::getTitle("appointments/add"),
                            "data-placement" => "bottom",
                            "rel" => "tooltip",
                            "class" => "btn btn-sm btn-default addUpdateRecord mr5",
                            "style"=>"margin-top:2px;",
                            "data-original-title" => common::getTitle("appointments/add")
                        ));
                    endif;
                    ?>
                    <!--/ option -->
                </div>
                <!--/ panel toolbar -->
            </div>
            <!--/ panel heading/header -->
            <!-- panel body with collapse capabale -->
            <div class="table-responsive panel-collapse pull out">
                <table class="table">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Token#</th>
                            <th>Time</th>
                            <th>Title</th>
                            <th>Patient Name</th>   
                            <th>Age</th>
                            <th>Head Name</th>
                            <th>Relation</th>
                            <th>Area</th>
                            <th>City</th>
                            <th>Contact#</th>
                            <th>Blood Group</th>
                            <th>Email Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($currentPatients)) : foreach ($currentPatients as $model): ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox"></td>
                                    <td class="text-center"><?php echo $model->token_number; ?></td>
                                    <td><?php echo $model->appointment_time; ?></td>
                                    <td><?php echo $model->appointment_title; ?></td>
                                    <td><?php echo $model->patientRel->patient_name; ?></td> 
                                    <td>
                                        <?php
                                        $ageArr = common::getAgeFromDate($model->patientRel->birth_date);
                                        echo!empty($ageArr["years"]) ? $ageArr["years"] . " Years" : common::translateText('NOT_AVAILABLE_TEXT');
                                        ?>
                                    </td>
                                    <td><?php echo!empty($model->patientRel->familyRel->family_name) ? $model->patientRel->familyRel->family_name : common::translateText('NOT_AVAILABLE_TEXT'); ?></td>
                                    <td><?php echo!empty($model->patientRel->relationArr[$model->patientRel->relation]) ? $model->patientRel->relationArr[$model->patientRel->relation] : common::translateText('NOT_AVAILABLE_TEXT'); ?></td>  
                                    <td><?php echo $model->patientRel->address2; ?></td>  
                                    <td><?php echo $model->patientRel->city; ?></td>                                                                 
                                    <td><?php echo $model->patientRel->contact_number; ?></td>  
                                    <td><?php echo!empty($model->patientRel->bloodGroupArr[$model->patientRel->blood_group]) ? $model->patientRel->bloodGroupArr[$model->patientRel->blood_group] : common::translateText('NOT_AVAILABLE_TEXT'); ?></td>  
                                    <td><?php echo $model->patientRel->email_address; ?></td>  
                                    <td class="text-center">
                                        <?php
                                        if ($updateAppRight):
                                            echo CHtml::Link('<i class="icon ico-pencil"></i>', array("/admin/appointments/update", "id" => $model->id), array("class" => "addUpdateRecord mr5"));
                                        endif;
                                        ?>
                                        <?php
                                        if ($deleteAppRight):
                                            echo CHtml::Link('<i class="icon ico-trash text-danger"></i>', array("/admin/appointments/delete", "id" => $model->id), array("class" => "deleteRecord mr5"));
                                        endif;
                                        ?>
                                        
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php if (common::checkActionAccess("appointments/index")) : ?>
                                <tr><td>&nbsp;</td><td colspan="12" width="100%" class="pull-right"><?php echo CHtml::Link("View All", array("/admin/appointments")) ?></td></tr>
                            <?php endif; ?>
                            <?php else: ?>
                            <tr><td>&nbsp;</td><td colspan="12">No appointment available.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!--/ panel body with collapse capabale -->
        </div>
        <!--/ END panel -->
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('actions', "
    $('.addUpdateRecord').live('click',function() {                        
        var url = $(this).attr('href');
        $.post(url,function(html){
            $('#modalContainer').html(html);
            $('#modalContainer .modal').modal();              
        });
        return false;
    });
    $('.deleteRecord').live('click',function(el) {
        if(!confirm('" . common::translateText("DELETE_CONFIRM") . "')) return false;                        
        var url = $(this).attr('href');
        $(this).parents('tr').remove();
        $('#countContainer').html(Number($('#countContainer').html())-1);
        $.post(url,function(res){           
            $('#flash-message').html(res).animate({opacity: 1.0}, 3000).fadeOut('slow');
        });
        return false;
    });
");
