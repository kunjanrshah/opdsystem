<?php $this->beginContent('/layouts/loginMain'); ?>
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <section class="container">
        <!-- START row -->
        <div class="row">
            <div>
                <!-- Brand -->
                <div class="text-center" style="margin-bottom:40px;">
                    <span class="logo-figure inverse"></span>
                    <span class="logo-text inverse"></span>

                </div>
                <!--/ Brand -->
                <?php echo $content; ?>
            </div>
        </div>
        <!--/ END row -->
    </section>
    <!--/ END Template Container -->
</section>
<!--/ END Template Main -->
<?php $this->endContent(); ?>