<?php
    $this->breadcrumbs=array(
    	'Tournaments'=>array('index'),
    	'Create',
    );

    $this->menu=array(
    	array('label'=>'List Tournaments','url'=>array('index'), 'icon' => 'list'),
    );
    $this->page_header = 'Create Tournament';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
