<?php

namespace App\Models;

use App\Http\Controllers\FriendUserController;
use App\Http\Controllers\ProductController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use App\Models\ListingType;
use App\Notifications\Lists\Products\ProductAdded;
use App\Notifications\Lists\Products\ProductEdited;
use Illuminate\Http\Request;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'listing_type_id', 'label', 'description', 'secret'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function listing_type(){
        return $this->belongsTo(ListingType::class);
    }
    
    public function products(){
        return $this->belongsToMany(Product::class, 'listing_products')->withTimestamps();
    }
    
    public function users(){
        return $this->belongsToMany(User::class, 'listing_users')->withTimestamps();
    }

    public function getProducts($withExtra = true){
        $products = (new ProductController)->getProducts($this->products()->paginate());
        $products->useAjax = true; //Permet l'utilisation du système de pagination en ajax
        
        if ($withExtra) {
            foreach($products as $product) $product->nb = ListingProduct::where('product_id', '=', $product->id)->first()->nb;
            
            $products->total_price = 0;
            foreach($products as $product) $products->total_price += $product->real_cost * $product->nb;
        }
        return $products;
    }

    static function getFileName($listId) {
        $list = Listing::find($listId);
        return ($list->listing_type_id <= 1 ? '' : ' ['.$list->listing_type->label.'] ').$list->label;
    }

    function isShared() {
        return (count($this->users) > 0);
    }
    
    public function getFriendsNotShared() {
        $user = auth()->user();
        $buildRequest = User::query()
            ->where('id', '!=', $user->id);
        FriendUserController::whereIsFriend($buildRequest, $user);
        $friends = $buildRequest->whereDoesntHave('listing_users', function($query) {
                $query->where('listing_id', '=', $this->id);
            })
            ->get();

        return $friends;
    }

    public function owned() {
        return $this->user_id === auth()->user()->id;
    }
    
    public function updateProductNb(Request $request, $newProduct) {
        $product = Product::find($request->product_id);
        $listingProduct = ListingProduct::where('listing_id', '=', $request->list_id)
            ->where('product_id', '=', $request->product_id)
            ->first();
        //On envoie une notification aux users de la liste
        if ($newProduct) {
            foreach ($this->users as $user) {
                $user->notify(new ProductAdded($user, $this, $product));
            }
        } else {
            foreach ($this->users as $user) {
                $user->notify(new ProductEdited($user, $this, $product, $listingProduct->nb, $request->nb));
            }
        }
        ListingProduct::where('listing_id', '=', $request->list_id)
            ->where('product_id', '=', $request->product_id)
            ->update(['nb' => $request->nb]);
    }
}
