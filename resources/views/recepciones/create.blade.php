@extends('adminlte::page')

@section('title', 'Agregar recepcion')

@section('content_header')
    @if (session('error'))
        <div class="alert {{ session('tipo') }} alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong> {{ session('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Agregar recepcion</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form role="form" action="{{ route('recepciones.addarticulo') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12 form-group">
                                <label>Articulo</label>
                                <select id="articulo" autofocus name="articulo" required class="form-control select2">
                                    <option value="">Buscar articulo</option>
                                    <?php
                                    foreach ($articulos as $t) {
                                        echo '<option value="' .
                                            $t['id'] .
                                            '">' .
                                            $t['cod_barras'] .
                                            ' - ' .
                                            $t['cod_interno'] .
                                            ' - ' .
                                            $t['descripcion'] .
                                            '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        {{-- Campos eliminados: Neto unitario, I.V.A., Total unitario --}}
                        {{-- <div class="row">
                            <div class="form-group col-6">
                                <label>Neto unitario</label>
                                <input name="costo_neto" id="costo_neto" min="1" class="form-control" required
                                    type="number" oninput="ActualizaValorCostoTotal()">
                            </div>
                            <div class="form-group col-6">
                                <label>I.V.A.</label>
                                <input name="costo_imp" id="costo_imp" readonly required type="number"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="form-goup row">
                            <div class="form-group col-6">
                                <label>Total unitario</label>
                                <input name="costo_total" id="costo_total" min="1" required type="number"
                                    oninput="ActualizaValorCostoNeto()" class="form-control">
                            </div> --}}
                            <div class="col-6">
                                <label>Unidades</label>
                                <input name="unidades" required min="1" type="number" class="form-control">
                            </div>
                        {{-- </div> --}} {{-- Cierre de div.row para los campos eliminados --}}
                        <br>
                        <button type="submit" class="btn btn-primary pull-left">Agregar articulo</button>
                        <div class="btn-group">
                    </form>

                    <a type="button" class="btn btn-success" href="{{ route('articulos.create') }}">Crear
                        articulo</a>
                </div>
                @if (session('recepcion'))
                    @php
                        $total_unidades = 0;
                        $total_costo_neto_sesion = 0; // Renombrado para claridad
                        $total_costo_imp_sesion = 0; // Renombrado para claridad
                        $total_costo_total_sesion = 0; // Renombrado para claridad
                        
                        foreach (session('recepcion') as $r) {
                            $total_unidades += $r->cantidad;
                            // Ahora, si necesitas los costos, debes obtenerlos del Articulo asociado
                            $articulo_asociado = App\Models\Articulo::find($r->articulo_id);
                            $costo_neto_articulo = $articulo_asociado->costo_neto ?? 0;
                            $costo_imp_articulo = $articulo_asociado->costo_imp ?? 0;

                            $total_costo_neto_sesion += $costo_neto_articulo * $r->cantidad;
                            $total_costo_imp_sesion += $costo_imp_articulo * $r->cantidad;
                            $total_costo_total_sesion += ($costo_neto_articulo + $costo_imp_articulo) * $r->cantidad;
                        }
                    @endphp
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-warning pull-right" data-toggle="modal"
                            data-target="#modal-default">
                            Finalizar recepcion
                        </button>
                    </div>
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Finalizar recepcion</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="{{ route('recepciones.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Tipo documento</label>
                                            <select id="tipo_documento" name="tipo_documento" class="form-control select2">
                                                @foreach ($tipo_documento as $t)
                                                    <option value="{{ $t->id }}">{{ $t->tipo_documento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Numero documento</label>
                                            <input id="numero_documento" name="numero_documento" required type="number"
                                                class="form-control input-sm">
                                        </div>

                                        <div class="form-group">
                                            <label>Proveedor</label>
                                            <select id="proveedor" name="proveedor" required class="form-control select2">
                                                <option value="">Seleccionar</option>
                                                @foreach ($proveedores as $p)
                                                    <option value="{{ $p->id }}">{{ $p->razon_social }}
                                                        ({{ $p->rut }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                                        
                        <div class="form-group">
                            <label>Región</label>
                            <select id="region_id" name="region_id" class="form-control select2" required>
                                <option value="">Seleccione una Región</option>
                                @foreach ($regiones as $region)
                                    <option value="{{ $region->id }}">{{ $region->region }}</option>
                                @endforeach
                            </select>
                            @error('region_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
               
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <input id="observaciones" required name="observaciones" type="text"
                                                class="form-control input-sm" value="">
                                        </div>
                                        {{-- Campos de Monto total, monto_neto, monto_imp eliminados de la tabla 'recepciones' --}}
                                        {{-- Ahora solo mostraremos el total de las unidades --}}
                                        {{-- Si quieres calcular el monto total de la recepción, deberías hacerlo en el controlador
                                            sumando los costos de los artículos de cada detalle. --}}
                                        <div class="form-group">
                                            <label>Total articulos</label>
                                            <input id="total_articulos" name="total_articulos" readonly type="text"
                                                class="form-control input-sm"
                                                value="{{ number_format($total_unidades, 0, ',', '.') }}">
                                            {{-- Estos inputs ya no se corresponden con campos de la base de datos
                                                <input id="monto_neto" name="monto_neto" type="hidden" class="form-control input-sm" value="{{ $total_costo_neto_sesion }}">
                                                <input id="monto_imp" name="monto_imp" type="hidden" class="form-control input-sm" value=" {{ $total_costo_imp_sesion }}">
                                                Si necesitas enviar estos valores al controlador, puedes hacerlo,
                                                pero ten en cuenta que no se guardarán en la tabla de recepciones.
                                            --}}
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Agregar recepcion</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
            @if (session('recepcion'))
                <div class="col-md-6">

                    <ol>
                        <li><Strong>Total unidades: </Strong>{{ number_format($total_unidades, 0, ',', '.') }}</li>

                        </li>
                    </ol>

                    <br>

                </div>
            @endif
        </div>
    </div>

    <br>

    <div class="card-footer">
        Crear articulo
    </div>
    </div>
    @if (session('recepcion'))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Detalle recepcion </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body">

                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td>Codigo</td>
                            <td>Descripcion</td>
                            <td>Unidades</td>
                            {{-- <td>Unitario</td> --}}
                            {{-- <td>I.V.A.</td> --}}
                            {{-- <td>Total</td> --}}
                            {{-- Ahora mostramos los costos del artículo, no del detalle de recepción --}}
                          {{-- <td>Costo Articulo (Neto)</td> --}}
                          {{--  <td>Costo Articulo (IVA)</td> --}}
                            {{-- <td>Subtotal (Neto * Unidades)</td> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (session('recepcion') as $r)
                            @php
                                $articulo_asociado = App\Models\Articulo::find($r->articulo_id);
                                $costo_neto_articulo = $articulo_asociado->costo_neto ?? 0;
                                $costo_imp_articulo = $articulo_asociado->costo_imp ?? 0;
                            @endphp
                            <tr>
                                <th>{{ $r->articulo->id }}</th>
                                <td>{{ $r->articulo->descripcion }}</td>
                             {{--   <td>{{ number_format($r->cantidad, 0, ',', '.') }}</td> --}}
                             {{--   <td>${{ number_format($costo_neto_articulo, 0, ',', '.') }}</td> --}}
                             {{--   <td>${{ number_format($costo_imp_articulo, 0, ',', '.') }}</td> --}}
                           <td>{{ number_format( $r->cantidad, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br />
            </div>
    @endif
@stop

@section('js')

    <script>
        // Funciones de cálculo unitario eliminadas, ya que los campos de entrada asociados fueron removidos.
        // function ActualizaValorCostoTotal() {
        //     let valor = document.getElementById("costo_neto").value;
        //     document.getElementById("costo_total").value = Math.round(valor * 1.19);
        //     document.getElementById("costo_imp").value = Math.round((valor * 1.19) - valor);
        // }

        // function ActualizaValorCostoNeto() {
        //     let valor = document.getElementById("costo_total").value;
        //     document.getElementById("costo_neto").value = Math.round(valor / 1.19);
        //     document.getElementById("costo_imp").value = Math.round(valor - (valor / 1.19));
        // }
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