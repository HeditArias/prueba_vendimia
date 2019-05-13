<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Item;
use App\Venta;
use App\DetalleVenta;

class VentaController extends Controller
{
	public function index(Request $request){
        if (!$request->ajax()) return redirect('/');

		$venta = Venta::join('clients','ventas.id_cliente','=','clients.id')
		->select(DB::raw("ventas.id, LPAD(ventas.id,5,'0') AS folio, LPAD(clients.id,5,'0') AS id_cliente, CONCAT(clients.name, ' ', clients.last_name, ' ', clients.mother_last_name) as name, ventas.total, DATE_FORMAT(ventas.created_at, '%d/%m/%Y') as fecha"))
		->get();

		return $venta;
	}

    public function agregar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $venta = new Venta();
            $venta->id_cliente = $request->id_cliente;
            $venta->enganche = $request->enganche;
            $venta->bonificacion_enganche = $request->bonificacion_enganche;
            $venta->total = $request->total;
            $venta->ahorro = $request->ahorro;
            $venta->pago_mensual = $request->pago_mensual;
            $venta->plazo = $request->plazo;
            $venta->estado = 'Registrado';
            $venta->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->id_venta = $venta->id;
                $detalle->id_articulo = $det['id_articulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->importe = $det['importe'];
                $detalle->descuento = 0;        
                $detalle->save();

                $firstUser = Item::find($det['id_articulo']); 
                $firstUser->decrement('existence', $det['cantidad']); 
            }      

            

            DB::commit();
            return [
                'id' => $venta->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function folio(Request $request){
        if (!$request->ajax()) return redirect('/');

        $Venta = Venta::select(DB::raw("CAST(id AS CHAR(4)) AS id"))
        ->orderby('id', 'DESC')
        ->take(1)
        ->first();

        if($Venta == null){
            $folio = 1;
        }else{
            $folio = $Venta->id;
            $folio = $folio + 1;
        }

        $folio = str_pad($folio,4,"0",STR_PAD_LEFT);
        return $folio;
    }
}
