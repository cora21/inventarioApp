
@extends('layouts.app')

@section('title', 'Registro de Almacen')

@section('contenido')


<h2 class="title-1 m-b-25">Lista de los Almacenes</h2>
    {{-- boton del nuevo almacen --}}
    <div class="d-flex justify-content-between align-items-center">
        <!-- Select alineado a la izquierda -->
        <select class="form-select form-select-lg me-2" aria-label="Large select example" style="max-width: 300px; height: auto;">
            <option selected>- Seleccione -</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
        <!-- Botón alineado a la derecha -->
        <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalRegistroAlmacen">
            Registra nuevo almacén
        </button>
    </div>
<br><br>
<div class="container center">



<div class="card shadow-lg"  style="width: 56rem;">
  <div class="card-body">
    {{-- la carta que sostiene la tabla --}}
<div class="card shadow-lg" style="width: 54rem;">
    <div class="card-body">
        <table class="table table-hover">
            <thead >
                {{-- si funciona --}}
                <tr style="background-color: rgb(245, 245, 245); ">
                    <th scope="col" style="border-radius: 15px 0px 0px 0px;">Primero</th>
                    <th scope="col">First</th>
                    <th scope="col" style="border solid; red;">Last</th>
                    <th scope="col" style="border-radius: 0px 15px 0px 0px;" >Handle</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry</td>
                    <td>the Bird</td>
                    <td>@twitter</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
  </div>
</div>

  <!-- Modal para registrar el almacen -->
  <div class="modal fade" id="modalRegistroAlmacen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header no-border">
          <h1 class="modal-title fs-1 text-blue-200" id="exampleModalLabel">Nuevo Almacén</h1>
        </div>

        <div class="modal-body">
            <p class="card-text fs-4 text-dark">Aqui puedes registras los diferentes almacenes de tu empresa</p>
            <div class="mx-auto" style="width: 70%;">
                <div class="card">
                    <div class="card-body rounded shadow-lg">

                        <div class="container">
                            <div class="row">
                              <!-- Columna para los inputs -->
                              <div class="col-md-6">
                                <label for="basic-url" class="form-label text-dark"><strong>Nombre: </strong><span class="text-danger">*</span></label>
                                <div class="input-group mb-4">
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                    </div>
                                </div>

                                <div class="input-group mb-4">
                                    <label for="basic-url" class="form-label"><strong>Dirección:</strong></label>
                                    <div class="input-group input-group-lg">
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                                    </div>
                                </div>
                              </div>

                              <!-- Columna para el textarea -->
                              <div class="col-md-6">
                                <label for="basic-url" class="form-label rounded"><strong>Observaciones:</strong></label>
                                <div class="input-group h-100">
                                    <textarea class="form-control" aria-label="With textarea" style="height: 90%; resize: none;"></textarea>
                                </div>
                              </div>
                            </div>
                          </div>


                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer">
        <p class="card-text fs-4"> <strong>Los campos con </strong><span class="text-danger">*</span> <strong> son obligatorios</strong></p>
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary text-gray">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>







@endsection

