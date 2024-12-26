@extends('layouts.app')

@section('title', 'Registra las imagenes del producto')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* Estilo para animación */
    .icono-eliminar {
        transition: color 0.3s ease;
    }

    .icono-eliminar:hover {
        color: red;
    }
    .estilos{
        font-size: 1.5rem;
        color: black;
    }
</style>
@section('contenido')
    <h1>Aqui registro las imagenes de los productos</h1>
    <br>
    <p class="h4">
        El Producto <strong>{{ $producto->nombreProducto }}</strong> dispone de las siguientes fotos
    </p>
    <br>
    <!-- Button trigger modal -->
    <div class="d-flex justify-content-between">
        <!-- Botón alineado a la izquierda -->
        <a href="{{ route('producto.index') }}" type="button" class="btn btn-primary">
            Regresar
        </a>

        <!-- Botón alineado a la derecha con el modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            + Registra las imagenes
        </button>
    </div>
<br>
    <!-- Modal -->
  <div class="container my-5">
    <h2 class="text-center mb-4">Galería de las Fotos del producto {{ $producto->nombreProducto }}</h2>
    <div class="row g-4">
        @foreach($producto->imagenes as $imagen)
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <img src="{{ $imagen->ruta }}" class="card-img-top rounded" alt="Imagen del producto"
                            style="cursor: pointer;" onclick="abrirImagen('{{ $imagen->ruta }}')">
                                <div class="d-flex justify-content-center align-items-center mt-3" style="height: 100%;">
                                    <a type="submit" onclick="eliminarImagen({{ $imagen->id }})" style="text-decoration: none;">
                                        <i class="bi bi-trash icono-eliminar estilos"></i>
                                    </a>
                                </div>
                            <p>
                                   <strong>Nombre:</strong> {{ $imagen->id }}<br>
                            </p>
                </div>
                <div id="imagenModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.8); z-index: 1000; justify-content: center; align-items: center;">
                    <span style="position: absolute; top: 10px; right: 20px; color: white; font-size: 30px; cursor: pointer;" onclick="cerrarModal()">×</span>
                    <img id="imagenModalSrc" src="" alt="Imagen del producto" style="max-width: 90%; max-height: 90%; border-radius: 8px;">
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            {{-- como no usaremos la imagen guardamos el div aqui --}}
                            {{-- me permite el cuadro de la imagen --}}
                            <form action="{{ route('producto.guardarImagenes', $producto->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="container mt-5">
                                    <label for="" class="form-label">Sube las imagenes:</label><span class="text-danger" style="font-size: 1.2rem;"> * </span>
                                    <div class="p-4 border border-dashed rounded-3 text-center" style="background-color: rgb(232, 237, 246)">
                                        <label for="file-upload" class="d-block">
                                            <i class="bi bi-cloud-upload fs-1 text-secondary"></i>
                                            <div class="mt-2 text-secondary">
                                                <strong>Sube las Imagenes </strong><br>
                                                ó arrastra los archivos aqui
                                            </div>
                                        </label>
                                        <input id="file-upload" type="file" name="ruta[]" class="form-control d-none" accept="image/*" multiple />
                                    </div>
                                </div>

                                <div id="preview-container" class="mt-4 text-center d-none">
                                    <!-- Preview multiple images -->
                                    <div id="preview-images" class="d-flex justify-content-center"></div>
                                    <p class="mt-2 text-secondary">Visualización de las imágenes</p>
                                </div>

                                <div class="col-md-4">
                                    <label for="" class="form-label"></label>
                                    <input type="hidden" name="producto_id[]" value="{{ $producto->id }}">
                                </div>
                        </div>
                    </div>
                    {{-- los scrips para que funcione --}}
                    <div class="text-center">
                        @if (5 - $cantidadImagenes === 1)
                        <p style="font-size: 1rem;">Este producto tiene: <strong>{{ $cantidadImagenes }}</strong>  imágenes registradas.</p>
                        <p style="font-size: 1rem;">Puedes registrar máximo <strong>una</strong> imágen más todavía.</p>
                        @elseif ($cantidadImagenes === 5)
                        <p style="font-size: 1rem; color: red;">No puedes registrar más imagenes</p>
                        @else
                            <p style="font-size: 1rem;">Este producto tiene: <strong>{{ $cantidadImagenes }}</strong>  imágenes registradas.</p>
                            <p style="font-size: 1rem;">Puedes registrar máximo <strong>{{ 5 - $cantidadImagenes }}</strong> imágenes todavía.</p>
                        @endif

                    </div>

                    <script>
                        // Establecer el límite máximo dinámico
                        const maxFiles = 5 - {{ $cantidadImagenes }}; // Resta el número actual de imágenes guardadas

                        // Capturar el input y el contenedor de la vista previa
                        const fileInput = document.getElementById('file-upload');
                        const previewContainer = document.getElementById('preview-container');
                        const previewImagesContainer = document.getElementById('preview-images');

                        fileInput.addEventListener('change', function () {
                            // Limpiar las imágenes previas
                            previewImagesContainer.innerHTML = '';

                            // Revisamos si se han seleccionado archivos
                            const files = this.files;
                            if (files.length > maxFiles) {
                                // Mostrar SweetAlert2
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Límite excedido',
                                    text: `Solo puedes subir un máximo de ${maxFiles} imágenes adicionales.`,
                                    confirmButtonText: 'Entendido',
                                    timer: 3000 // Opcional: cierra automáticamente después de 3 segundos
                                });

                                this.value = ''; // Limpiar el input
                                previewContainer.classList.add('d-none'); // Ocultar la vista previa si no hay archivos
                                return;
                            }

                            if (files.length > 0) {
                                previewContainer.classList.remove('d-none'); // Mostrar la vista previa

                                // Iterar sobre los archivos seleccionados
                                Array.from(files).forEach(file => {
                                    const reader = new FileReader();

                                    reader.onload = function (e) {
                                        // Crear una imagen y agregarla al contenedor de vista previa
                                        const img = document.createElement('img');
                                        img.src = e.target.result;
                                        img.classList.add('img-fluid', 'rounded', 'm-2');
                                        img.style.maxWidth = '100px'; // Controlar tamaño de las vistas previas
                                        img.style.height = '100px';

                                        previewImagesContainer.appendChild(img);
                                    };

                                    reader.readAsDataURL(file); // Leer el archivo como Data URL
                                });
                            } else {
                                previewContainer.classList.add('d-none'); // Ocultar la vista previa si no hay archivos
                            }
                        });
                    </script>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        </form>
        </div>
    </div>
    <!-- Modal para mostrar la imagen  en el modal-->
    <script>
        // Función para abrir la imagen en el modal
        function abrirImagen(ruta) {
            const modal = document.getElementById('imagenModal');
            const modalImg = document.getElementById('imagenModalSrc');
            modalImg.src = ruta; // Asigna la ruta de la imagen
            modal.style.display = 'flex'; // Muestra el modal
        }

        // Función para cerrar el modal
        function cerrarModal() {
            const modal = document.getElementById('imagenModal');
            modal.style.display = 'none'; // Oculta el modal
        }
    </script>
    <script>
        function eliminarImagen(id) {
    // SweetAlert de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta imagen será eliminada permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviar la solicitud DELETE al servidor
            fetch(`/imagenes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recargar la página después de la eliminación
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ocurrió un error al eliminar la imagen.',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ocurrió un error al procesar la solicitud.',
                });
            });
        }
    });
}

    </script>
@endsection
