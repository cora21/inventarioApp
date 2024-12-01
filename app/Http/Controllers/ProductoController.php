<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller{


    public function index(){
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::all();
        return view('layouts.producto.index', compact('almacen', 'categoria', 'colores','proveedor','producto'));
    }

    public function create(){
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        return view('layouts.producto.index', compact('almacen', 'categoria', 'colores','proveedor'));
    }
        public function store(Request $request){
        // Validar los datos enviados desde el formulario
        $validated = $request->validate([
            'nombreProducto' => 'required|string',
            'marcaProducto' => 'required|string|',
            'modeloProducto' => 'nullable',
            'descripcionProducto' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'cantidadDisponibleProducto' => 'required|integer|min:0',
            'precioUnitarioProducto' => 'required|numeric|min:0',
            'precioTotal' => 'numeric',
        ], [
            'nombreProducto.required' => 'Este campo es obligatorio.',
            'marcaProducto.required' => 'Este campo es obligatorio.',
            'categoria_id.required' => 'Este campo es obligatorio.',
            'proveedor_id.required' => 'Este campo es obligatorio.',
            'almacen_id.required' => 'Este campo es obligatorio.',
            'cantidadDisponibleProducto.required' => 'Este campo es obligatorio.',
            'cantidadDisponibleProducto.integer' => 'Este campo debe contener números.',
            'precioUnitarioProducto.required' => 'Este campo es obligatorio.',
        ]);

        // Crear el producto manualmente
        $producto = new Producto();
        $producto->nombreProducto = $validated['nombreProducto'];
        $producto->marcaProducto = $validated['marcaProducto'];
        $producto->modeloProducto = $validated['modeloProducto'];
        $producto->descripcionProducto = $validated['descripcionProducto'];
        $producto->categoria_id = $validated['categoria_id'];
        $producto->proveedor_id = $validated['proveedor_id'];
        $producto->almacen_id = $validated['almacen_id'];
        $producto->cantidadDisponibleProducto = $validated['cantidadDisponibleProducto'];
        $producto->precioUnitarioProducto = $validated['precioUnitarioProducto'];
        $producto->precioTotal = $validated['precioTotal'];
        $producto->save(); // Guarda el producto en la base de datos
        // Registrar la relación en la tabla intermedia `producto_almacen`
        $producto->almacenes()->attach($validated['almacen_id'], [
            'cantidad' => $validated['cantidadDisponibleProducto'], // Usar cantidadDisponibleProducto como valor en la relación
        ]);
        // Redirigir al índice de productos con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente.');
    }
    public function show($id){
        $almacen = Almacen::find($id);
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::find($id);
        return view('layouts.producto.show', compact('almacen', 'categoria', 'colores','proveedor','producto'));
    }

    public function colores($id){
        // Obtener producto específico
        $producto = Producto::with('colores')->find($id);
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        return view('layouts.producto.colores', compact('almacen', 'categoria', 'colores','proveedor', 'producto'));
        //return route('producto.color', compact('almacen', 'categoria', 'colores','proveedor'));
    }

    public function guardarColores(Request $request, $id){
    // Validar los datos enviados desde el formulario
    $validated = $request->validate([
        'color_id' => 'required|array', // color_id debe ser un array
        'color_id.*' => 'exists:colores,id', // Cada id en color_id debe existir en la tabla colores
        'unidadesDisponibleProducto' => 'required|array', // unidadesDisponibleProducto debe ser un array
        'unidadesDisponibleProducto.*' => 'integer|min:1', // Cada cantidad debe ser un entero válido y al menos 1
    ]);

    // Buscar el producto al que se le asignarán los colores
    $producto = Producto::findOrFail($id);

    // Preparar los datos para la tabla intermedia
    $colores = $request->input('color_id'); // Array de IDs de colores
    $cantidades = $request->input('unidadesDisponibleProducto'); // Array de cantidades
    $data = [];
    foreach ($colores as $index => $colorId) {
        // Asegurarnos de que la cantidad corresponde al índice del color
        $data[$colorId] = ['unidadesDisponibleProducto' => $cantidades[$index]];
    }
    // Guardar en la tabla intermedia
    $producto->colores()->syncWithoutDetaching($data);

    // Redirigir con un mensaje de éxito
    return redirect()->route('producto.colores', $id)->with('success', 'Colores asignados correctamente al producto.');
}

public function imagenes($id){
    $almacen = Almacen::all();
    $categoria = Categoria::all();
    $colores = Color::all();
    $proveedor = Proveedor::all();
    $producto = Producto::find($id);
    return view('layouts.producto.imagenes', compact('almacen', 'categoria', 'colores','proveedor', 'producto'));
}
    public function guardarImagenes(Request $request, $id){
        // Validar que se han subido imágenes (puedes personalizar los mensajes si deseas)
        $request->validate([
            'ruta.*' => 'image', // Verifica que cada archivo sea una imagen válida
        ], [
            'ruta.*.image' => 'Cada archivo debe ser una imagen válida.',
        ]);
        // Verificar si el producto existe
        $producto = Producto::findOrFail($id);
        // Verificar si se subieron imágenes
        if ($request->hasFile('ruta')) {
            foreach ($request->file('ruta') as $file) {
                // Subir cada imagen a la carpeta storage/app/public/imagenes
                $path = $file->store('public/imagenes');

                // Obtener la URL accesible públicamente
                $url = Storage::url($path);

                // Crear un nuevo registro en la tabla imágenes
                Imagen::create([
                    'producto_id' => $producto->id,
                    'ruta' => $url,
                ]);
            }
        }
        // Redirigir con un mensaje de éxito
        return redirect()->route('producto.imagenes', $id)->with('success', 'Imágenes registradas exitosamente.');
    }




}
