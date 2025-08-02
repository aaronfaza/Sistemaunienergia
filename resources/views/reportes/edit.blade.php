<div class="modal fade" id="editarModal{{ $reporte->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $reporte->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('reportes.update', $reporte->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editarModalLabel{{ $reporte->id }}">Editar Reporte</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <!-- Campos editables -->
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $reporte->nombre }}">
          </div>
          <div class="mb-3">
            <label>Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" class="form-control" value="{{ $reporte->fecha_inicio }}">
          </div>
          <div class="mb-3">
            <label>Fecha de Fin</label>
            <input type="date" name="fecha_fin" class="form-control" value="{{ $reporte->fecha_fin }}">
          </div>
          <div class="mb-3">
            <label>Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" value="{{ $reporte->ubicacion }}">
          </div>
          <div class="mb-3">
            <label>Actividad</label>
            <textarea name="descripcion_actividad" rows="3" class="form-control">{{ $reporte->descripcion_actividad }}</textarea>
          </div>
          <!-- Aquí puedes agregar campos de materiales y herramientas -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
