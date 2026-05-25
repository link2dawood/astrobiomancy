<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Settings Model  is responsible for Settings Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Settings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'settings';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';
}