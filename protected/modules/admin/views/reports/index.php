<div class="container-fluid">
    <?php
    $this->renderPartial("_search", array("model" => $model));
    $this->renderPartial("/layouts/_message");
    ?>
    <div class="row">
        <div class="col-md-12">
            <!-- START panel -->
            <div id="toolbar-showcase" class="panel panel-default">
                <!-- panel heading/header -->
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo common::getTitle("reports/index"); ?>
                    </h3>
                </div>
				<div class="col-xs-2">
					<!-- </?php
						print_r($diagnosis_data);
					?> -->
				</div>
                <!-- panel body with collapse capabale -->
                <div class="table-responsive panel-collapse pull out">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
								<th>Sr no</th>
                                <th>Treatment Date Time</th>
                                <th>Patient</th>                                                                
                                <th>Diagnosis</th>
                                <th>Charges</th>
                                <th class="text-right">Credit </th>
                                <th class="text-right">Debit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandTotal = 0;
                            $grandDebit = 0;
							$srno = 1;
                            if (!empty($data)) : foreach ($data as $value): if (!empty($value->patientRel)):
                                        ?>
                                        <tr>
											<td>
												<?php echo $srno++; ?>
											</td>
                                            <td>
                                                <?php
                                                if (common::checkActionAccess("treatments/details")) {
                                                    echo CHtml::Link($value->created_dt, array("/admin/treatments/details", "id" => $value->id, "Treatments[patient_id]" => $value->patient_id, "Treatments[appointment_id]" => $value->appointment_id));
                                                } else {
                                                    ?>
                                                    Treatment on <?php echo $value->created_dt; ?>
                                                <?php }
                                                ?>
                                            </td>
                                            <td><?php echo $value->patientRel->patient_name; ?></td>
                                            <td><?php
													foreach ($value->diagnosis_id as $each_diagnosis_id):
														echo $diagnosis_data[$each_diagnosis_id] . ", ";
													endforeach;
												?>
											</td>
                                            <td>
                                                <?php
                                                $total = 0;
                                                $debit = !empty($value->debit_amount) ? $value->debit_amount : 0;
                                                if (!empty($value->treatmentChargesRel)) : foreach ($value->treatmentChargesRel as $charges):
                                                        echo $charges->chargeRel->charge_title . " (" . $charges->amount . ")";
                                                        echo "<br />";
                                                        $total +=$charges->amount;
                                                    endforeach;
													$total = $total - $debit;
                                                else : echo common::translateText("NOT_AVAILABLE_TEXT");
                                                endif;
                                                ?>
                                            </td>
                                            <td class="text-right success"><?php
                                                echo $total;
                                                $grandTotal+=$total;
                                                $grandDebit+=$debit;
                                                ?></td>
                                            <td class="text-right danger"><?php echo $debit; ?></td>
                                        </tr>
                                        <?php
                                    endif;
                                endforeach;
                                ?>
                                <tr>
                                    <td>Total </td>
                                    <td colspan="4" class="text-right"><?php echo $grandTotal + $grandDebit;?></td>
                                    <td class="text-right success"><?php echo $grandTotal; ?> </td>
                                    <td class="text-right danger"><?php echo $grandDebit; ?> </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">No records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!--/ panel body with collapse capabale -->
            </div>
        </div>
    </div>
</div>
<!--/ END Template Container -->