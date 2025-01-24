<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePresentacionRequest;
use App\Http\Requests\UpdatePresentacionRequest;
use Illuminate\Http\Request;
use App\Models\Caracteristica;
use App\Models\Presentacion;
use Exception;


class PresentacionController extends Controller
{
   
    public function index()
    {
        $presentaciones = Presentacion::with('caracteristica')->latest()->get();
        //dd($presentaciones);
        return view('presentaciones.index', ['presentaciones' => $presentaciones]); //
    }

    public function create()
    {
        return view('presentaciones.create');
    }

    public function store(StorePresentacionRequest $request)
    {
         // dd($request);
         try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacion()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('presentacion.index')->with('success','presentacion registrada');
    }

    public function edit(Presentacion $presentacion)
    {
       // dd($presentacion);
        return view('presentaciones.edit', ['presentacion' => $presentacion]);
    }

    public function update(UpdatePresentacionRequest $request, Presentacion $presentacion) //Request $request, $id
    {
        //dd($request);
        $presentacion->caracteristica->update($request->all());
        
        return redirect()->route('presentacion.index')->with('success', 'Presentacion editada');
    }

    public function destroy($id)
    {
      //  dd($id);
        $mensaje = '';
        $presentacion = Presentacion::find($id);
        if($presentacion->caracteristica->estado == 'Habilitado'){
            Caracteristica::where('id',$presentacion->caracteristica->id)
            ->update([
               'estado' => 'Eliminado'
            ]);
            $mensaje = 'Categoria eliminado';
        }else{
            Caracteristica::where('id',$presentacion->caracteristica->id)
            ->update([
               'estado' => 'Habilitado'
            ]);
            $mensaje = 'Categoria restaurada';
        }
       
         return redirect()->route('presentacion.index')->with('success', $mensaje);
    }
}
