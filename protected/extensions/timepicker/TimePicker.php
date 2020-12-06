<?php
/**
 * @author Alpesh Vaghela <alpeshspce20@gmail.com>
 */

class TimePicker extends CInputWidget
{
    public $options;
    public $flat=false;
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        
            list($name, $id) = $this->resolveNameID();

            if (isset($this->htmlOptions['id'])) {
                $id = $this->htmlOptions['id'];
            } else {
                $this->htmlOptions['id'] = $id;
            }
            if (isset($this->htmlOptions['name'])) {
                $name = $this->htmlOptions['name'];
            }

            if ($this->flat === false) {
                if ($this->hasModel()) {
                    echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
                } else {
                    echo CHtml::textField($name, $this->value, $this->htmlOptions);
                }
            } else {
                if ($this->hasModel()) {
                    echo CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
                    $attribute = $this->attribute;
                    $this->options['defaultDate'] = $this->model->$attribute;
                } else {
                    echo CHtml::hiddenField($name, $this->value, $this->htmlOptions);
                    $this->options['defaultDate'] = $this->value;
                }

                $id = $this->htmlOptions['id'] = $id . '_container';
                $this->htmlOptions['name']     = $name . '_container';

                echo CHtml::tag('div', $this->htmlOptions, '');
            }
            $options   = CJavaScript::encode($this->options);
            $js        = "jQuery('#{$id}').timepicker($options);";

            $assetsDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
            $assets    = Yii::app()->assetManager->publish($assetsDir);
            $cs        = Yii::app()->clientScript;
            $min       = YII_DEBUG ? '' : '.min';
            $cs->registerCssFile($assets . '/jquery.timepicker.css');
            $cs->registerScriptFile($assets . '/jquery.timepicker' . $min . '.js', CClientScript::POS_END);

            if (isset($this->defaultOptions)) {
                $this->registerScriptFile($this->i18nScriptFile);
                $cs->registerScript(__CLASS__, $this->defaultOptions !== null ? "jQuery.timepicker.setDefaults(" . CJavaScript::encode($this->defaultOptions) . ');' : '');
            }
            $cs->registerScript(__CLASS__ . '#' . $id, $js);
        
    }
}
