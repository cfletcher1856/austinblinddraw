<?php
    $this->breadcrumbs=array(
        'Admin' => array('//admin'),
    	'Users'=>array('index'),
    	'Create',
    );

    $this->menu=array(
    	array('label'=>'List Users','url'=>array('index'), 'icon' => 'list'),
    );
    $this->page_header = 'Create User';
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
