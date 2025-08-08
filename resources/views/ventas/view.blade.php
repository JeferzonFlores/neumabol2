@extends('adminlte::page')

@section('title', 'Ver salida de artículos') {{-- Título actualizado --}}

@section('content_header')
    <h2>Detalle de salida </h2> {{-- Título actualizado --}}
@stop


@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Salida #{{ $venta->id }}</h3> {{-- Título actualizado --}}
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <ul>
                    <li><strong>Cliente/Destinatario: </strong>{{ $venta->Cliente->nombre }}
                        ({{ $venta->Cliente->rut }})</li>
                    <li><strong>Fecha de salida:</strong> {{ date('d-m-Y H:s', strtotime($venta->created_at)) }}</li> {{-- Etiqueta actualizada --}}
                    <li><strong> {{ $venta->TipoDocumento->tipo_documento }}:</strong> {{ $venta->documento }}</li>
                    <li><strong>Cantidad total de artículos:</strong> {{ number_format($venta->unidades, 0, ',', '.') }}</li> {{-- Muestra el campo 'unidades' --}}
                    <li><strong>Medio de registro: </strong> {{ $venta->MedioDePago->medio_de_pago }}</li> {{-- Etiqueta actualizada --}}
                    <li><strong>Usuario que registró: </strong> {{ $venta->user->name }}</li> {{-- Etiqueta actualizada --}}
                </ul>
            </div>

            <!-- Fin contenido -->
        </div>

        <!-- /.card-body -->
        <div class="card-footer">
            Detalle de salida
        </div>
        <!-- /.card-footer-->
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Artículos retirados #{{ $venta->id }}</h3> {{-- Título actualizado --}}
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>Código</td>
                        <td>Descripción</td>
                        <td>Cantidad</td>
                        {{-- Columnas de precio, IVA, total eliminadas --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleVentas as $d)
                        <tr>
                            <th>{{ $d->Producto->cod_interno }}</th> {{-- Usar cod_interno en lugar de id --}}
                            <td>{{ $d->Producto->descripcion }}</td>
                            <td>{{ number_format($d->cantidad, 0, ',', '.') }}</td>
                            {{-- Celdas de precio, IVA, total eliminadas --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br />
        </div>
    @stop

    @section('js')
        <script>
            $(document).ready(function() {
                $("#example").DataTable({
                    order: [
                        [0, "desc"]
                    ],
                    columnDefs: [{
                        targets: [2],
                        visible: true,
                        searchable: true,
                    }, ],
                    dom: 'Bfrtip',
                    buttons: [
                        'excelHtml5',
                        'csvHtml5',
                        {
                            extend: 'print',
                            text: 'Imprimir',
                            autoPrint: true,
                            customize: function(win) {
                                $(win.document.body).css('font-size', '16pt');
                                $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'PDF',
                            filename: 'Salida.pdf', // Nombre de archivo actualizado
                            title: 'Salida de Artículos {{ $venta->id }}', // Título actualizado
                            pageSize: 'LETTER',
                        }
                    ],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json",
                    },
                });
            });
        </script>
    @stop
