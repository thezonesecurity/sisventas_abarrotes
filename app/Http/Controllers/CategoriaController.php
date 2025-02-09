<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Caracteristica;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::with('caracteristica')->latest()->get();
        //dd($categorias);
        return view('categorias.index', ['categorias' => $categorias]);
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request) //Request $reques
    {
       // dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->categoria()->create([
                'caracteristica_id' => $caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('categorias.index')->with('success','Categoria registrada');
    }

    public function show($id)
    {
        //
    }

    public function edit(Categoria $categoria) //$id
    {
       // dd($categoria);
        return view('categorias.edit',['categoria' => $categoria]);
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria) //Request $request, $id
    {
       // dd($request);
       /* dd($request->nombre);
        $dato = Caracteristica::where('id',$categoria->caracteristica->id);
         dd($dato);
        $dato = Caracteristica::where('id',$categoria->caracteristica_id);
       // dd( $id);
         Caracteristica::where('id',$categoria->caracteristica->id)->update($request->validate());*/ 
         $validated = $request->validated();
         Caracteristica::where('id',$categoria->caracteristica->id)->update($validated);
       // $categoria->caracteristica->update($request->all());
        
        return redirect()->route('categorias.index')->with('success', 'Categoria editada');
    }

    public function destroy($id)
    {
       // dd($id);
       $mensaje = '';
        $categoria = Categoria::find($id);
        if($categoria->caracteristica->estado == 'Habilitado'){
            Caracteristica::where('id',$categoria->caracteristica->id)
            ->update([
               'estado' => 'Eliminado'
            ]);
            $mensaje = 'Categoria eliminado';
        }else{
            Caracteristica::where('id',$categoria->caracteristica->id)
            ->update([
               'estado' => 'Habilitado'
            ]);
            $mensaje = 'Categoria restaurada';
        }
       
         return redirect()->route('categorias.index')->with('success', $mensaje);
    }
}
