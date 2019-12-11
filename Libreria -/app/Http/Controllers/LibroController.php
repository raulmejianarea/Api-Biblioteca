<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libro;
use App\Prestamo;

class LibroController extends Controller
{
    public function listarTodos()
    {
        $libros = Libro::all(['id','titulo','autor','genero','Sinopsis']);
        
        return $libros;
    }

    public function listarAutor($autor) {
        $libros = Libro::all()->where('autor', $autor);
        return response()->json($libros);
    
    }
    public function listarGenero($genero) {
        $libros = Libro::all()->where('genero', $genero);
        return response()->json($libros);
    
    }

    public function agregarLibro(Request $request)
    {
        $response = array('error_code'=> 400, 'error_msg' => 'error al insertar info');

        $libros = new Libro;

        if (!$request->titulo)
            $response['error_msg'] = 'titulo es requerido';

        elseif(!$request->autor)
            $response['error_msg'] = 'autor es requerido';
        elseif(!$request->genero)
        $response['error_msg'] = 'Genero es requerido';
        elseif(!$request->sinopsis)
        $response['error_msg'] = 'El campo sinopsis es requerido';

        else{
            try{
                $libros->titulo=$request->input('titulo');
                $libros->autor=$request->input('autor');
                $libros->sinopsis=$request->input('sinopsis');
                $libros->genero=$request->input('genero');
                $libros->save();

                $response = array('error_code'=> 200, 'error_msg' => 'Se ha insertado todo correctamente');

            }
            catch(\Exception $e){
                $response = array('error_code'=>500, 'error_msg' => 'estoy en el catch');
            }
        }
        
        return response()->json($response);
    }

    public function editarLibro (Request $request, $id)
    {
        $response = array('error_code'=> 400, 'error_msg' => 'Libro '.$id.' No encontrado');
        $libro = Libro::find($id);
        if(!empty($libro)){
            $confirmacionDatos = true;
            $Mensaje = "";

            if(isset($request->titulo) && isset($request->autor) && isset($request->genero) && isset($request->sinopsis)){
                if (empty($request->titulo) && empty($request->autor) && empty($request->genero) && empty($request->sinopsis)){
                    $confirmacionDatos = false;
                    $Mensaje = "Hay campos vacios que no deben estar vacios";
                }else {
                    $libro->titulo = $request->titulo;
                    $libro->autor = $request->autor;
                    $libro->genero = $request->genero;
                    $libro->sinopsis = $request->sinopsis;
                }
            }
            if(!$confirmacionDatos){
                $response = array('error_code'=>400, 'error_msg' => 'error al editar info');
            }else {
                try{
                    $libro->save();
                    $response = array('error_code'=> 200, 'error_msg' => 'Se ha editado correctamente');
                }
                catch(\Exception $e){
                    $response = array('error_code'=>500, 'error_msg' => 'estoy en el catch');
                }
            }
        }
        return response()->json($response);
    }

    public function borrarLibro (Request $request, $id){
        $response = array('error_code'=> 400, 'error_msg' => 'Libro '.$id.' No encontrado');

        $libro = Libro::find($id);
        $prestamo = Prestamo::where('libro_id', $id)->whereNull('fecha_devolucion')->get();

        if(!empty($libro)){
            if(empty($prestamo)){
                $response = array('error_code'=> 400, 'error_msg' => 'el libro no se puede borrar, esta prestado');
            }else{
                try{
                    $libro->delete();
                    $response = array('error_code'=> 200, 'error_msg' => 'Se ha borrado correctamente');
                }catch(\Exception $e){
                    $response = array('error_code'=>500, 'error_msg' => 'estoy en el catch');
                }
            }
            
        }
        return response()->json($response);

    }

}
