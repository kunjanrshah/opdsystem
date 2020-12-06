<div class="row nm" id="cloneMe">
   <?php echo CHtml::hiddenField("DiagnosisTreatments[$c][id]",$id,array("class"=>"ids")); ?>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo CHtml::Label("Medicine", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("DiagnosisTreatments[$c][medicine_id]",$medicine_id, $medicines, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required medicines form-control")); ?>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <?php echo CHtml::Label("Dosage", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("DiagnosisTreatments[$c][doseage_id]",$doseage_id, $doseages, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "addmore-required doseages form-control")); ?>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <?php echo CHtml::Label("&nbsp;", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::Link('<i class="ico ico-trash"></i>', "javascript:;", array("class" => "text-center form-control","onclick"=>'deletemore(this);')); ?>
        </div>
    </div>
</div>
