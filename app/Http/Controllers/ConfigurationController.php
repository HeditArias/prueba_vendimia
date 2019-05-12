<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()) return redirect('/');

        return Configuration::find(1);
    }

    public function edit(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $confi = Configuration::count();

        if($confi == 0){
            return $confi;
        }else{
            $configuracion = Configuration::find(1);
            return $configuracion;
        }
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $confi = new Configuration();
        $confi->financing_rate = $request->financing_rate; 
        $confi->percentage_hitch = $request->percentage_hitch;
        $confi->maximum_term = $request->maximum_term;

        $confi->save();

    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $confi = Configuration::find($request->id);
        
        $confi->financing_rate = $request->financing_rate; 
        $confi->percentage_hitch = $request->percentage_hitch;
        $confi->maximum_term = $request->maximum_term;

        $confi->save();
    }
}
