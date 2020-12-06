<div class="row nm" id="cloneMeCharge">
    <div class="col-md-8 col-sm-8">
        <div class="form-group">
            <?php echo CHtml::Label("Charge", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::dropDownList("TreatmentCharges[$c1][charge_id]", $charge_id, $charges, array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => " charges form-control","onchange"=>"cloneMeCharge(this);")); ?>
        </div>
    </div>
    <div class="col-md-2 col-sm-2">
        <div class="form-group">
            <?php echo CHtml::Label("Amount", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::textField("TreatmentCharges[$c1][amount]",$amount, array("class" => " amount form-control","onchange"=>"udpateDebitAmount();")); ?>
        </div>
    </div>
    <div class="col-md-2 col-sm-2">
        <div class="form-group">
            <?php echo CHtml::Label("&nbsp;", "&nbsp;", array("class" => "control-label")); ?>
            <?php echo CHtml::Link('<span class="text-center"><i class="ico ico-trash text-danger"></i></span>', "javascript:;", array("class" => "text-center delCharge form-control", "id"=>"TreatmentCharges_".$c1."_delete", "onclick" => 'deteteThisCharge(this);')); ?>
        </div>
    </div>
</div>
