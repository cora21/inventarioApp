<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Color;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Imagen;
use App\Models\TasasCambios;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller{


    public function index(){
        $tasas = TasasCambios::all();
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::all();

        $bajoInventario = $producto->some(function ($row) {
            return ($row->totalDescontable / $row->cantidadDisponibleProducto) * 100 <= 10;
        });
        // buscando la tasa de cambio de ves a dolares
        $vesBaseMoneda = DB::table('tasas_cambios')->where('id', 2)->value('baseMoneda');
        $vesBaseMoneda = (int) $vesBaseMoneda;


        $dolarBCV = DB::table('tasas_cambios')->where('id', 2)->value('valorMoneda');
        $dolarBCV = number_format($dolarBCV, 2);
        return view('layouts.producto.index', compact('almacen', 'categoria', 'colores','proveedor','producto', 'bajoInventario', 'tasas', 'vesBaseMoneda', 'dolarBCV'));
    }

    public function edit($id){
        $producto = Producto::find($id);
        $tasas = TasasCambios::all();
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        return view('layouts.producto.edit', compact('producto', 'almacen', 'categoria', 'colores','proveedor', 'tasas'));
    }

    public function create(){
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        return view('layouts.producto.index', compact('almacen', 'categoria', 'colores','proveedor'));
    }

    public function store(Request $request){
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
            // Asigna el valor de cantidadDisponibleProducto a totalDescontable
            $producto->totalDescontable = $validated['cantidadDisponibleProducto'];  // Aquí lo asignamos
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

    public function update(Request $request, $id){

        $validated = $request->validate([
            'nombreProducto' => 'required|string',
            'marcaProducto' => 'required|string',
            'modeloProducto' => 'nullable',
            'descripcionProducto' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'cantidadDisponibleProducto' => 'required|integer|min:0',
            'precioUnitarioProducto' => 'required|numeric|min:0',
            'precioTotal' => 'nullable',
        ], [
            'nombreProducto.required' => 'Este campo es obligatorio.',
            'marcaProducto.required' => 'Este campo es obligatorio.',
            'categoria_id.required' => 'Este campo es obligatorio.',
            'proveedor_id.required' => 'Este campo es obligatorio.',
            'almacen_id.required' => 'Este campo es obligatorio.',
            'cantidadDisponibleProducto.required' => 'Este campo es obligatorio.',
            'cantidadDisponibleProducto.integer' => 'Este campo debe contener números.',
        ]);

        // Buscar el producto existente
        $producto = Producto::findOrFail($id);

        // Actualizar los campos del producto
        $producto->nombreProducto = $validated['nombreProducto'];
        $producto->marcaProducto = $validated['marcaProducto'];
        $producto->modeloProducto = $validated['modeloProducto'];
        $producto->descripcionProducto = $validated['descripcionProducto'];
        $producto->categoria_id = $validated['categoria_id'];
        $producto->proveedor_id = $validated['proveedor_id'];
        $producto->almacen_id = $validated['almacen_id'];
        $producto->cantidadDisponibleProducto = $validated['cantidadDisponibleProducto'];
        $producto->totalDescontable = $validated['cantidadDisponibleProducto']; // Actualizar totalDescontable
        $producto->precioUnitarioProducto = $validated['precioUnitarioProducto'];
        $producto->precioTotal = $validated['precioTotal'];

        // Guardar los cambios en la base de datos
        $producto->save();

        // Actualizar la relación en la tabla intermedia `producto_almacen`
        $producto->almacenes()->sync([
            $validated['almacen_id'] => [
                'cantidad' => $validated['cantidadDisponibleProducto'], // Actualizar cantidad en la relación
            ],
        ]);
        // Redirigir al índice de productos con un mensaje de éxito
        return redirect()->route('producto.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function show($id){
        $almacen = Almacen::find($id);
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        $producto = Producto::find($id);
        $vesBaseMoneda = DB::table('tasas_cambios')->where('id', 2)->value('baseMoneda');
        $vesBaseMoneda = (int) $vesBaseMoneda;


        $dolarBCV = DB::table('tasas_cambios')->where('id', 2)->value('valorMoneda');
        $dolarBCV = number_format($dolarBCV, 2);
        return view('layouts.producto.show', compact('almacen', 'categoria', 'colores','proveedor','producto', 'vesBaseMoneda', 'dolarBCV'));
    }

        public function colores($id){
            $producto = Producto::with('colores')->find($id);
            $totalUnidadesConColor = $producto->colores->sum('pivot.unidadesDisponibleProducto');

            $almacen = Almacen::all();
            $categoria = Categoria::all();
            $colores = Color::all();
            $proveedor = Proveedor::all();
            // Pasar la suma de unidades a la vista
            return view('layouts.producto.colores', compact('almacen', 'categoria', 'colores', 'proveedor', 'producto', 'totalUnidadesConColor'));
    }

    public function guardarColores(Request $request, $id){
        // Validar los datos enviados desde el formulario
        $validated = $request->validate([
            'color_id' => 'required|array', // color_id debe ser un array
            'color_id.*' => 'required|integer|exists:colores,id', // Cada elemento debe ser un entero válido y existir en la tabla colores
            'unidadesDisponibleProducto' => 'required|array', // unidadesDisponibleProducto debe ser un array
            'unidadesDisponibleProducto.*' => 'required|integer|min:1', // Cada cantidad debe ser un entero válido y al menos 1
        ], [
            'color_id.required' => 'Debes seleccionar al menos un color.',
            'color_id.*.required' => 'Debes seleccionar un color válido para cada entrada.',
            'color_id.*.integer' => 'El color seleccionado no es válido.',
            'color_id.*.exists' => 'El color seleccionado no existe en la base de datos.',
            'unidadesDisponibleProducto.required' => 'Debe contener por lo menos un producto.',
            'unidadesDisponibleProducto.*.integer' => 'Debe contener por lo menos un producto.',
            'unidadesDisponibleProducto.*.min' => 'Cada unidad debe ser al menos 1.',
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

    public function imagenes($id) {
        $almacen = Almacen::all();
        $categoria = Categoria::all();
        $colores = Color::all();
        $proveedor = Proveedor::all();
        //$imagen = Imagen::all();
        $producto = Producto::find($id);

        // Contar cuántos registros hay en la tabla imagenes con el mismo producto_id
        $cantidadImagenes = Imagen::where('producto_id', $id)->count(); // Asegúrate de que 'id_producto' sea el nombre correcto de la columna

        return view('layouts.producto.imagenes', compact('almacen', 'categoria', 'colores', 'proveedor', 'producto', 'cantidadImagenes'));
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

    public function buscar(Request $request){
        $termino = $request->get('q', '');

        // Buscar productos por nombre y categoría
        $productos = Producto::with(['categoria', 'colores'])
            ->where('nombreProducto', 'like', '%' . $termino . '%')
            ->orWhereHas('categoria', function ($query) use ($termino) {
                $query->where('nombre', 'like', '%' . $termino . '%');
            })
            ->get();

        return response()->json($productos);
    }

    public function destroy($id){
    // Encuentra la imagen por ID
    $imagen = Imagen::findOrFail($id);
    // Elimina el archivo físico de la imagen si existe
    if (file_exists(public_path($imagen->ruta))) {
        unlink(public_path($imagen->ruta));
    }
    // Elimina la imagen de la base de datos
    $imagen->delete();
    return response()->json(['success' => 'Imagen eliminada correctamente.']);
}




}
