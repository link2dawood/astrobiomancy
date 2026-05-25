<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
/**
* The Blog Model  is responsible for Blog Relations with other table
*
* Author : Syed Ali Raza
*
*/ 
class Blog extends Model
{
    use \App\Models\Concerns\Translatable;
    /**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'blog';
    /**
     * model used this Primary Key
     *
     * @var string
    */
    protected $primaryKey = 'id';

    public function author_data () {
        return $this->belongsTo('App\User', 'author_id');
    }
    public function cat_data () {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
