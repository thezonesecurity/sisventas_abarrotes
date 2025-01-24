<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Caracteristica;
use App\Models\Marca;
use Exception;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        //dd($marcas);
        return view('marcas.index', ['marcas' => $marcas]);
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function store(StoreMarcaRequest $request) //Request $reques
    {
        // dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->marca()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('marcas.index')->with('success','Marca registrada');
    }

    public function edit(Marca $marca) //$id
    {
        //dd($marca);
        return view('marcas.edit',['marca' => $marca]);
    }

    public function update(UpdateMarcaRequest $request, Marca $marca)//Request $request, $id 
    {
        $marca->caracteristica->update($request->all());
        
        return redirect()->route('marcas.index')->with('success', 'marca editada');
    }

    public function destroy($id)
    {
        //dd($id);
        $mensaje = '';
        $marca = Marca::find($id);
        if($marca->caracteristica->estado == 'Habilitado'){
            Caracteristica::where('id',$marca->caracteristica->id)
            ->update([
               'estado' => 'Eliminado'
            ]);
            $mensaje = 'marca eliminado';
        }else{
            Caracteristica::where('id',$marca->caracteristica->id)
            ->update([
               'estado' => 'Habilitado'
            ]);
            $mensaje = 'marca restaurada';
        }
       
         return redirect()->route('marcas.index')->with('success', $mensaje);
    }
}
