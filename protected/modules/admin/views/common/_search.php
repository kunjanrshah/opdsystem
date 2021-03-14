<div class="page-header page-header-block">
    <div class="page-header-section">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#search_form').submit(function(){
                    $.fn.yiiGridView.update('$id', {
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
                    <?php 
                         $className = get_class($model);
                         echo $form->hiddenField($model, $field, array("placeholder"=>"Search","class" => "form-control"));
                         $identifier = $className."_".$field;
                         $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name' => 'selectFieldValue',
                            'value' => isset($_GET['selectFieldValue'])?$_GET['selectFieldValue']:'',
                            'source' => CController::createUrl('common/globaldropdown', array('field'=>$field, "model" => $className)),
                            'options' => array(
                                'html'=>true,
                                'showAnim' => 'fold',
                                'minLength' => '1',
                                'search' => 'js:function( event, ui ) { 
                                    $("#'.$identifier.'").val(null); 
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $("#selectFieldValue").val( ui.item.label );
                                    $("#'.$identifier.'").val( ui.item.value );
                                    return false;
                                }',
                            ),
                            'htmlOptions' => array(
                                'onChange' => 'js: if($("#selectFieldValue").val() == "") { $("#'.$identifier.'").val("") }',
                                'class' => 'form-control',
                                'placeholder' => "Search",
                                'autocomplete'=>'off'
                            ),
                        ));
                        ?>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary"><i class="ico-loop4 mr5"></i><?php echo common::translateText("SEARCH_BTN_TEXT"); ?></button>
                    <a href="javascript:;" onClick="window.location.reload();" class="btn btn-default"><i class="ico-loop4 mr5"></i>Reset</a>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>