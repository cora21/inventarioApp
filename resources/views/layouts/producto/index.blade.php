@extends('layouts.app')

@section('title', 'Registro del producto')

@section('contenido')
<!-- Agregar Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<style>
  .hover-shadow:hover {
      filter: brightness(0.5);
      transform: scale(2);
      transition: all 0.1s;
  }
</style>

<h1>comienza el modulo mas arrecho con la fé puesta en dios y creyendo en mi todo saldra bien</h1>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    + Nuevo Producto
  </button>
  <br><br>
  <table class="table table-hover">
    <thead>
      <tr style="background-color: rgb(212, 212, 212); ">
        <th scope="col" style="border-radius: 15px 0px 0px 0px;">Producto</th>
        <th class="bordered">Marca</th>
        <th>Precio</th>
        <th>Cantidad Total</th>
        <th scope="col" style="border-radius: 0px 15px 0px 0px;">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($producto as $row)
      <tr>
        <td><a href="" class="text-primary hover-shadow">{{$row->nombreProducto}}</a></td>
        <td>{{$row->marcaProducto}}</td>
        <td>${{$row->precioUnitarioProducto}}</td>
        <td>{{$row->cantidadDisponibleProducto}}</td>
        <td>
          <div class="d-flex gap-3">
            <!-- Icono de Editar -->
            <a href="#" class="text-primary hover-shadow" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                <i class="bi bi-pencil-square fs-4"></i>
            </a>
            <!-- Icono de Subir Foto -->
            <a href="#" class="text-primary hover-shadow" data-bs-toggle="tooltip" data-bs-placement="top" title="Subir Foto">
                <i class="bi bi-camera fs-4"></i>
            </a>
            <!-- Icono de Agregar Colores -->
            <a href="{{route('producto.colores', $row->id)}}" class="text-primary hover-shadow" data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar Colores">
                <i class="bi bi-palette fs-4"></i>
            </a>
        </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>














  <!-- Modal registro del formulario-->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #8cc7bf">
          <h1 class="modal-title" id="exampleModalLabel">Nuevo Producto</h1>
        </div>
        <div class="modal-body" style="background-color: #E0E0E0">
            {{-- da incio lo interno al modal --}}
          <div class="card">
            <div class="card-body">
                <form action="{{ route('producto.store') }}" method="post" class="row g-3">
                  @csrf
                    <div class="col-md-4">
                      <label for="" class="form-label">Nombre:</label></strong><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                      <input type="text" name="nombreProducto" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-md-4">
                      <label for="" class="form-label">Marca:</label></strong><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                      <input type="text" name="marcaProducto" class="form-control" id="">
                    </div>
                    <div class="col-4">
                      <label for="inputAddress" class="form-label">Modelo:</label></strong><span class="text-light" style="font-size: 1.2rem;"> * </span>
                      <input type="text" name="modeloProducto" class="form-control" id="inputAddress" placeholder="">
                    </div>
                    <div class="col-12 mb-3">
                      <label for="inputAddress" class="form-label">Descripción:</label>
                      <textarea name="descripcionProducto" class="form-control" aria-label="With textarea" style="withd: 100%; height: 90%; resize: none;"></textarea>
                    </div>
                    <br>
                    <div class="col-4">
                      <label for="inputState" class="form-label">Categorias:</label></strong><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                      <select name="categoria_id" id="inputState" class="form-select">
                        <option value="">- Seleccione -</option>
                        @foreach ($categoria as $categorias)
                            <option value="{{ $categorias->id }}">{{ $categorias->nombre }}</option> 
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="inputState" class="form-label">Proveedor:</label></strong><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                      <select name="proveedor_id" id="inputState" class="form-select">
                        <option value="">- Seleccione -</option>
                        @foreach ($proveedor as $proveedores)
                            <option value="{{ $proveedores->id }}">{{ $proveedores->nombreProveedor }}</option> 
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label for="almacen_id" class="form-label">Almacen:</label></strong><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                      <select name="almacen_id" id="almacen_id" class="form-select">
                        <option value="">- Seleccione -</option>
                        @foreach ($almacen as $valor)
                            <option value="{{ $valor->id }}">{{ $valor->nombre }}</option> 
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Cantidad Disponible:</label><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                        <input type="text" name="cantidadDisponibleProducto" class="form-control" id="cantidadDisponibleProducto" oninput="calcularPrecioTotal()">
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Precio Unitario:</label><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                        <input type="text" step="0.01" name="precioUnitarioProducto" class="form-control" id="precioUnitarioProducto" oninput="calcularPrecioTotal()">
                    </div>
                    <div class="col-4">
                        <label for="" class="form-label">Total</label><span class="text-light" style="font-size: 1.2rem;"> * </span>
                        <input type="text" name="precioTotal" class="form-control" id="precioTotal" readonly>
                    </div>
                  
            </div>
          </div>
          <script>
            // Función para calcular el precio total
            function calcularPrecioTotal() {
                // Obtener los valores de los campos de cantidad y precio unitario
                var cantidad = parseFloat(document.getElementById("cantidadDisponibleProducto").value);
                var precioUnitario = parseFloat(document.getElementById("precioUnitarioProducto").value);
        
                // Calcular el precio total
                if (!isNaN(cantidad) && !isNaN(precioUnitario)) {
                    var precioTotal = cantidad * precioUnitario;
                    // Mostrar el resultado en el campo de precioTotal
                    document.getElementById("precioTotal").value = precioTotal.toFixed(2); // Formateamos a dos decimales
                } else {
                    // Si los valores no son válidos, limpiamos el campo de precioTotal
                    document.getElementById("precioTotal").value = '';
                }
            }
        </script>
        <script>
          function formatDecimal(input) {
              // Elimina cualquier carácter no numérico excepto el punto
              let value = input.value.replace(/[^0-9.]/g, "");
              
              // Convierte el valor en un número flotante
              let number = parseFloat(value);
              
              // Si es un número válido, formatea a dos decimales
              if (!isNaN(number)) {
                  input.value = number.toFixed(2);
              } else {
                  input.value = ""; // Si no es válido, limpia el campo
              }
          }
        </script>
          {{-- da inicio lo de aqui para arriba el modal --}}
        </div>
        <div class="modal-footer">
          <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger"
                  style="font-size: 1.2rem;">*</span>
              <strong> son obligatorios</strong>
          </p>
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary text-gray">Guardar</button>
      </div>
      </div>
    </div>
  </div>
</form>
@endsection
{{-- como no usaremos la imagen guardamos el div aqui --}}
{{-- me permite el cuadro de la imagen --}}
{{-- 
  <div class="container mt-5">
                        <div class="p-4 border border-dashed rounded-3 text-center" style="background-color: rgb(232, 237, 246)">
                          <label for="file-upload" class="d-block">
                            <i class="bi bi-cloud-upload fs-1 text-secondary"></i>
                            <div class="mt-2 text-secondary">
                              <strong>Sube Una Imagen</strong><br>
                              Arrastra los archivos aqui
                            </div>
                          </label>
                          <input id="file-upload" type="file" class="form-control d-none" />
                        </div>
                      </div>
                      <div id="preview-container" class="mt-4 text-center d-none">
                        <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="max-width: 20%; height: auto;" />
                        <p class="mt-2 text-secondary">Visualización de la imagen</p>
                      </div>
  
  
  --}}

  {{-- los scrips para que funcione --}}

  {{-- 
            <script>
            document.getElementById('file-upload').addEventListener('change', function() {
            const label = this.previousElementSibling;
            const fileName = this.files[0]?.name || "No file selected";
            label.innerHTML = `<i class="bi bi-cloud-upload fs-1 text-secondary"></i>
                <div class="mt-2 text-secondary">
                <strong>${fileName}</strong>
                </div>`;
            });
            // Capturar el input y el contenedor de la vista previa
            const fileInput = document.getElementById('file-upload');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');

            fileInput.addEventListener('change', function () {
            const file = this.files[0]; // Tomar el archivo seleccionado
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                // Mostrar la imagen en el contenedor
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
                };
                reader.readAsDataURL(file); // Leer el archivo como Data URL
            } else {
                // Ocultar la vista previa si no hay archivo
                previewContainer.classList.add('d-none');
            }
            });
        </script>
    --}}