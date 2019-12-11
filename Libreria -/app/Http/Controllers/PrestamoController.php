<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Prestamo;

class PrestamoController extends Controller
{
    public function prestarLibro(Request $request)
    {
        $prestamo= new Prestamo;
        $prestamo->user_id=$request->user_id;
        $prestamo->libro_id=$request->libro_id;
        $prestamo->fecha_prestamo=$request->fecha_prestamo;
        $prestamo->save();

    }
    public function devolverLibro(Request $request, $id)
    {
        $prestamo= Prestamo::find($id);
        $prestamo->fecha_devolucion = $request->fecha_devolucion;
        $prestamo->save();
    }


}