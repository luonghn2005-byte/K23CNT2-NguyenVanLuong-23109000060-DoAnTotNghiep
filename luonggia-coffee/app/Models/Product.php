<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['category_id','name','price','image','description','is_active'];
    protected $casts = ['price'=>'integer','is_active'=>'boolean'];
    public function category() { return $this->belongsTo(Category::class); }
}