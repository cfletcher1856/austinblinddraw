<?php /* @var $this Controller */ ?>
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
        //Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . '/js/chosen.jquery.min.js');
        //Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl . '/js/highcharts/js/highcharts.js');
        Yii::app()->bootstrap->register();
        Yii::app()->less->register();
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
</head>
<body>
    <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.navbar'); ?>

    <div class="container<?php if($this->_layout == 'fluid'): ?>-fluid<?php endif; ?>" id="page">
        <div class="content">
            <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.page_header'); ?>

        	<?php //$this->renderPartial('webroot.themes.raggedy_anne.views.partials.breadcrumbs'); ?>

            <div class="row<?php if($this->_layout == 'fluid'): ?>-fluid<?php endif; ?>">
                <div class="span12">
        	       <?php echo $content; ?>
                </div>
            </div>


        	<div class="clear"></div>
        </div>
        <?php $this->renderPartial('webroot.themes.raggedy_anne.views.partials.footer'); ?>
    </div>

    <script type="text/javascript">
      $(function(){

      });

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-2754890-14']);
      _gaq.push(['_setDomainName', 'ragsblinddraw.com']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>

</body>
</html>
