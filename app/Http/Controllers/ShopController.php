<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Notifications\DeleteShopNotification;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        
    
    public function index()
    { 
        $user = auth()->user();
        $shops = $user->shops;
        
    return view('shops.index', compact('shops'));}

    //
    public function create()
    { 
    return view('shops.create');
    }

    public function store(Request $request)
    { 
        $shop = new Shop();
        $shop->name = $request->name;
        $shop->ssm_no = $request->ssm_no;
        $shop->phone = $request->phone;
        $shop->address = $request->address;
        $shop->city = $request->city;
        $shop->state = $request->state;
        $shop->country = $request->country;
        $shop->email = $request->email;
        $shop->user_id = auth()->user()->id;

        auth()->user()->notify(new StoreShopNotification($shop)); //inventory utk keluarkan nama edit jgk kat notification
       
        $shop->save();

    return redirect()->route('shops.index');}
    //

    public function show(Shop $shop)
    { 
        return view('shops.show', compact('shop'));
    }

    public function edit(Shop $shop)
    { 
        return view('shops.edit', compact('shop'));
    }


        public function update(Request $request, Shop $shop)
    { 
        
        $shop->name = $request->name;
        $shop->ssm_no = $request->ssm_no;
        $shop->phone = $request->phone;
        $shop->address = $request->address;
        $shop->city = $request->city;
        $shop->state = $request->state;
        $shop->country = $request->country;
        $shop->email = $request->email;
        $shop->user_id = auth()->user()->id;
        $shop->save();

    return redirect()->route('shops.index');
   } 

   public function delete(Shop $shop)
    { 
        
        $shop->delete();
        auth()->user()->notify(new DeleteShopNotification($shop));

    return redirect()->route('shops.index');
   }
}
