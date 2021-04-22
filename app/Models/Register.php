<?php


namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Register extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'login';
}
