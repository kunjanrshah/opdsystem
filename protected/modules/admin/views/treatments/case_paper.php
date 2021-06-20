<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="table-layout">
                <!-- Left / Bottom Side -->
                <div class="col-lg-12 panel">
                    <!-- panel body -->
                    <div class="col-lg-12" style="display: flex;justify-content: space-between;">
                        <div>
                            <div class="panel-body text-left">
                                <h4 class="semibold nm"><?php echo $model->patientRel->patient_name; ?> (<?php echo $model->patientRel->id; ?>)</h4>
                                <p class="text-muted nm"><?php echo $model->patientRel->contact_number; ?></p>
                                <p class="text-muted nm"><?php echo $model->patientRel->AreaRel->area_name; ?></p> <?php echo $model->patientRel->city; ?></p>
                                <p class="text-muted nm">Date : <?php echo $model->created_dt; ?></p>
                            </div>
                        </div>
                        <div>
                            <div class="panel-body text-right">
                                <h4 class="semibold nm">Radhe Clinic</h4>
                                <p class="semibold nm" style="font-size: 15px;">Sanjay Shah</p>
                                <p class="text-muted nm">M.B.B.S, M.D </p>
                                <p class="text-muted nm">M: +91 93270 72959</p>
                                <p class="text-muted nm hide">7/8, Jeevan Sadhna Complex, </p>
                                <p class="text-muted nm hide">Maniyasa Society,Maninagar,</p>
                                <p class="text-muted nm hide"> Ahmedabad - 380008</p>

                            </div>
                        </div>
                    </div>
                    <!-- panel body -->
                    <hr class="nm">
                    <!-- panel body -->
                    <div class="panel-body">
                        <ul class="list-table">
                            <li class="text-right">
                                <p class="semibold text-primary nm"></p>
                            </li>
                        </ul>
                    </div>
                    <div class="table-responsive-no" style="padding:10px">
                        <table class="table table-bordered">
                            <tr class="hide">
                                <td colspan="4">
                                    <div class="col-lg-8 panel-body text-left">
                                        <h5 class="semibold mt0 mb5" style="margin-left: 15px;">Diagnosis</h5>
                                        <span class="text-muted" style="margin-left: 15px;">
                                            <?php
                                            $DiagnosisList = DiagnosisMaster::model()->getDiagnosisList();
                                            echo !empty($DiagnosisList[$model->diagnosis_id]) ? $DiagnosisList[$model->diagnosis_id] : common::translateText("NOT_AVAILABLE_TEXT");
                                            ?>
                                        </span>
                                        <h5 class="semibold mt0 mb5" style="margin-left: 15px;">Complains</h5>
                                        <span class="text-muted" style="margin-left: 15px;">
                                            <?php
                                            $complains = ComplainsMaster::model()->getComplainsList();

                                            $complainsArr = array();
                                            if (!empty($model->complains_id)) : foreach ($model->complains_id as $complain_id) :
                                                    if (!empty($complains[$complain_id])) :
                                                        $complainsArr[] = $complains[$complain_id];
                                                    endif;
                                                endforeach;
                                            endif;
                                            echo !empty($complainsArr) ? implode(",", $complainsArr) : common::translateText("NOT_AVAILABLE_TEXT");
                                            ?>
                                        </span>
                                    </div>
                                    <div class="col-lg-4 text-left">
                                        <table cellpadding="3" cellspaing="3" width="100%">
                                            <tr>
                                                <td><b>Height</b></td>
                                                <td><?php echo !empty($model->patient_height) ? $model->patient_height : "N/A"; ?></td>
                                                <td><b>Weight</b></td>
                                                <td><?php echo !empty($model->patient_width) ? $model->patient_width : "N/A"; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Pressure</b></td>
                                                <td><?php echo !empty($model->patient_pressure) ? $model->patient_pressure : "N/A"; ?></td>
                                                <td><b>Temperature</b></td>
                                                <td><?php echo !empty($model->patient_temp) ? $model->patient_temp : "N/A"; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Allergy</b></td>
                                                <td><?php echo AllergyMaster::model()->getCSV($model->patientRel->allergy); ?></td>
                                                <td><b>Known Case</b></td>
                                                <td><?php echo CaseMaster::model()->getCSV($model->patientRel->other_case); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Blood Group</b></td>
                                                <td> <?php echo !empty($model->patientRel->bloodGroupArr[$model->patientRel->blood_group]) ? $model->patientRel->bloodGroupArr[$model->patientRel->blood_group] : "N/A"; ?></td>
                                                <td><b>Regular Medicine</b></td>
                                                <td><?php echo RMedicineMaster::model()->getCSV($model->patientRel->regular_medicine); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="15%" class="text-center">Medicine</th>
                                <th width="15%" class="text-center">Type</th>
                                <th width="15%" class="text-center">Dosage</th>
                                <th width="15%" class="text-center">Days</th>
                            </tr>
                            <?php if (!empty($model->treatmentDetailsRel)) : ?>
                                <?php foreach ($model->treatmentDetailsRel as $dValue) : ?>
                                    <tr>
                                        <td class="valign-top text-center"><span class="bold"><?php echo $dValue->medicineRel->medicineTypeMedicineName; ?></span></td>
                                        <td class="valign-top text-center"><span class="bold"><?php echo ($dValue->medicineRel->is_internal == MedicineMaster::EXTERNAL) ? "External" : "Internal"; ?></span></td>
                                        <td class="valign-top text-center"><span class="bold"><?php echo $dValue->doseageRel->dosage_name; ?></span></td>
                                        <td class="valign-top text-center"><span class="text-primary bold"><?php echo $dValue->days; ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!empty($model->treatmentChargesRel)) : ?>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="semibold mt0 mb5">Charges</h5>
                                    </td>
                                </tr>
                                <?php foreach ($model->treatmentChargesRel as $dValue) : ?>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <?php echo !empty($dValue->chargeRel->charge_title) ? $dValue->chargeRel->charge_title : "N/A"; ?>
                                        </td>
                                        <td class="text-center" colspan="2">
                                            <?php $amount = !empty($dValue->amount) ? $dValue->amount : 0; ?>
                                            <?php echo common::formatCurrency($amount); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="text-right"><b>Credit :</b></td>
                                    <td><?php echo $model->credit_amount ?></td>
                                    <td class="text-right"><b>Debit :</b></td>
                                    <td><?php echo $model->debit_amount ?>&nbsp;&nbsp;&nbsp;<b>Total :</b><?php echo $model->credit_amount + $model->debit_amount; ?></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4">No charges.</td>
                                </tr>
                            <?php endif;
                            ?>
                            <?php if (!empty($model->remarks)) : ?>
                                <tr>
                                    <td colspan="4">
                                        <h5 class="semibold mt0 mb5">Remarks</h5>
                                        <span class="text-muted"><?php echo $model->remarks; ?></span>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr class="no-print">
                                <td colspan="4" class="text-right">
                                    <?php  echo CHtml::Link('Print', "", array("class" => "btn btn-primary no-print", "onclick" => "window.print()")); ?>
                                    <?php
                                    if(isset($_GET['button-type']) && $_GET['button-type'] == 'back') {									
                                        $patient_id = $model->patient_id;
                                        $appointment_id = $model->appointment_id;
                                        echo CHtml::Link('Back', array("/admin/treatments/details/$model->id?Treatments[patient_id]=$patient_id&Treatments[appointment_id]=$appointment_id"), array("class" => "btn btn-primary no-print")); 
                                    } else {
                                        echo CHtml::Link('Edit', array("/admin/treatments/detailsupdate?treatment_id=" . $model->id), array("class" => "btn btn-primary no-print"));
                                    }
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    @media print {

        .no-print,
        .no-print * {
            display: none !important;
        }
    }
</style>