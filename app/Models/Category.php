<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Category Model  is responsible for Category Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'categories';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';
}