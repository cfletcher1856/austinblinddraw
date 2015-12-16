<?php
    $this->breadcrumbs=array(
        'Admin' => array('//admin'),
    	'Users',
    );

    $this->menu=array(
        array('label' => 'Actions'),
    	array('label'=>'Create User','url'=>array('create'), 'icon' => 'plus'),
    );
    $this->page_header = 'Users';
?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$dataProvider,
    'template'=>"{items} {pager}",
    'columns'=>array(
        array('name'=>'name', 'header'=>'Name', 'value' => '$data->getFullName()'),
        array('name'=>'phone', 'header'=>'Phone'),
        array('name' => 'level', 'header' => 'User Type'),
        array(
            'name'=>'active',
            'header'=>'Active',
            'value' => '$data->activeChar()'
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
            'template' => '{update}',
        ),
    ),
)); ?>

