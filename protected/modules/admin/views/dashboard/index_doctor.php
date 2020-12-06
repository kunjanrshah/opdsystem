<div class="container-fluid">
    <?php $this->renderPartial("/layouts/_message"); ?>
    <div class="row">
        <div class="col-md-12">
            <?php
			
            $_GET['Appointments']['today'] = true;
            Yii::import("application.modules.admin.controllers.AppointmentsController");
            $controller = new AppointmentsController(true);
            echo $controller->actionIndex();
            Yii::import("application.modules.admin.controllers.TreatmentsController");
            $controller = new TreatmentsController(true);

            echo $controller->actionIndex();
            ?>
        </div>
    </div>
</div>