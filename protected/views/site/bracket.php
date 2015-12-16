<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<img id="challonge_bracket" src="<?php echo $model->challonge_image; ?>" />

<?php $this->beginClip('javascript'); ?>
    <script type="text/javascript">
        $(function(){
            var d = new Date();
            var bracket_image = "<?php echo $model->challonge_image; ?>";
            setInterval(function(){
                $("#challonge_bracket").attr("src", bracket_image+"?"+d.getTime());
                console.log("refreshing: ", bracket_image);
            }, 1000 * 60 * 5);
        });
    </script>
<?php $this->endClip(); ?>
