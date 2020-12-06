<!-- START Template Container -->
<div class="container-fluid">
    <!-- START row -->
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <!-- START Left Side -->
        <div class="col-md-12">
            <!-- Top Stats -->
            <div class="row">                
                <?php if(!empty($navArr)): foreach($navArr as $title=>$url): ?>
                <a href="<?php echo $url;?>" title="<?php echo $title;?>">
                <div class="col-sm-2">
                    <!-- START Statistic Widget -->
                    <div class="table-layout">                        
                        <div class="col-xs-8 panel">
                            <div class="panel-body text-center">
                                <div class="ico-cog3 fsize24 text-center"></div>
                                <p class="semibold text-muted mb0 mt5"><?php echo $title; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
                <?php endforeach; endif; ?>
            </div>
            <!--/ Top Stats -->
        </div>
        <!--/ END Left Side -->
    </div>
    <!--/ END Template Container -->
</div>