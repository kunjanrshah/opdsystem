<!---start-header---->
<div class="header" id="top">
    <div class="wrap">
        <!---start-logo---->
        <div class="logo">
            <a href="<?php echo Yii::app()->createUrl("/");?>"><img src="<?php echo Yii::app()->params->paths["imagesURL"]; ?>LogoSai.png" title="logo" /></a>
        </div>
        <!---End-logo---->
        <!---start-top-nav---->
        <div class="top-nav">
            <ul>
                <?php  $controller = Yii::app()->controller->id; ?>
                <li class="<?php echo ($controller=="home")?"active":""; ?>"><?php echo CHtml::Link("Home", array("/")); ?></li>
                <li class="<?php echo ($controller=="aboutus")?"active":""; ?>"><?php echo CHtml::Link("About Us", array("aboutus/index")); ?></li>
                <li class="<?php echo ($controller=="services")?"active":""; ?>"><?php echo CHtml::Link("Services", array("services/index")); ?></li>
                <li class="<?php echo ($controller=="gallery")?"active":""; ?>"><?php echo CHtml::Link("Gallery", array("gallery/index")); ?></li>
                <li class="<?php echo ($controller=="contact")?"active":""; ?>"><?php echo CHtml::Link("Contact", array("contact/index")); ?></li>
            </ul>
        </div>
        <div class="clear"> </div>
        <!---End-top-nav---->
    </div>
</div>
    <!---End-header---->
