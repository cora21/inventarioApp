@extends('layouts.app')


@section('title', 'Ventas')

@section('contenido')
<h1>comienza el camino de las ventas</h1>
<div class="container mt-5">
    <div class="row">
        <!-- Cuadro 1 (3 partes) -->
        <div class="col-12 col-md-7 border" style="height: 300px; background-color: lightblue;">
            <div class="py-5">
                <input type="search" name="" class="form-control" id="">
                <br>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
        </div>
        <!-- Cuadro 2 (2 partes) -->
        <div class="col-12 col-md-5 border" style="height: 300px; background-color: lightgreen;">
            <nav >
                Facturas
                <hr>
            </nav>
        </div>
    </div>
</div>
@endsection
