<?php

class EWebUser extends CWebUser
{
    protected $_model;

    function isAdmin()
    {
        $user = $this->loadUser();
        if($user)
        {
           return $user->level == LevelLookUp::ADMIN;
        }

        return false;
    }

    // Load user model.
    protected function loadUser()
    {
        if($this->_model === null)
        {
            $this->_model = User::model()->findByPk($this->id);
        }

        return $this->_model;
    }

    function getName()
    {
        $user = $this->loadUser();
        return $user->f_name . " " . $user->l_name;
    }

    function getUser()
    {
        return $this->loadUser();
    }
}
