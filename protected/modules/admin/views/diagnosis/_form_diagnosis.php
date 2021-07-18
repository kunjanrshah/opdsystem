<?php

$criteria = new CDbCriteria;
$criteria->order = "t.medicine_name ASC";
$medicines = CHtml::ListData(MedicineMaster::model()->findAll($criteria), "id", "medicineTypeMedicineName");
$doseages = CHtml::ListData(DosagesMaster::model()->findAll(), "id", "dosage_name");
$medicineGroups = CHtml::ListData(MedicineGroupMaster::model()->getGroups(), 'id', 'name');
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-diagnosis',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),     
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onsubmit' => 'return validateAddMore();'))
);
$daysArr = array_combine(range(1, 30), range(1, 30));  
?>
<div class="row nm">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "diagnosis_title", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "diagnosis_title", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("diagnosis_title"))); ?>                
            <?php echo $form->error($model, "diagnosis_title", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "complains", array("class" => "control-label")); ?>
            <?php echo common::select2($model, "complains", ComplainsMaster::model()->getComplainsList(), array("class" => "form-control", "multiple" => TRUE)); ?>                
            <?php echo $form->error($model, "complains", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?php echo $form->labelEx($model, "description", array("class" => "control-label")); ?>
            <?php echo $form->textField($model, "description", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("description"))); ?>                
            <?php echo $form->error($model, "description", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div id="cloneContainer">
    <?php
    $c = 0;
    $DiagnosisTreatments = DiagnosisTreatments::model()->findAllByAttributes(array("diagnosis_id"=>$model->id));
    //echo count($DiagnosisTreatments);
    if (!empty($DiagnosisTreatments)): foreach ($DiagnosisTreatments as $value):
            $criteria = new CDbCriteria();
            $criteria->condition = "group_id='".$value->medicine_group_id."'";
            $criteria->order = "medicine_name ASC";
            $model = MedicineMaster::model()->findAll($criteria);
            $this->renderPartial("_diagnosis_treatments", array("daysArr"=>$daysArr,"medicines" => CHtml::ListData(MedicineMaster::model()->findAll($criteria), "id", "medicineTypeMedicineName"), "doseages" => $doseages, "medicine_id" => $value->medicine_id, 'medicineGroups'=>$medicineGroups, "doseage_id" => $value->doseage_id, "medicine_group_id"=>$value->medicine_group_id, "c" => $c, "id" => $value->id));
            $c++;
        endforeach;
    endif;
    ?>
</div>
<div class="modal-footer">
    <a class="btn btn-sm btn-success pull-left m-t-n-xs tr_clone_add" href="javascript:;" onclick="cloneMe();" >
        <strong>Add More</strong>
    </a>
    <button type="button" class="btn btn-default" onclick="js:history.go(-1);"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></button>
    <button type="submit" class="btn btn-primary"><?php echo common::translateText("SUBMIT_BTN_TEXT"); ?></button>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function populateGroups() {
        $("select.medicine-groups").change(function() {
            var obj = $(this);
            var url = '<?php echo Yii::app()->createURL('common/getmedicines');?>';
            url = url + '?id='+obj.val();
            $.get(url, function(response) {
                obj.parent().parent().parent().find('.medicines').html(response);
            });
        });
        $("select.medicines").change(function() {
            var obj = $(this);
            var url = '<?php echo Yii::app()->createURL('common/getmedicine');?>';
            url = url + '?id='+obj.val();
            $.get(url, function(response) {
                const jObj = JSON.parse(response);
                if(jObj.is_internal == '2') { //external
                    obj.parent().parent().parent().find('.daysContainer').css('visibility', 'visible');
                } else {
                  obj.parent().parent().parent().find('.daysContainer').css('visibility', 'hidden');
                }
            });
        });
    }
    function validateAddMore() {
        var ret = true;
        $('.addmore-required:visible').each(function () {
            if ($(this).val() == "") {
                ret = false;
                $(this).parent().addClass('has-error');
            }
            else
            {
                $(this).parent().removeClass('has-error');
            }
        });
        return ret;
    }
    var c = <?php echo $c; ?>;
    function cloneMe() {
        $clone = $('#cloneMe').clone();
        $clone.find('select.medicines').attr('name', 'DiagnosisTreatments[' + c + '][medicine_id]');
        $clone.find('select.medicines').attr('id', 'DiagnosisTreatments_' + c + '_medicine_id');
        $clone.find('select.medicine-groups').attr('name', 'DiagnosisTreatments[' + c + '][medicine_group_id]');
        $clone.find('select.medicine-groups').attr('id', 'DiagnosisTreatments_' + c + 'medicine_group_id');
        $clone.find('select.doseages').attr('name', 'DiagnosisTreatments[' + c + '][doseage_id]');
        $clone.find('select.days').attr('id', 'DiagnosisTreatments_' + c + '_days');
        $clone.find('select.days').attr('name', 'DiagnosisTreatments[' + c + '][days]');
        $clone.find('select.doseages').attr('id', 'DiagnosisTreatments_' + c + '_doseage_id');
        $clone.find('.ids').attr('name', 'DiagnosisTreatments[' + c + '][id]');
        $clone.find('.ids').attr('id', 'DiagnosisTreatments_' + c + '_id');
        $clone.find('select').val('0');
        $clone.find('input').val('');
        c++;
        $("#cloneContainer").append($clone);
        $clone.removeAttr("id", "cloneMe");
        populateGroups();
    }
    function deletemore(obj) {
        $(obj).parent().parent().parent().remove();
    }
    <?php if($model->isNewRecord) { ?>
        $(document).ready(function () {
            cloneMe();
            populateGroups();
        });
    <?php } ?>
</script>
<div class="hide">
<?php
$this->renderPartial("_diagnosis_treatments", array('daysArr'=>$daysArr, 'medicineGroups'=>$medicineGroups, "medicines" => array(), "doseages" => $doseages, "medicine_id" => "","medicine_group_id" => "", "doseage_id" => "", "c" => 0, "id" => ""));
?>
</div>