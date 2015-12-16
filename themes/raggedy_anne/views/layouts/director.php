<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="<?php echo "http://" . $_SERVER["SERVER_NAME"]; ?>/images/favicon.ico" />

    <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/bootstrap-datepicker.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/knockout-3.1.0.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/knockout.mapping-latest.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/underscore-min.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/payouts.js');
        Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . '/js/chosen.jquery.min.js');
        Yii::app()->bootstrap->register();
        Yii::app()->less->register();
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/director.css" />
</head>
<body>

    <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.navbar'); ?>

    <div class="container">
        <div class="content">
            <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.page_header'); ?>

            <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.breadcrumbs'); ?>

            <?php $this->widget('bootstrap.widgets.TbAlert', array(
                'block'=>false, // display a larger alert block?
                'fade'=>true, // use transitions?
                'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
            )); ?>

            <div class="row">
                <?php if(count($this->menu)): ?>
                    <div class="span3">
                        <?php
                            $this->widget('bootstrap.widgets.TbMenu', array(
                                'type' => 'list',
                                'htmlOptions' => array('class' => 'well'),
                                'items' => $this->menu
                            ));
                        ?>
                        <?php echo $this->clips['sidebar']; ?>
                    </div>

                    <div class="span9">
                        <div id="content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="span12">
                        <div id="content">
                            <?php echo $content; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.footer'); ?>
    </div>

    <script type="text/javascript">
        $(function(){
            $('.datepicker').datepicker().on('changeDate', function(evt){
                $(this).datepicker('hide');
            });
            $("select").chosen();
        });
    </script>
    <?php echo $this->clips['javascript']; ?>
</body>
</html>
