<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Aboutus Model  is responsible for Aboutus Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Aboutus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'about_us';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';

}