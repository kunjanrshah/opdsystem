<div class="panel-heading"><span class="panel-title">Treatment Histories</span></div>
<div class="panel-body pt0">
    <div id="accordion2" class="panel-group panel-group-compact">
        <?php
        $PatientTreatments = Patients::model()->getPatientTreatments($model->patient_id);
        $DiagnosisList = DiagnosisMaster::model()->getDiagnosisList();
        $complains = ComplainsMaster::model()->getComplainsList();
        ?>
        <?php
        if (!empty($PatientTreatments)) : $i = 1;
            foreach ($PatientTreatments as $value) :
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="collapsed" href="#collapseOne<?php echo $i; ?>" data-parent="#accordion<?php echo $i + 1; ?>" data-toggle="collapse">
                                <span class="plus mr5"></span><?php echo $value->created_dt; ?>
                            </a>                            
                        </h4>
                    </div>
                    <div class="panel-collapse <?php echo ($value->id != $id) ? "collapse" : ""; ?>" id="collapseOne<?php echo $i; ?>" style="height: 0px;">
                        <div class="panel-body">
                            <div class="row">                                
                                <br />
                                <div class="col-lg-8">
                                    <div class="col-md-12">
                                        <span class="semibold">Diagnosis :</span>
                                        <span><?php echo!empty($DiagnosisList[$value->diagnosis_id]) ? $DiagnosisList[$value->diagnosis_id] : common::translateText("NOT_AVAILABLE_TEXT"); ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <span class="semibold">Complains :</span>
                                        <span>
                                            <?php
                                            $complainsArr = array();
                                            if (!empty($value->complains_id)): foreach ($value->complains_id as $complain_id):
                                                    if (!empty($complains[$complain_id])) :
                                                        $complainsArr[] = $complains[$complain_id];
                                                    endif;
                                                endforeach;
                                            endif;
                                            echo!empty($complainsArr) ? implode(", ", $complainsArr) : common::translateText("NOT_AVAILABLE_TEXT");
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <table cellpadding="3" cellspaing="3" width="100%">
                                        <tr>
                                            <td><b>Height</b></td>
                                            <td><?php echo!empty($value->patient_height) ? $value->patient_height : "N/A"; ?></td>
                                            <td><b>Weight</b></td>
                                            <td><?php echo!empty($value->patient_width) ? $value->patient_width : "N/A"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Pressure</b></td>
                                            <td><?php echo!empty($value->patient_pressure) ? $value->patient_pressure : "N/A"; ?></td>
                                            <td><b>Temperature</b></td>
                                            <td><?php echo!empty($value->patient_temp) ? $value->patient_temp : "N/A"; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Blood Group</b></td>
                                            <td colspan="3"><?php echo!empty($value->patientRel->bloodGroupArr[$value->patientRel->blood_group]) ? $value->patientRel->bloodGroupArr[$value->patientRel->blood_group] : "N/A"; ?></td>                                            
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br >
                            <hr />                             
                            <div class="row" style="padding:10px;">
                                <div class="table-responsive panel-collapse pull out">
                                    <table  class="table table-bordered table-hover">
                                        <thead>
                                            <tr>                                                
                                                <th>Medicine</th>
                                                <th>Type</th>
                                                <th>Dosage</th>
                                                <th class="text-center" width="5%">Days</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $printPrescription = false;
                                            if (!empty($value->treatmentDetailsRel)): foreach ($value->treatmentDetailsRel as $dValue):
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo!empty($dValue->medicineRel) ? $dValue->medicineRel->medicine_name : "N/A"; ?> 
                                                        </td>  <td> 
                                                            <?php
                                                            echo ($dValue->medicineRel->is_internal == MedicineMaster::INTERNAL) ? "Internal" : "External";
                                                            $printPrescription = ($dValue->medicineRel->is_internal == MedicineMaster::EXTERNAL) ? true : $printPrescription;
                                                            ?>
                                                        </td>             
                                                        <td>
                                                            <?php echo!empty($dValue->doseageRel) ? $dValue->doseageRel->dosage_name : "N/A"; ?>
                                                        </td>
                                                        <td class="text-center" width="5%">
                                                            <?php echo!empty($dValue->days) ? $dValue->days : "N/A"; ?>
                                                        </td>                                                
                                                    </tr>
                                                    <?php
                                                endforeach;
                                            else:
                                                ?>
                                                <tr>
                                                    <td class="text-center" colspan="3">No medicine given.</td>                                                
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="padding:10px;">
                                <div class="table-responsive panel-collapse pull out">
                                    <table  class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Charge</th>
                                                <th class="text-center" width="10%">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($value->treatmentChargesRel)): foreach ($value->treatmentChargesRel as $dValue): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo!empty($dValue->chargeRel->charge_title) ? $dValue->chargeRel->charge_title : "N/A"; ?>
                                                        </td>
                                                        <td class="text-right" width="1%">
                                                            <?php $amount = !empty($dValue->amount) ? $dValue->amount : 0; ?>
                                                            <?php echo common::formatCurrency($amount); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                    <td class="text-left">    
                                                        <div class="col-md-11">
                                                            <b>Credit :</b><?php
                                                            $c = !empty($value->credit_amount) ? $value->credit_amount : 0;
                                                            echo common::formatCurrency($c);
                                                            ?>
                                                            &nbsp;&nbsp;
                                                            <b>Debit :</b><?php
                                                            $d = !empty($value->debit_amount) ? $value->debit_amount : 0;
                                                            echo common::formatCurrency($d);
                                                            ?>                                                            
                                                        </div>
                                                        <div class="col-md-1">
                                                            <b class="text-right">Total</b>
                                                        </div>
                                                    </td>
                                                    <td class="text-right"><?php echo common::formatCurrency($c + $d); ?></td>
                                                </tr>
                                            <?php else:
                                                ?>
                                                <tr>
                                                    <td class="text-center" colspan="2">No charges applied.</td>                                                
                                                </tr>
                                            <?php endif; ?>
                                            <?php if ($printPrescription): ?>
                                                <tr>
                                                    <td class="text-left" colspan="2">
                                                        <?php echo CHtml::Link("Print Prescription", array("/admin/treatments/prescription", "id" => $value->id, "button-type"=> "back")); ?>
                                                        &nbsp;|&nbsp;
                                                        <?php echo CHtml::Link("Print Case Paper", array("/admin/treatments/casepaper", "id" => $value->id, "button-type"=> "back")); ?>
                                                    </td>
                                                </tr>                                                          
                                                <?php
                                                $printPrescription = FALSE;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <br />
        <?php if (!empty($value->reamarks)): ?>
                                <div class="row">
                                    <div class="col-md-12">                                    
                                        <span>Remarks : <?php echo!empty($value->remarks) ? $value->remarks : "N/A"; ?></span>
                                    </div>
                                </div>
                                <br />
        <?php endif; ?>
                            <div class="row text-center">
                                <div class="col-md-12"></div>
                                <div class="col-md-12"></div>
                                <div class="col-md-12"></div>
                            </div>
                        </div>
                    </div>
                <?php $i++; ?>
                </div>
                <?php
            endforeach;
        else:
            echo "Not available";
        endif;
        ?>

    </div>