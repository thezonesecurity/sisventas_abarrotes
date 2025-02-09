<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Categoria_producto;
use App\Models\Marca;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
      //$productos = Producto::with(['marca.caracteristica','presentacion.caracteristica'])->get();
      /* $productos = Producto::with(['productoscat.categoriascatprod'])->get();
       $productosa = Producto::with(['productoscat' => function ($query) {  }])->get();
        $productos = Producto::all();
   
       /*$productos = Producto::with([
        'author' => [
            'contacts',
            'publisher',
        ], ])->get();
         $query11 = DB::table('sistemaventas.productos as P1')
                ->select('CA.caracteristica_id')
                ->join('sistemaventas.categoria_producto as C', 'P1.id', '=', 'C.producto_id')
                ->join('sistemaventas.categorias as CA', 'CA.id', '=', 'C.categoria_id')
                ->where('P1.estado','Habilitado')
                ->get();

        dd($query11);
        */
       // $productos = Producto::where('estado','Habilitado')->get();
       $productos = Producto::with(['categorias.caracteristica','marca.caracteristica','presentacion.caracteristica'])->latest()->get();
       /// dd($productos);

        return view('productos.index',compact('productos')); // ['categorias' => $categorias]
    }

    public function create()
    {
        /*$marcas = Marca::join('caracteristicas as c','marcas.caracteristica_id', '=', 'c.id')
        ->where('c.estado','Habilitado')
        ->get();
        
        //return view('products.create', compact('marcas'));* /
        $resultado = Marca::whereHas('caracteristica',function($query) {
            return $query->where("caracteristica_id",'marca.id');
          })->get(); */
        //$marcas =  Marca::all();
        $marcas = Marca::select('id', 'caracteristica_id')->with([
            'caracteristica' => function ($query) {
                $query->select('id', 'nombre', 'descripcion', 'estado')->where('estado', 'Habilitado');
        }])->get();
       // dd($marcas);
        $presentaciones = Presentacion::select('id', 'caracteristica_id')->with([
            'caracteristica' => function ($query) {
                $query->select('id', 'nombre', 'descripcion', 'estado')->where('estado', 'Habilitado');
        }])->get();
        
        $categorias = Categoria::select('id', 'caracteristica_id')->with([
            'caracteristica' => function ($query) {
                $query->select('id', 'nombre', 'descripcion', 'estado')->where('estado', 'Habilitado');
        }])->get();
       // dd($presentaciones);

        return view('productos.create', compact('marcas', 'presentaciones','categorias'));
    }

    public function store(StoreProductoRequest  $request) //Request
    {
        
       // dd($request->categorias);
        try{
            DB::beginTransaction();
             
            $producto = new Producto(); //llenado a la tabla Productos
            if($request->hasFile('imagen_path')){
                $name = $producto->hanbleUloadImage($request->file('imagen_path'));
            }else{
                $name = null;
            }
            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'imagen_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacion_id' => $request->presentacion_id,
            ]);
          // dd($producto);
             $producto->save();

           /* $categorias = $request->get('categorias'); //llenado a la tabla Categoria-Producto
            dd($categorias);
            $producto->categorias()->attach($categorias);*/
            $pos=0;
            foreach ($request->categorias as $item) {
                $cat_prodcuto = new Categoria_producto();
                $cat_prodcuto->producto_id = $producto->id;
                $cat_prodcuto->categoria_id = $request->categorias[$pos];
               // dd($cat_prodcuto);
                $cat_prodcuto->save();
                $pos++;
            }
           // dd($producto);
            DB::commit();
        }catch(Exception $e){
            dd($e);
            DB::rollBack();
        }
        return redirect()->route('productos.index')->with('success','Producto registrado');
       
    }

    public function show($id)
    {
        //
    }

    public function edit(Producto $producto) //$id
    {
        $marcas = Marca::select('id', 'caracteristica_id')->with([
            'caracteristica' => function ($query) {
                $query->select('id', 'nombre', 'descripcion', 'estado')->where('estado', 'Habilitado');
        }])->get();
       //dd($marcas);
        $presentaciones = Presentacion::select('id', 'caracteristica_id')->with([
            'caracteristica' => function ($query) {
                $query->select('id', 'nombre', 'descripcion', 'estado')->where('estado', 'Habilitado');
        }])->get();
        
        $categorias = Categoria::select('id', 'caracteristica_id')->with([
            'caracteristica' => function ($query) {
                $query->select('id', 'nombre', 'descripcion', 'estado')->where('estado', 'Habilitado');
        }])->get();

        return view('productos.edit', compact('producto', 'marcas', 'presentaciones','categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto) //Request $request, $id
    {
       // dd('se cumple la validacion');
       try{
            DB::beginTransaction();
            //editado a la tabla Productos
            if($request->hasFile('imagen_path')){
                $name = $producto->hanbleUloadImage($request->file('imagen_path'));
                //eliminacion de la imagen anterior
                if(Storage::disk('public')->exists('productos/'.$producto->imagen_path)){
                    Storage::disk('public')->delete('productos/'.$producto->imagen_path);
                }
            }else{
                $name = $producto->imagen_path;
            }
            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'imagen_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacion_id' => $request->presentacion_id,
            ]);
          // dd($producto);
             $producto->save();

            $categorias = $request->get('categorias'); //llenado a la tabla Categoria-Producto
         //   dd($categorias);
            $producto->categorias()->sync($categorias);
          
            DB::commit();
        }catch(Exception $e){
            dd($e);
            DB::rollBack();
        }
        return redirect()->route('productos.index')->with('success','Producto actualizado');
    }

    public function destroy($id)
    {
         //  dd($id);
         $mensaje = '';
         $producto = Producto::find($id);
         if($producto->estado == 'Habilitado'){
             Producto::where('id',$producto->id)
             ->update([
                'estado' => 'Eliminado'
             ]);
             $mensaje = 'Producto eliminado';
         }else{
             Producto::where('id',$producto->id)
             ->update([
                'estado' => 'Habilitado'
             ]);
             $mensaje = 'Producto restaurado';
         }
        
          return redirect()->route('productos.index')->with('success', $mensaje);
    }
}
