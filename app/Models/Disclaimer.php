<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Disclaimer Model  is responsible for Disclaimer Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Disclaimer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'disclaimer';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';
}