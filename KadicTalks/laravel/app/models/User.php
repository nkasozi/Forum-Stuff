<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
class User extends Eloquent implements UserInterface,RemindableInterface
{
    public function getAuthIdentifier()
    {
        return $this->id;
    }
    
    public function getAuthPassword()
    {
        return $this->password;
    }
    
    public function getReminderEmail()
    {
        return $this->email;
    }
}
