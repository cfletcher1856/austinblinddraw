<?php
    $this->breadcrumbs=array(
        'Admin' => array('//admin'),
    	'Users'=>array('index'),
    	'Update',
    );

    $this->menu=array(
        array('label' => 'Actions'),
    	array('label'=>'List Users','url'=>array('index'), 'icon' => 'list'),
    	array('label'=>'Create User','url'=>array('create'), 'icon' => 'plus'),
    );
    $this->page_header = $model->getFullName();
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
