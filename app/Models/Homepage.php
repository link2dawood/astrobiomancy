<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Homepage Model  is responsible for Disclaimer Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Homepage extends Model
{
    use \App\Models\Concerns\Translatable;
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'homepage';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';
}
