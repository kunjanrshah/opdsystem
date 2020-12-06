<!-- START Template Sidebar (Left) -->
<aside class="sidebar sidebar-left sidebar-menu">
    <!-- START Sidebar Content -->
    <section class="content slimscroll">
        <!-- START Template Navigation/Menu -->
        <?php if(!empty($menusArr)) :  //echo "<pre>"; print_r($menusArr);exit;?>
            <h5 class="heading">Main Menu</h5>
            <ul data-toggle="menu" class="topmenu">
                <?php foreach($menusArr as $parent_id=>$mainMenus) : ?>
                <li class="<?php echo !empty($mainMenus["active"])?"active": "";?>">
                    <a data-parent=".topmenu" data-toggle="submenu" data-target="#menu_<?php echo $parent_id;?>" id="activeMenu_<?php echo $parent_id;?>" href="<?php echo (empty($mainMenus["submenu"]))? $mainMenus["url"] : "javascript:void(0);"?>" >
                        <span class="figure"><i class="<?php echo $mainMenus["menu_icon"];?>"></i></span>
                        <span class="text"><?php echo $mainMenus["menu_title"];?></span>
                        <?php if(!empty($mainMenus["submenu"])) : ?><span class="arrow"></span> <?php endif; ?>
                    </a>
                    <?php if(!empty($mainMenus["submenu"])): ?>
                    <!-- START 2nd Level Menu -->
                    <ul class="submenu collapse <?php echo !empty($mainMenus["active"])?"in":"";?>" id="menu_<?php echo $parent_id;?>"  height="auto">
                        <li class="submenu-header ellipsis">Dashboard</li>
                        <?php foreach($mainMenus["submenu"] as $subMenu) : ?>
                        <li class="<?php echo !empty($subMenu["active"])?"active": "";?>">
                            <a href="<?php echo $subMenu["url"]; ?>">
                                <span class="text"><?php echo $subMenu["menu_title"];?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <!--/ END 2nd Level Menu -->
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <!--/ END Template Navigation/Menu -->
        <!--/ Summary -->
        <!--/ END Sidebar summary -->
    </section>
    <!--/ END Sidebar Container -->
</aside>
<!--/ END Template Sidebar (Left) -->
