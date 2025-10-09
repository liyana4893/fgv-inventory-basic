<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function store(Request $request)
    { 
        //POPO - Plain Old PHP
        $inventory = new Inventory();
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->quantity = $request->quantity;
        $inventory->user_id = auth()->user()->id;
        $inventory->save();

        auth()->user()->notify(new StoreInventoryNotification($inventory)); //inventory utk keluarkan nama edit jgk kat notification

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


        public function update(Request $request, Inventory $inventory)
    { 
        $this->authorize('update', $inventory);
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->quantity = $request->quantity;
        $inventory->save();

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
