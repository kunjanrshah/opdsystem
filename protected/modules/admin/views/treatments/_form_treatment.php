<?php
$criteria = new CDbCriteria();
$criteria->condition="is_internal='1'";
$criteria->order = "medicine_name ASC";
$medicinesModel = MedicineMaster::model()->findAll($criteria);

$criteria = new CDbCriteria();
$criteria->condition="is_internal!='1'";
$criteria->with = "groupRel";
$criteria->together = true;
$criteria->order = "medicine_name ASC";
$medicinesModel2 = MedicineMaster::model()->findAll($criteria);

$medicines = array("Internal" => CHtml::ListData($medicinesModel, 'id', 'medicineNameFormated')) + array("External" => CHtml::ListData($medicinesModel2, 'id', 'medicineNameFormated'));

$doseages = CHtml::ListData(DosagesMaster::model()->findAll(), "id", "dosage_name");
$charges = CHtml::ListData(ChargesMaster::model()->findAll(), "id", "charge_title");
$chargesAmount = CHtml::ListData(ChargesMaster::model()->findAll(), "id", "amount");
$daysArr = array_combine(range(1, 30), range(1, 30));
$action = !$model->isNewRecord ? "update" : "add";
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'form-treatment',
    "action" => ($action != "update")?array("treatments/" . $action, "Treatments[appointment_id]" => $model->appointment_id, "Treatments[patient_id]" => $model->patient_id) : array("treatments/" . $action, "Treatments[appointment_id]" => $model->appointment_id, "Treatments[patient_id]" => $model->patient_id,"Treatments[id]" => $model->id),
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onsubmit' => 'return validateAddMore();')));
$hide = (empty($model->patient_id) || empty($model->appointment_id)) ? "hide" : "hide";
?>
<div class="row nm <?php echo $hide; ?>">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_id", array("class" => "control-label")); ?>
            <?php echo common::select2($model, "patient_id", Patients::model()->getPatientsList(), array("prompt" => common::translateText("DROPDOWN_TEXT"), "class" => "form-control")); ?>  
            <?php echo $form->error($model, "patient_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "appointment_id", array("class" => "control-label")); ?>            
            <?php echo common::select2($model, "appointment_id", Appointments::model()->getAppointmentsList($model->patient_id), array("class" => "form-control", "prompt" => common::translateText("DROPDOWN_TEXT"))); ?>
            <?php echo $form->error($model, "appointment_id", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_width", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "patient_width", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_width"))); ?>
                <i class="ico-map-marker form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "patient_width", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_pressure", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "patient_pressure", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_pressure"))); ?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "patient_pressure", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_temp", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "patient_temp", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_temp"))); ?>
                <i class="ico-map-marker form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "patient_temp", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_height", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "patient_height", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_height"))); ?>
                <i class="ico-map-marker form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "patient_height", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo $form->labelEx($model, "patient_bmi", array("class" => "control-label")); ?>
            <div class="has-icon pull-left">
                <?php echo $form->textField($model, "patient_bmi", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("patient_bmi"))); ?>
                <i class="ico-envelop form-control-icon"></i>
            </div>
            <?php echo $form->error($model, "patient_bmi", array("class" => "parsley-custom-error-message")); ?>
        </div>
    </div>
</div>
<div class="row nm">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo $form->labelEx($model, "diagnosis_id", array("class" => "control-label")); ?>
            <?php echo common::select2($model, "diagnosis_id", DiagnosisMaster::model()->getDiagnosisList(), array("class" => "form-control", "multiple" => false, 'onchange' => 'getTreatments()', "prompt" => common::translateText("DROPDOWN_TEXT"))); ?>
            <?php echo $form->error($model, "diagnosis_id", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group cutom-select-box">
            <?php echo $form->labelEx($model, "complains_id", array("class" => "control-label")); ?>
            <?php echo common::select2($model, "complains_id", ComplainsMaster::model()->getComplainsList(), array("class" => "form-control", "multiple" => TRUE, /* 'onchange' => 'getTreatments()' */)); ?>
            <?php echo $form->error($model, "complains_id", array("class" => "parsley-custom-error-message")); ?>                                       
        </div>
    </div> 
    <div class="clearfix"></div>
    <div id="cloneContainer">
        <?php
        $c = 0;
        $DiagnosisTreatments = TreatmentDetails::model()->findAllByAttributes(array("treatment_id" => $model->id));
        //echo count($DiagnosisTreatments);
        if (!empty($DiagnosisTreatments)): foreach ($DiagnosisTreatments as $value):
                $this->renderPartial("_treatment_details", array("medicines" => $medicines, "doseages" => $doseages, "medicine_id" => $value->medicine_id, "doseage_id" => $value->doseage_id, "c" => $c, "id" => $value->id, "daysArr" => $daysArr, "days" => $value->days));
                $c++;
            endforeach;
        endif;
        ?>
        <hr />
    </div>
    <div class="col-md-12">
        <a class="btn btn-sm btn-success pull-right m-t-n-xs tr_clone_add" href="javascript:;" onclick="cloneMe(0, 0, 1);" >
            <strong>Add Medicine</strong>
        </a>
    </div>
    <div class="clearfix"></div>
    <div id="cloneContainerCharge">
        <?php
        $c1 = 0;
        $TreatmentCharges = TreatmentCharges::model()->findAllByAttributes(array("treatment_id" => $model->id));
        if (!empty($TreatmentCharges)): foreach ($TreatmentCharges as $value):
                $this->renderPartial("_treatment_charges", array("charges" => $charges, "amount" => $value->amount, "charge_id" => $value->charge_id, "c1" => $c1, "id" => $value->id));
                $c1++;
            endforeach;
        endif;
        ?>
    </div>
    <div class="row nm">
        <!--<div class="form-group">-->
            <div class="col-md-8 col-sm-8">
                <div class="form-group" style="margin-top: 18px;">
                    <!--    <a type="button" class="btn btn-default" href="<?php echo Yii::app()->createUrl("/admin/appointments/index"); ?>"><?php echo common::translateText("CANCEL_BTN_TEXT"); ?></a>-->
                    <button type="submit" name="prescription" class="btn btn-primary"><?php echo "Prescription"; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo "Case Paper"; ?></button>
                    <button type="submit" name="next" class="btn btn-primary" onclick="return confirm('Are you sure? You want to save Treatment.');"><?php echo "Next"; ?></button>
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="form-group">
                <?php echo $form->labelEx($model, "credit_amount", array("class" => "control-label")); ?>
                <?php echo $form->textField($model, "credit_amount", array("class" => "form-control")); ?>
                <?php echo $form->error($model, "credit_amount", array("class" => "parsley-custom-error-message")); ?> 
                </div>
            </div>
            <div class="col-md-2 col-sm-2">
                <div class="form-group">
                <?php echo $form->labelEx($model, "debit_amount", array("class" => "control-label")); ?>
                <?php echo $form->textField($model, "debit_amount", array("class" => "form-control", "readonly" => true)); ?>
                <?php echo $form->error($model, "debit_amount", array("class" => "parsley-custom-error-message")); ?>  
                </div>
            </div>    
            </div>
        <!--</div>-->         
        <div class="row nm">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo $form->labelEx($model, "remarks", array("class" => "control-label")); ?>
                    <?php echo $form->textArea($model, "remarks", array("class" => "form-control")); ?>
                    <?php echo $form->error($model, "remarks", array("class" => "parsley-custom-error-message")); ?>                                       
                </div>
            </div>
        </div>
     
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    var c = <?php echo $c; ?>;
    var c1 = <?php echo $c1; ?>;
    var chargesAmount = '<?php echo json_encode($chargesAmount); ?>';
    function cloneMeCharge(chargeObj) {

        if (chargeObj) {
            var charge_id = chargeObj.value;
            var chargesAmountObj = $.parseJSON(chargesAmount);
            //console.log(chargesAmountObj[charge_id]);            
            var chargeIdentity = chargeObj.id
            var amountIdentity = chargeIdentity.replace("charge_id", "amount");
            // console.log(amountIdentity);
            var previousVal = $("#" + amountIdentity).val();
            $("#" + amountIdentity).val(chargesAmountObj[charge_id]);
			udpateDebitAmount()
            if (previousVal != 0) {
                return false;
            }
        }

        $clone = $('#cloneMeCharge').clone();
        $clone.find('select.charges').attr('name', 'TreatmentCharges[' + c1 + '][charge_id]');
        $clone.find('select.charges').attr('id', 'TreatmentCharges_' + c1 + '_charge_id');
        $clone.find('select.charges').val("");

        $clone.find('input.amount').attr('name', 'TreatmentCharges[' + c1 + '][amount]');
        $clone.find('input.amount').attr('id', 'TreatmentCharges_' + c1 + '_amount');
        $clone.find('input.amount').val("0");

        $clone.find('.delCharge').attr('id', 'TreatmentCharges_' + c1 + '_delete');

        $("#cloneContainerCharge").append($clone);
        $clone.removeAttr("id", "cloneMeCharge");

        // console.log(c1);
        $(".amount").parent("div").show();
        $('#TreatmentCharges_' + c1 + '_amount').parent("div").hide();

        $(".delCharge").parent("div").show();
        $('#TreatmentCharges_' + c1 + '_delete').parent("div").hide();
        c1++;
    }

    function udpateDebitAmount() {
        var debit_amount = 0;
        $("#cloneContainerCharge").find(".amount").each(function (i, v) {
            debit_amount = Number(v.value) + Number(debit_amount);
        });
        $("#Treatments_debit_amount").val(0);
        $("#Treatments_credit_amount").val(debit_amount);
    }
    $("#Treatments_credit_amount").change(function () {
        var new_credit = parseInt($(this).val());
        udpateDebitAmount();
        var credit = parseInt($(this).val());
        // var debit = $("#Treatments_debit_amount").val();
        if(new_credit <=  credit) {
            $("#Treatments_debit_amount").val(Number(credit) - Number(new_credit));
			$("#Treatments_credit_amount").val(Number(new_credit))
        } else {
            $("#Treatments_debit_amount").val(0);
        }
        // if (debit != '' && credit != '' && debit != '0' && credit != '0') {
        //     var final = Number(debit) - Number(credit);
        //     $("#Treatments_debit_amount").val(final)
        // }
    });

    function cloneMe(medicine_id, doseage_id, days) {
        $clone = $('#cloneMe').clone();
        $clone.find('select.medicines').attr('name', 'TreatmentDetails[' + c + '][medicine_id]');
        $clone.find('select.medicines').attr('id', 'TreatmentDetails_' + c + '_medicine_id');
        $clone.find('select.medicines').val(medicine_id);

        $clone.find('select.doseages').attr('name', 'TreatmentDetails[' + c + '][doseage_id]');
        $clone.find('select.doseages').attr('id', 'TreatmentDetails_' + c + '_doseage_id');
        $clone.find('select.doseages').val(doseage_id);

        $clone.find('.days').attr('name', 'TreatmentDetails[' + c + '][days]');
        $clone.find('.days').attr('id', 'TreatmentDetails_' + c + '_days');
        $clone.find('.days').val(days);

        if (medicine_id == 0) {
            $clone.find('select').not(".days").val('0');
            $clone.find('input').val('');
        }
        c++;
        $("#cloneContainer").append($clone);
        $clone.removeAttr("id", "cloneMe");
    }
    function deteteThisCharge(obj) {
        $(obj).parent().parent().parent().remove();
        udpateDebitAmount();
        //$("#Treatments_credit_amount").val(0);
    }
    function deteteThis(obj) {
        $(obj).parent().parent().parent().remove();
    }
    function getTreatments() {
        $("#cloneContainer").html("");
        $.ajax({
            url: '<?php echo $this->createUrl("/admin/treatments/gettreatments"); ?>',
            type: "POST",
            dataType: "JSON",
            data: $("#form-treatment").serialize(),
            success: function (response) {
                $("#Treatments_complains_id").select2("destroy");
                $("#Treatments_complains_id").html(response.options);
                $("#Treatments_complains_id").select2();

                if (response.treatments) {
                    $.each(response.treatments, function (i, v) {
                        cloneMe(v.medicine_id, v.doseage_id, v.days);
                    });
                }
            }
        });
    }
//    $("select").removeClass("form-control");
    $("select").css("width", "100%");
    $(document).ready(function () {
        cloneMeCharge();
        $("#chargeDel").hide();
    });
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
</script>
<div class="hide">
    <?php
    $this->renderPartial("_treatment_details", array("medicines" => $medicines, "doseages" => $doseages, "medicine_id" => "", "doseage_id" => "", "c" => 0, "id" => "", "days" => "1", "daysArr" => $daysArr));
    $this->renderPartial("_treatment_charges", array("charges" => $charges, "amount" => 0, "charge_id" => "", "c1" => $c1, "id" => ""));
    ?>
</div>
<style>
    .has-error{
        border-color: #ed5565;
    }
    .cutom-select-box .select2-choices{
        border-radius: 4px; border: 1px solid #cfd9db; min-height: 34px;
    }
    #cloneContainer > :not(:nth-child(1)) .control-label {
        display: none;
    }  
    .modal-footer {
        border: none;
        float: left;
    }
</style>