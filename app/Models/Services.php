<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Services Model  is responsible for Services Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Services extends Model
{
    use \App\Models\Concerns\Translatable;
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'services_page';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';

}
