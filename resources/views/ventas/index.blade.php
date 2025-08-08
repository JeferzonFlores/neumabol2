@extends('adminlte::page')
@section('title', 'Ver Salidas de Artículos') {{-- Título actualizado --}}
@section('content_header')
    <h1>Salidas de Artículos</h1> {{-- Título actualizado --}}
    <p>Administración de salidas de artículos</p> {{-- Descripción actualizada --}}
    @if (session('error'))
        <div class="alert {{ session('tipo') }} alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong> {{ session('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif @stop

    @section('content')

        <div class="card">
            <div class="card-body">
                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Cliente/Destinatario</td> {{-- Etiqueta actualizada --}}
                            <td>Documento</td>
                            <td>Cantidad Total Artículos</td> {{-- Columna actualizada --}}
                            <td>Medio de registro</td> {{-- Etiqueta actualizada --}}
                            <td>Fecha</td>
                            <td>Usuario</td>
                            <td>Ver</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $v)
                            <tr>
                                <td>{{ $v->id }}</td>
                                <td>{{ $v->Cliente->nombre }} ({{ $v->Cliente->rut }})</td>
                                <td>{{ $v->TipoDocumento->tipo_documento }}: {{ $v->documento }}</td>
                                <td>{{ number_format($v->unidades, 0, '', '.') }}</td> {{-- Muestra el campo 'unidades' --}}
                                <td>{{ $v->MedioDePago->medio_de_pago }}</td>
                                <td>{{ date('d-m-Y H:s', strtotime($v->created_at)) }}</td>
                                <td>{{ $v->user->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-success"
                                            href="{{ route('ventas.show', $v->id) }}">Ver</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
                <div class="btn-group">
                    <a type="button" class="btn btn-success" href="{{ route('ventas.create') }}">Registrar nueva salida</a> {{-- Botón actualizado --}}
                </div>
            </div>
        </div>

    @stop

    @section('js')
        <script>
            $(document).ready(function() {
                $("#example").DataTable({
                    order: [
                        [0, "desc"]
                    ],

                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                    },
                });
            });
        </script>
    @stop
