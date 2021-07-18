<div class="row nm diagnosis-parent" id="cloneMe">
   <?php echo CHtml::hiddenField("DiagnosisTreatments[$c][id]",$id,array("class"=>"ids")); ?>
   <div class="col-md-3">
        <div class="form-group">
            <?php echo CHtml::Label("Group", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("DiagnosisTreatments[$c][medicine_group_id]",$medicine_group_id, $medicineGroups, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required medicine-groups form-control")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo CHtml::Label("Medicine", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("DiagnosisTreatments[$c][medicine_id]",$medicine_id, $medicines, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required medicines form-control")); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <?php echo CHtml::Label("Dosage", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("DiagnosisTreatments[$c][doseage_id]",$doseage_id, $doseages, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required doseages form-control")); ?>
        </div>
    </div>
    <div class="col-md-2 daysContainer" style="visibility:<?php echo MedicineMaster::model()->findByPk($medicine_id)->is_internal == '2' ? "visible": "hidden"; ?>">
        <div class="form-group">
            <?php echo CHtml::Label("Days", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("DiagnosisTreatments[$c][days]",$days, $daysArr, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "days form-control")); ?>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <?php echo CHtml::Label("&nbsp;", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::Link('<i class="ico ico-trash"></i>', "javascript:;", array("class" => "text-center form-control","onclick"=>'deletemore(this);')); ?>
        </div>
    </div>
</div>
