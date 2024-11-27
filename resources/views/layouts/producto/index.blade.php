@extends('layouts.app')

@section('title', 'Registro de las categorias')

@section('contenido')
<h1>comienza el modulo mas arrecho con la fé puesta en dios y creyendo en mi todo saldra bien</h1>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    + Nuevo Producto
  </button>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Producto</h1>
        </div>
        <div class="modal-body">
            {{-- da incio lo interno al modal --}}
          <div class="card">
            <div class="card-body">
                <form class="row g-3">
                    <div class="col-md-6">
                      <label for="inputEmail4" class="form-label">Producto:</label>
                      <input type="text" class="form-control" id="inputEmail4">
                    </div>
                    <div class="col-md-6">
                      <label for="inputPassword4" class="form-label">Password</label>
                      <input type="text" class="form-control" id="inputPassword4">
                    </div>
                    <div class="col-12">
                      <label for="inputAddress" class="form-label">Address</label>
                      <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                    </div>
                    <div class="col-12">
                      <label for="inputAddress2" class="form-label">Address 2</label>
                      <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
                    </div>
                    <div class="col-md-6">
                      <label for="inputCity" class="form-label">City</label>
                      <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="col-md-4">
                      <label for="inputState" class="form-label">State</label>
                      <select id="inputState" class="form-select">
                        <option selected>Choose...</option>
                        <option>...</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label for="inputZip" class="form-label">Zip</label>
                      <input type="text" class="form-control" id="inputZip">
                    </div>
                    <div class="container mt-5">
                        <div class="p-4 border border-dashed rounded-3 text-center" style="background-color: rgb(232, 237, 246)">
                          <label for="file-upload" class="d-block">
                            <i class="bi bi-cloud-upload fs-1 text-secondary"></i>
                            <div class="mt-2 text-secondary">
                              <strong>Upload a File</strong><br>
                              Drag and drop files here
                            </div>
                          </label>
                          <input id="file-upload" type="file" class="form-control d-none" />
                        </div>
                      </div>
                      <div id="preview-container" class="mt-4 text-center d-none">
                        <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="max-width: 20%; height: auto;" />
                        <p class="mt-2 text-secondary">Visualización de la imagen</p>
                      </div>
                  </form>
            </div>
          </div>
          {{-- da inicio lo de aqui para arriba el modal --}}
        </div>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary text-gray">Guardar</button>
        </div>
      </div>
    </div>
  </div>



@endsection
