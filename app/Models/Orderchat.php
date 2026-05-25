<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Orders Model  is responsible for Orders Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Orderchat extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'order_chat';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';
    public function userdata () {
    	return $this->belongsTo('App\User', 'user_id');
    }
}