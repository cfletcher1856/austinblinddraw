<?php
    $this->breadcrumbs=array(
        'Director' => array('//director'),
    	'Players'=>array('index'),
    	'Update',
    );

    $this->menu=array(
    	array('label'=>'List Players','url'=>array('index'), 'icon' => 'list'),
    	array('label'=>'Create Player','url'=>array('create'), 'icon' => 'plus'),
    );
    $this->page_header = 'Update Player';
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
