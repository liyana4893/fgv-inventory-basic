<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use App\Notifications\DeleteShopNotification;
use App\Notifications\StoreShopNotification;

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

    public function store(ShopRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $shop = Shop::create($data);
        auth()->user()->notify(new StoreShopNotification($shop));
        return redirect()->route('shops.index');
    }
    //

    public function show(Shop $shop)
    {
        return view('shops.show', compact('shop'));
    }

    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }


        public function update(ShopRequest $request, Shop $shop)
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $shop->update($data);
        return redirect()->route('shops.index');
    }

   public function delete(Shop $shop)
    {

        $shop->delete();
        auth()->user()->notify(new DeleteShopNotification($shop));

    return redirect()->route('shops.index');
   }
}
