<?php
    /* @var $this DefaultController */

    $this->breadcrumbs=array(
        'Director'
    );
    $this->menu=array(
        array('label' => 'Actions'),
        array('label'=>'Tournamnets', 'icon' => 'random', 'url'=>array('//director/tournament')),
        array('label'=>'Players', 'icon' => 'user', 'url'=>array('//director/player')),

    );
    $this->page_header = 'Director';
?>


<p>
    Manage the tournaments with the links to the left
</p>
