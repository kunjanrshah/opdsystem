<!-- START Template Header -->
<header id="header" class="navbar navbar-fixed-top">
    <!-- START navbar header -->
    <div class="navbar-header">
        <!-- Brand -->
        <a class="navbar-brand" href="<?php echo Yii::app()->createUrl("/admin/dashboard"); ?>">
            <span class="logo-figure"></span>
            <span class="logo-text"></span>
        </a>
        <!--/ Brand -->
    </div>
    <!--/ END navbar header -->

    <!-- START Toolbar -->
    <div class="navbar-toolbar clearfix">
        <!-- START Left nav -->
        <ul class="nav navbar-nav navbar-left">
            <!-- Sidebar shrink -->
            <li class="hidden-xs hidden-sm">
                <?php
                echo CHtml::Link('<span class="meta"><span class="icon"></span></span>', "javascript:;", array("class" => "sidebar-minimize", "data-toggle" => "minimize", "title" => "Minimize sidebar",
                    "ajax" => array(
                        "url" => Yii::app()->createUrl('/admin/common/setmenuview'),
                        "success" => "js:function(){
                                    if($('html').hasClass('sidebar-minimized')){                                       
                                        $('html').removeClass('sidebar-minimized');
                                    }else{                                        
                                        $('html').addClass('sidebar-minimized');
                                    }
                                 }"
                    )
                        )
                );
                ?>
            </li>
            <!--/ Sidebar shrink -->

            <!-- Navbar collapse -->
            <li class="navbar-toggle">
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="meta">
                        <span class="icon"><i class="ico-sort-by-attributes-alt"></i></span>
                    </span>
                </a>
            </li>
            <!--/ Navbar collapse -->

            <!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
            <li class="navbar-main hidden-lg hidden-md hidden-sm">
                <a href="javascript:void(0);" data-toggle="offcanvas" data-direction="ltr" rel="tooltip" title="Menu sidebar">
                    <span class="meta">
                        <span class="icon"><i class="ico-paragraph-left3"></i></span>
                    </span>
                </a>
            </li>
            <li> 
                <a href="javascript:void(0);">
                    <span class="meta">
                        <span class="title semibold" style="font-size: 20px;"><?php echo common::getTitle(Yii::app()->controller->id . "/" . Yii::app()->controller->action->id); ?></span>
                    </span>
                </a>
            </li>
            <!--/ Offcanvas left -->
            <!--/ Search form toggler -->
        </ul>
        <!--/ END Left nav -->


        <!-- START Right nav -->
        <ul class="nav navbar-nav navbar-right">
		<?php if(Yii::app()->user->user_group != 3 && Yii::app()->user->user_group != 4):?>
			<?php if (common::checkActionAccess("appointments/index")): ?>
				<li>
					<a href="<?php  echo Yii::app()->createUrl("/admin/appointments/index")?>">
						<span class="meta">
							<span class="text">Notifications <span class="number label label-danger" id="notificationCountAppointment"><?php echo count(Appointments::model()->findAll("is_treatment_given = 0 AND t.deleted = 0"));?></span></span>
						</span>
					</a>	
				</li>
				<?php endif; ?>
		<?php endif; ?>
		<?php if(Yii::app()->user->user_group == 3):?>
            <?php if (common::checkActionAccess("notifications/index")): ?>
            <li>
                <a href="<?php  echo Yii::app()->createUrl("/admin/notifications/index")?>">
                    <span class="meta">
                        <span class="text">Notifications <span class="number label label-danger" id="notificationCount"><?php echo Notifications::model()->totalNotifications(Yii::app()->user->id)?></span></span>
                    </span>
                </a>	
            </li>
            <?php endif; ?>
		<?php endif; ?>
            <!-- Profile dropdown -->
            <li class="dropdown profile">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="meta">                        
                        <span class="avatar"><img src="<?php echo Yii::app()->user->getProfilePicture(); ?>" class="img-circle" alt="" /></span>
                        <span class="text hidden-xs hidden-sm pl5" style="font-size: 15px;"><?php echo Yii::app()->user->getFullName(); ?></span>
                        <span class="caret"></span>
                    </span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <?php if (common::checkActionAccess("users/index")): ?>
                        <li><?php echo CHtml::Link('<span class="icon"><i class="ico-users"></i></span> Users', array("/admin/users")); ?></li>
                    <?php endif; ?>
                    <?php if (common::checkActionAccess("settings/index")): ?>
                        <li><?php echo CHtml::Link('<span class="icon"><i class="ico-cog"></i></span> Master', array("/admin/settings")); ?></li>
                    <?php endif; ?>
                    <li><?php echo CHtml::Link('<span class="icon"><i class="ico-exit"></i></span> Sign Out', array("/admin/login/logout")); ?></li>
                </ul>
            </li>
            <!--/ Profile dropdown -->
        </ul>
        <!--/ END Right nav -->
    </div>
    <!--/ END Toolbar -->
</header>
<!--/ END Template Header -->