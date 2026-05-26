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
    use \App\Models\Concerns\Translatable;
    protected $guarded = [];
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
