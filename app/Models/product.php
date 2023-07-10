<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class product extends Model
{
    use HasFactory , SoftDeletes ;

    
    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT = 'draft';
    const STATUS_ARCHIVED = 'archived';
    protected $fillable = [
        'name','slug','category_id','description','short_descripion','price',
        'compare_price','image','status','user_id',
    ];
    protected $appends=[
        'image_url',
        'price_formatted',
        'compare_price_formatted',
    ];
    protected $hidden =[
        'image',
        'updated_at',
        'deleted_at',
    ];

    protected static function booted()
    {
       if(Auth::check()) 
        static::addGlobalScope('owner', function(Builder $query) {
              $query->where('user_id', '=', Auth::id());
        });
       
    }
    public function category(){
        return $this->belongsTo(category::class , 'category_id')->withDefault([
           'name' => 'uncategrized'
        ]);
    }
    public function User(){
        return $this->belongsTo(User::class);
       
    }
    public function gallery()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function cart()
    {
        return $this->belongsToMany(
            User::class,     // Related model (User)
            'carts',            // Pivot table(default=product_user)
            'product_id',       // FK related model in pivot table
            'user_id',          // FK current model in pivot table
            'id',               // PK current user
            'id',               // PK related model
        )
        ->withPivot(['quantity'])
        ->withTimestamps()
        ->using(Cart::class);
    }
    public function scopeActive(Builder $query){
        $query->where('status', '=' , 'active');
    }

    public function scopeStatus(Builder $query , $status){
        $query->where('status', '=' , $status);
    }
    public function scopeFilter(Builder $query, $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $value) {
            $query->where(function ($query) use ($value) {
                $query->where('products.name', 'LIKE', "%{$value}%")
                    ->orWhere('products.description', 'LIKE', "%{$value}%");
            });
        })
            ->when($filters['status'] ?? false, function ($query, $value) {
                $query->where('products.status', '=', $value);
            })
            ->when($filters['category_id'] ?? false, function ($query, $value) {
                $query->where('products.category_id', '=', $value);
            })
            ->when($filters['price_min'] ?? false, function ($query, $value) {
                $query->where('products.price', '>=', $value);
            })
            ->when($filters['price_max']  ?? false, function ($query, $value) {
                $query->where('products.price', '<=', $value);
            });
    }
    public static function statusOptions()

    {
        return[
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT  => 'Draft',
            self::STATUS_ARCHIVED => 'Archived'
        ];
    }

    public function getImageUrlAttribute(){
        if($this->image){
            return Storage::disk('public')->url($this->image);
        }
        return  'https://placehold.co/60x60?text=No+Image';
    }

    public function getNameAttribute($value){
        return ucwords($value);
    }
    public function getPriceFormattedAttribute(){
        $formatter = new NumberFormatter('en',NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->price,'USD');
    }
    public function getComparePriceFormattedAttribute(){
        $formatter = new NumberFormatter('en',NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->compare_price,'USD');
    }
}
