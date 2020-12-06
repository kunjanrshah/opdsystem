<div class="page-header page-header-block">
    <div class="page-header-section">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#search_form').submit(function(){
                    $.fn.yiiGridView.update('appointments-grid', {
                        data: $('#search_form').serialize()
                    });
                    return false;
            });
        ");
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'search_form',
            'method' => 'get',
            'clientOptions' => array('validateOnSubmit' => true)
        ));
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-2">
                    <?php common::getDatePicker($model, "start_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("start_date"))); ?>
                </div>
                <div class="col-xs-2">
                    <?php common::getDatePicker($model, "end_date", array("class" => "form-control", "placeholder" => $model->getAttributeLabel("end_date"))); ?>
                </div>   
                <div class="col-xs-2">
                    <button type="submit" class="btn btn-primary"><i class="ico-loop4 mr5"></i><?php echo common::translateText("SEARCH_BTN_TEXT"); ?></button>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>