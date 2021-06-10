<div class="row nm" id="cloneMe">
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <?php echo CHtml::Label("Medicine", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("TreatmentDetails[$c][medicine_id]", $medicine_id, $medicines, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required medicines form-control")); ?>
        </div>
    </div>
    <div class="col-md-3 col-sm-3">
        <div class="form-group">
            <?php echo CHtml::Label("Dosage", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("TreatmentDetails[$c][doseage_id]", $doseage_id, $doseages, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required doseages form-control")); ?>
        </div>
    </div>
    <div class="col-md-2 col-sm-2">
        <div class="form-group">
            <?php echo CHtml::Label("Days", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("TreatmentDetails[$c][days]", $days, $daysArr, array("class" => "addmore-required days form-control")); ?>
        </div>
    </div>
    <div class="col-md-1 col-sm-1">
        <div class="form-group">
            <?php echo CHtml::Label("&nbsp;", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::Link('<span class="text-center"><i class="ico ico-trash text-danger"></i></span>', "javascript:;", array("class" => "text-center form-control", "onclick" => 'deteteThis(this);')); ?>
        </div>
    </div>
</div>
