<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Comments Model  is responsible for Comments Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Comments extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'comments';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';
}