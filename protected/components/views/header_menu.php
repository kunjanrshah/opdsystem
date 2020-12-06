<div class="header" id="top">
    <div class="wrap">
        <!---start-logo---->
        <div class="logo">
            <a href="<?php echo Yii::app()->createUrl("/");?>"><img src="<?php echo Yii::app()->params->paths["imagesURL"];?>LogoSai.png" title="logo" /></a>
        </div>
        <!---End-logo---->
        <!---start-top-nav---->
        <div class="top-nav">
            <ul>
                <?php  $controller = Yii::app()->controller->id; ?>
                <li class="<?php echo ($controller=="home")?"active":""; ?>">
                    <?php echo CHtml::Link("Home",array("/")); ?>
                </li>
                <li class="<?php echo ($controller=="aboutus")?"active":""; ?>">
                    <?php echo CHtml::Link("About Us","javascript:;"); ?>
                    <ul>
                        <li><?php echo CHtml::Link("Overview",array("aboutus/overview")); ?></li>
                        <li><?php echo CHtml::Link("Strategy",array("aboutus/strategy")); ?></li>
                        <li><?php echo CHtml::Link("Directors",array("aboutus/directors")); ?></li>
                        <li><?php echo CHtml::Link("Corporate Information",array("aboutus/corporateinformation")); ?></li>
                    </ul>
                </li>
                <li class="<?php echo ($controller=="distribution")?"active":""; ?>">
                    <?php echo CHtml::Link("Distribution","javascript:;"); ?>
                    <ul>
                        <li><?php echo CHtml::Link("Distribution In UK",array("distribution/distributioninuk")); ?></li>
                        <li><?php echo CHtml::Link("Distributing Opportunity",array("distribution/opportunity")); ?></li>
                        <li><?php echo CHtml::Link("In Licensing",array("distribution/inlicensing")); ?></li>
                    </ul>
                </li>
                <li class="<?php echo ($controller=="services")?"active":""; ?>">
                    <?php echo CHtml::Link("Customer Services","javascript:;"); ?>
                    <ul>
                        <li><?php echo CHtml::Link("How to order",array("services/howtoorder")); ?></li>
                    </ul>
                </li>
                <li class="<?php echo ($controller=="newsandevents")?"active":""; ?>"><?php echo CHtml::Link("News & Events",array("newsandevents/index")); ?></li>
                <li class="<?php echo ($controller=="contact")?"active":""; ?>"><?php echo CHtml::Link("Contact",array("contact/index")); ?></li>
                <li class="<?php echo ($controller=="login")?"active":""; ?>"><?php echo CHtml::Link("Login",array("login/index")); ?></li>
                <li class="<?php echo ($controller=="links")?"active":""; ?>"><?php echo CHtml::Link("Useful Links",array("links/index")); ?></li>
            </ul>
        </div>
        <div class="clear"> </div>
        <!---End-top-nav---->
    </div>
    <!---End-header---->
</div>