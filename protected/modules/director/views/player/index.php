<?php
    $this->breadcrumbs=array(
        'Director' => array('//director'),
    	'Players',
    );

    $this->menu=array(
    	array('label' => 'Actions'),
        array('label'=>'Create Player','url'=>array('create'), 'icon' => 'plus'),
    );
    $this->page_header = 'Players';
?>

<?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'dataProvider' => $dataProvider,
        'template'=>"{items} {pager}",
        'columns'=>array(
            array('name'=>'name', 'header'=>'Name'),
            array('name'=>'nickname', 'header'=>'Nickname'),
            array(
                'name'=>'female',
                'header'=>'Female',
                'value' => '($data->female) ? "Y" : ""'
            ),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'htmlOptions'=>array('style'=>'width: 50px; text-align: center;'),
                'template' => '{update}',
            ),
        ),
    ));
?>
