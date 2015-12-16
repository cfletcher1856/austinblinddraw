<?php
    $this->breadcrumbs=array(
        'Director' => array('//director'),
    	'Tournaments',
    );

    $this->menu=array(
        array('label' => 'Actions'),
    	array('label'=>'Create Tournament','url'=>array('create'), 'icon' => 'plus'),
    );
    $this->page_header = 'Tournaments';
?>

<?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'dataProvider'=>$dataProvider,
        'template'=>"{items} {pager}",
        'columns'=>array(
            array('name'=>'name', 'header'=>'Name', 'value' => '$data->name'),
            array('name'=>'date', 'header'=>'Date', 'value' => 'Yii::app()->dateFormatter->format("MM/dd/yyyy",strtotime($data->date))'),
            array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'htmlOptions'=>array('style'=>'width: 75px; text-align: center;'),
                'buttons' => array(
                    'update' => array(
                        'visible' => '!$data->tournamentInPast() && !$data->started'
                    ),
                    'players' => array(
                        'icon' => 'user',
                        'label' => 'Players',
                        'visible' => '!$data->tournamentInPast() && !$data->started',
                        'url' => 'Yii::app()->createUrl("//director/tournament/players", array("id" => $data->id))',
                    ),
                    'teams' => array(
                        'icon' => 'users',
                        'label' => 'Teams',
                        'visible' => '!$data->tournamentInPast() && !$data->started',
                        'url' => 'Yii::app()->createUrl("//director/tournament/teams", array("id" => $data->id))',
                    ),
                    'view' => array(
                        'icon' => 'search'
                    ),
                    'matches' => array(
                        'icon' => 'gear',
                        'label' => 'Matches',
                        'visible' => '$data->started',
                        'url' => 'Yii::app()->createUrl("//director/tournament/matches", array("id" => $data->id))',
                    )
                ),
                'template' => '{update} {players} {teams} {view} {matches}',
            ),
        ),
    ));
?>
