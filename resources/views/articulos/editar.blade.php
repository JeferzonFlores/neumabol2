@extends('adminlte::page')

@section('title', 'Editar articulo')

@section('content_header')

@stop

@section('content')

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Editar articulo</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fas fa-minus"></i></button>
      <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fas fa-times"></i></button>
    </div>
  </div>
  <div class="card-body">
    <div class="col-md-6">
      <form role="form" action="{{route('articulos.update', $articulo)}}" method="POST">
        @csrf
        @method('put')
        <div class="form-group row">
          <div class="col-6">
            <label>Codigo interno</label>
            <input name="cod_interno" required type="text" class="form-control" value="{{$articulo->cod_interno}}">
          </div>
          <div class="col-6">
            <label>Codigo de barras</label>
            <input name="cod_barras" required type="text" class="form-control" value="{{$articulo->cod_barras}}">
          </div>
        </div>
        <div class="form-group">
          <label>Descripcion</label>
          <input name="descripcion" required type="text" class="form-control" value="{{$articulo->descripcion}}">
        </div>
        {{-- Campos de Costo, Venta, Ganancia y Stock Crítico eliminados --}}
        {{--
        <div class="form-group row">
          <div class="col-4">
            <label>Costo neto</label>
            <input name="costo_neto" readonly id="costo_neto" oninput="ActualizaValorCostoTotal()" required type="number" class="form-control"
              value="{{$articulo->costo_neto}}">
          </div>
          <div class="col-4">
            <label>I.V.A.</label>
            <input name="costo_imp" readonly id="costo_imp" required type="number" class="form-control"
              value="{{$articulo->costo_imp}}">
          </div>
          <div class="col-4">
            <label>Total</label>
            <input name="costo_total" readonly id="costo_total" required type="number" oninput="ActualizaValorCostoNeto()" class="form-control"
              value="{{$articulo->costo_imp + $articulo->costo_neto}}">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-4">
            <label>Venta neto</label>
            <input name="venta_neto" id="venta_neto" required type="number" oninput="ActualizaValorVentaTotal()"
              class="form-control" value="{{$articulo->venta_neto}}">
          </div>
          <div class="col-4">
            <label>I.V.A.</label>
            <input name="venta_imp" id="venta_imp" required type="number" class="form-control"
              value="{{$articulo->venta_imp}}">
          </div>
          <div class="col-4">
            <label>Total</label>
            <input name="venta_total" id="venta_total" required type="number" oninput="ActualizaValorVentaNeto()"
              class="form-control" value="{{$articulo->venta_imp + $articulo->venta_neto}}">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <label>% de ganancia</label>
            <input name="por_ganancia" id="por_ganancia" disabled type="number" class="form-control"
              value="{{((($articulo->venta_imp + $articulo->venta_neto)-($articulo->costo_imp + $articulo->costo_neto))/($articulo->venta_imp + $articulo->venta_neto))*100}}">
          </div>
          <div class="col-6">
            <label>Ganancia</label>
            <input name="ganancia" id="ganancia" disabled type="number" class="form-control"
              value="{{number_format(($articulo->venta_imp + $articulo->venta_neto)-($articulo->costo_imp + $articulo->costo_neto), 0,'', '.')}}">
          </div>
        </div>
        --}}
        <div class="form-group row">
          <div class="col-6">
            <label>Marca</label>
            <input name="marca" type="text" class="form-control" value="{{$articulo->marca ?? ''}}">
          </div>
          <div class="col-6">
            <label>Modelo</label>
            <input name="modelo" type="text" class="form-control" value="{{$articulo->modelo ?? ''}}">
          </div>
        </div>

        <div class="form-group">
          <label>Activo</label>
          <select id="activo" name="activo" class="form-control">
            <option value="">Seleccione</option>
            @if ($articulo->activo == 1)
            <option selected="true" value="1">Activo</option>
            <option value="0">Inactivo</option> {{-- Cambiado de 2 a 0 para consistencia con boolean --}}
            @else
            <option value="1">Activo</option>
            <option selected="true" value="0">Inactivo</option> {{-- Cambiado de 2 a 0 --}}
            @endif
          </select>
        </div>
        {{-- Campo Stock Crítico eliminado --}}
        {{--
        <div class="form-goup row">
          <div class="col-6">
            <label>Stock critico</label>
            <input name="stock_critico" required type="number" class="form-control"
              value="{{$articulo->stock_critico}}">
          </div>
        </div>
        --}}

        <br>

        <button type="button" class="btn btn-primary pull-left" data-toggle="modal" data-target="#modal">Editar
          Articulo</button>
        <div class="modal fade" id="modal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Modificar articulo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <p>Seguro que quiere guardar los cambios?&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </form>
    </div>

    <br>
    <!-- Fin contenido -->
  </div>
</div>
<!-- /.card-body -->
<div class="card-footer">
  Editar articulo
</div>
<!-- /.card-footer-->
</div>

@stop

@section('js')
{{-- Las funciones JavaScript relacionadas con cálculos de precios han sido eliminadas --}}
<script>
  // No hay funciones JavaScript relacionadas con los campos eliminados
</script>
@stop

@section('footer')
   <div class="float-right d-none d-sm-block">
        <b>Version</b> @version('compact')       
    </div>
@stop
