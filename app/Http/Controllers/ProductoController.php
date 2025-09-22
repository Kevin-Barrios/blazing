<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::where('activo', 1)->get();
        return view('admin.vistaproductos', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.crearproducto', compact('categorias'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'talla' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'imagen' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
        ]);

        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('imagenes'), $nombreArchivo);
            $data['imagen'] = $nombreArchivo;
        }

        Producto::create($data);
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.editarproducto', compact('producto', 'categorias'));
    }


    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'talla' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
        ]);

        if ($request->hasFile('imagen')) {
            $rutaAnterior = public_path('imagenes/' . $producto->imagen);
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }

            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('imagenes'), $nombreArchivo);
            $data['imagen'] = $nombreArchivo;
        }

        $producto->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

       
        $rutaImagen = public_path('imagenes/' . $producto->imagen);
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}
