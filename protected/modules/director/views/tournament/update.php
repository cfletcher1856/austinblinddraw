<?php
    $this->breadcrumbs=array(
        'Admin' => array("//admin"),
    	'Tournaments'=>array('index'),
    	'Update',
    );

    $this->menu=array(
        array('label' => 'Actions'),
        array('label'=>'Tournament Players','url'=>array('players', 'id' => $model->id), 'icon' => 'user'),
    	array('label'=>'List Tournaments','url'=>array('index'), 'icon' => 'list'),
    	array('label'=>'Create Tournament','url'=>array('create'), 'icon' => 'plus'),
    );
    $this->page_header = 'Update Tournament';
?>

<?php
    if($model->started){
        echo "<div class=\"alert alert-warning alert-block\">";
        echo "The tournament has already started.  You can no longer make any changes.";
        echo "</div>";
    } else {
        echo $this->renderPartial('_form',array('model'=>$model));
    }
?>
