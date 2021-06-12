<table class="table" width="100%" cellpadding="3" border="1">
    <thead>
        <tr>
            <th class="text-center">Medicine</th>
            <th class="text-center">Dosage</th>
            <th class="text-center">Days</th>
        </tr>
    </thead>
    <tbody>                                
        <?php if (!empty($model->treatmentDetailsRel)): ?>

            <?php foreach ($model->treatmentDetailsRel as $dValue): ?>
                <?php if ($dValue->medicineRel->is_internal == 2): ?>
                    <tr>
                        <td class="valign-top text-center"><span class="bold"><?php echo $dValue->medicineRel->medicineTypeMedicineName; ?></span></td>
                        <td class="valign-top text-center"><span class="bold"><?php echo $dValue->doseageRel->dosage_name; ?></span></td>
                        <td class="valign-top text-center"><span class="text-primary bold"><?php echo $dValue->days; ?></span></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr>
            <td colspan="3">
                <h5 class="semibold mt0 mb5">Diagnosis</h5>
                <span class="text-muted">
                    <?php
                    $DiagnosisList = DiagnosisMaster::model()->getDiagnosisList();
                    echo!empty($DiagnosisList[$model->diagnosis_id]) ? $DiagnosisList[$model->diagnosis_id] : common::translateText("NOT_AVAILABLE_TEXT");
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h5 class="semibold mt0 mb5">Complains</h5>
                <span class="text-muted">
                    <?php
                    $complains = ComplainsMaster::model()->getComplainsList();

                    $complainsArr = array();
                    if (!empty($model->complains_id)): foreach ($model->complains_id as $complain_id):
                            if (!empty($complains[$complain_id])) :
                                $complainsArr[] = $complains[$complain_id];
                            endif;
                        endforeach;
                    endif;
                    echo!empty($complainsArr) ? implode(",", $complainsArr) : common::translateText("NOT_AVAILABLE_TEXT");
                    ?>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h5 class="semibold mt0 mb5">Remarks</h5>
                <span class="text-muted"><?php echo $model->remarks; ?></span>
            </td>
        </tr>
    </tbody>
</table>
