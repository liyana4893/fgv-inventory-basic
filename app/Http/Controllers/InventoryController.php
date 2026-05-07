<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryRequest;
use App\Models\Inventory;
use App\Notifications\StoreInventoryNotification;

class InventoryController extends Controller
{
    public function __construct()  //bagi page tak error, bila masuk, kene login dulu
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $inventories = Inventory::all();

        //$user = auth()->user();
       // $inventories = $user->inventories;

        $deletedInventories = Inventory::onlyTrashed()->get(); //nak dapatkn yg dh soft delete

    return view('inventories.index', compact('inventories', 'deletedInventories'));
    }

    //
    public function create()
    {
        $this->authorize('create', Inventory::class); //ni kat policy

        return view('inventories.create');
    }

    public function store(InventoryRequest $request)
    {
        //POPO - Plain Old PHP
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $inventory = Inventory::create($data);
        auth()->user()->notify(new StoreInventoryNotification($inventory));
        return redirect()->route('inventories.index');
    }

    public function show(Inventory $inventory)
    {
        $this->authorize('view', $inventory); //ni kat policy
        return view('inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $this->authorize('update', $inventory); //pakai update punya policies
        return view('inventories.edit', compact('inventory'));
    }


        public function update(InventoryRequest $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);
        $data = $request->validated();
        $inventory->update($data);
        return redirect()->route('inventories.index');
    }

   public function delete(Inventory $inventory)
    {
        $this->authorize('delete', $inventory);
        $inventory->delete();

    return redirect()->route('inventories.index');
   }

   public function restore($inventory)
   {
    $inventory = Inventory::onlyTrashed()->find($inventory);
    $inventory->restore();

    return redirect()->route('inventories.index');

   }

   public function forceDelete($inventory)
   {
    $inventory = Inventory::onlyTrashed()->find($inventory);
    $inventory->forceDelete();

    return redirect()->route('inventories.index');

   }

}
