<?php

namespace App\Http\Controllers;

use DB;
use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $cliente = Client::select(DB::raw("LPAD(clients.id,5,'0') AS folio, CONCAT(clients.name, ' ', clients.last_name, ' ', clients.mother_last_name) as name"))
        ->get();

        return $cliente;
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $validate = DB::table('clients')->where('rfc', $request->rfc)->exists();

        if($validate == false){
            $cliente = new Client();
            $cliente->name = $request->name;
            $cliente->last_name = $request->last_name;
            $cliente->mother_last_name = $request->mother_last_name;
            $cliente->rfc = $request->rfc;

            $cliente->save();
        }else{
            return 'existe';
        }
    }

    public function edit(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $cliente = Client::find($id);
        $folio = $cliente->id;
        $folio = str_pad($folio,4,"0",STR_PAD_LEFT);

        return ['folio' => $folio, 'cliente' => $cliente];
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $cliente = Client::find($request->id);
        $cliente->name = $request->name;
        $cliente->last_name = $request->last_name;
        $cliente->mother_last_name = $request->mother_last_name;
        $cliente->rfc = $request->rfc;

        $cliente->save();
    }

    public function folio(Request $request){
        if (!$request->ajax()) return redirect('/');

        $cliente = Client::select(DB::raw("CAST(id AS CHAR(4)) AS id"))
        ->orderby('id', 'DESC')
        ->take(1)
        ->first();

        if($cliente == null){
            $folio = 1;
        }else{
            $folio = $cliente->id;
            $folio = $folio + 1;
        }

        $folio = str_pad($folio,4,"0",STR_PAD_LEFT);
        return $folio;
    }

    public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $clientes = Client::where('name', 'like', '%'. $filtro . '%')
        ->select(DB::raw("LPAD(clients.id,5,'0') AS folio, 
            CONCAT(clients.name, ' ', clients.last_name, ' ', clients.mother_last_name) AS name, 
            CONCAT('RFC: ', clients.rfc) AS rfc, 
            CONCAT(LPAD(clients.id,5,'0'), ' - ', clients.name, ' ', clients.last_name, ' ', clients.mother_last_name) AS cliente"))
        ->orderBy('name', 'asc')->get();

        return ['clientes' => $clientes];
    }
}
