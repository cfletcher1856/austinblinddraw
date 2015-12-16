<?php
    /* @var $this DefaultController */

    $this->breadcrumbs=array(
        'Admin'
    );
    $this->menu=array(
        array('label' => 'Actions'),
        array('label'=>'Users', 'icon' => 'user', 'url'=>array('//admin/user/index')),
        array('label'=>'Tournaments', 'icon' => 'random', 'url'=>array('//admin/tournament/index')),
        array('label'=>'Directors View', 'icon' => 'star', 'url'=>array('//director')),
    );
    $this->page_header = 'Admin';
?>


<p>
    Manage the leage with the links to the left
</p>
