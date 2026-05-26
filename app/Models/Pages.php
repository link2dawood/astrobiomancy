<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Pages Model  is responsible for Pages Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Pages extends Model
{
    use \App\Models\Concerns\Translatable;
    protected $guarded = [];
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'pages';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';

}
