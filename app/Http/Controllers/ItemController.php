<?php

namespace App\Http\Controllers;

use DB;
use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Item::select(DB::raw("LPAD(items.id,5,'0') AS folio, items.description"))
        ->get();

        return $articulo;
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $validate = DB::table('items')->where('model', $request->model)->exists();

        if($validate == false){
            $articulo = new Item();
            $articulo->description = $request->description;
            $articulo->model = $request->model;
            $articulo->price = $request->price;
            $articulo->existence = $request->existence;

            $articulo->save();
        }else{
            return 'existe';
        }
    }

    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Item::find($id);
        $folio = $articulo->id;
        $folio = str_pad($folio,4,"0",STR_PAD_LEFT);

        return ['folio' => $folio, 'articulo' => $articulo];
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $articulo = Item::find($request->id);
        $articulo->description = $request->description;
        $articulo->model = $request->model;
        $articulo->price = $request->price;
        $articulo->existence = $request->existence;

        $articulo->save();
    }

    public function folio(Request $request){
        if (!$request->ajax()) return redirect('/');

        $articulo = Item::select(DB::raw("CAST(id AS CHAR(4)) AS id"))
        ->orderby('id', 'DESC')
        ->take(1)
        ->first();

        if($articulo == null){
            $folio = 1;
        }else{
            $folio = $articulo->id;
            $folio = $folio + 1;
        }

        $folio = str_pad($folio,4,"0",STR_PAD_LEFT);
        return $folio;
    }

    public function buscarArticuloVenta(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Item::where('id','=', $filtro)
        ->orWhere('description', 'like', '%'. $filtro . '%')
        ->where('existence','>','0')
        ->orderBy('description', 'asc')
        ->get();

        return ['articulos' => $articulos];
    }
}
