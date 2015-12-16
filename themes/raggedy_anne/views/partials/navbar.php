<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Results', 'url'=>array('/site/results')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Hello ('.Yii::app()->user->name.')', 'url'=> '#', 'visible'=>!Yii::app()->user->isGuest, 'items' => array(
                    array('label' => 'Admin', 'url' => array('//admin'), 'visible' => Yii::app()->user->isAdmin()),
                    array('label' => 'Director', 'url' => array('//director')),
                    array('label' => 'Logout', 'url' => array('/site/logout')),
                )),
            ),
        ),
    ),
    'collapse' => true,
)); ?>
