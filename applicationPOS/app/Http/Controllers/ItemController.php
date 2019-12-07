<?php

namespace App\Http\Controllers;

use App\Http\Middleware\OwnerOnly;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(OwnerOnly::class)->except('index','listItem');
    }

    public function index(){
        $items = Item::all();
        return view('itemIndex')->with('items', $items);
    }

    public function create(){
        return view('createItem');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'namaBarang' => 'required|string|max:100|unique:items,nama_barang',
            'hargaBarang' => 'required|digits_between:3,6|',
            'stokBarang' => 'numeric|min:1',
            'gambarBarang' => 'file|mimes:jpeg,png|max:20000',
            'tipeBarang' => 'string|required|',
        ]);
        $imagePath = $request->file('gambarBarang')->store('items',['disk' => 'public']);
        $item = Item::create([
            'nama_barang' => $validated['namaBarang'],
            'harga' => $validated['hargaBarang'],
            'stok'=> $validated['stokBarang'],
            'image' => $imagePath,
            'tipe_barang' => $validated['tipeBarang'],
        ]);
        return redirect('/item');
    }

    public function edit(Request $request,$id){
        $item = Item::findOrFail($id);
        return view('editItem')->with('item', $item);
    }

    public function update(Request $request, $id){
        if($id != $request->input('id')){
            redirect()->back()->withErrors(['Validation Error', 'please refresh the edit page and resubmit the form']);
        }
        $item = Item::find($id);

        $validated = $request->validate([
            'namaBarang' => 'required|string|max:100',
            'hargaBarang' => 'required|digits_between:3,6|',
            'stokBarang' => 'numeric|min:1',
            'gambarBarang' => 'file|mimes:jpeg,png|max:20000',
            'tipeBarang' => 'string|required|',
        ]);
        if($request->hasFile('gambarBarang')){
            Storage::delete($item->image);
            $item->image = $request->file('gambarBarang')->store('items',['disk' => 'public']);
        }
        $item->nama_barang = $validated['namaBarang'];
        $item->harga = $validated['hargaBarang'];
        $item->stok = $validated['stokBarang'];
        $item->tipe_barang = $validated['tipeBarang'];

        $item->save();

        return redirect('/item');
    }

    public function updateStock(Request $request, $id) {
        if($id != $request->input('id')){
            redirect()->back()->withErrors(['Validation Error', 'please refresh the edit page and resubmit the form']);
        }
        $item = Item::find($id);

        $validated = $request->validate([
            'stok' => 'numeric|min:0|required'
        ]);

        $item->stok = $validated['stok'];
        $item->save();

        return redirect('/item');
    }

    public function listItem(Request $request, $tipeBarang){
        $items = Item::where('tipe_barang', $tipeBarang)->select('id','nama_barang','harga')->get();
        return $items;
    }
}
