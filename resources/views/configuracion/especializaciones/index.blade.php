@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4 border-start border-5 border-info">
        <div>
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-bookmark-star-fill text-info me-2"></i> Programas de Posgrado</h2>
            <p class="text-muted mb-0 small text-uppercase fw-semibold">Gestión de Especializaciones, Maestrías y Doctorados</p>
        </div>
        <button class="btn btn-info text-white shadow-sm px-4 fw-bold rounded-pill" onclick="openModal('create')">
            <i class="bi bi-plus-circle-fill me-2"></i> Nuevo Programa
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-muted">ID</th>
                            <th>Nombre del Programa</th>
                            <th>Nivel Académico</th>
                            <th>Carrera Perteneciente</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($especializaciones as $esp)
                        <tr id="row-{{ $esp->id }}" class="align-middle">
                            <td class="ps-4 text-muted small">#{{ $esp->id }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-6">{{ $esp->nombre }}</div>
                            </td>
                            <td>
                                {{-- Badge dinámico según el tipo --}}
                                @php
                                    $badgeColor = [
                                        'especializacion' => 'bg-info',
                                        'maestria' => 'bg-primary',
                                        'doctorado' => 'bg-dark',
                                        'postdoctorado' => 'bg-warning text-dark'
                                    ][$esp->tipo] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeColor }} px-3 py-2 rounded-pill text-uppercase" style="font-size: 0.7rem;">
                                    {{ $esp->tipo }}
                                </span>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $esp->carrera->nombre ?? 'Sin Carrera' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-info btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="openModal('edit', {{ $esp->id }}, '{{ $esp->nombre }}', '{{ $esp->tipo }}', {{ $esp->carrera_id }})"
                                            title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="deleteEspecializacion({{ $esp->id }})"
                                            title="Eliminar">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-tags display-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted fw-bold">No hay programas registrados.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ACTUALIZADO --}}
<div class="modal fade" id="espModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-info text-white py-3">
                <h5 class="modal-title fw-bold" id="modalTitle">Nuevo Programa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="espForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="esp_id">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Nombre del Programa</label>
                        <input type="text" id="nombre" class="form-control" placeholder="Ej: Gerencia Logística" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Nivel Académico</label>
                        <select id="tipo" class="form-select" required>
                            <option value="especializacion">Especialización</option>
                            <option value="maestria">Maestría</option>
                            <option value="doctorado">Doctorado</option>
                            <option value="postdoctorado">Postdoctorado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Carrera Base (UNEFA)</label>
                        <select id="carrera_id" class="form-select" required>
                            <option value="" disabled selected>Seleccione carrera...</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white px-4 fw-bold rounded-pill" id="btnSave">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const apiBase = '/api/v1/especializaciones';
    let myModal = new bootstrap.Modal(document.getElementById('espModal'));

    function openModal(mode, id = null, nombre = '', tipo = 'especializacion', carrera_id = '') {
        document.getElementById('espForm').reset();
        document.getElementById('esp_id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('tipo').value = tipo; // Nuevo campo
        document.getElementById('carrera_id').value = carrera_id;
        
        document.getElementById('modalTitle').innerText = mode === 'edit' ? 'Editar Programa' : 'Nuevo Programa';
        myModal.show();
    }

    document.getElementById('espForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('esp_id').value;
        const data = {
            nombre: document.getElementById('nombre').value,
            tipo: document.getElementById('tipo').value, // Enviamos el tipo a la API
            carrera_id: document.getElementById('carrera_id').value
        };
        
        const request = id ? axios.put(`${apiBase}/${id}`, data) : axios.post(apiBase, data);

        request.then(() => location.reload())
               .catch(err => alert('Error en la validación: ' + JSON.stringify(err.response.data.errors)));
    });

    function deleteEspecializacion(id) {
        if(confirm('¿Seguro que desea eliminar este programa?')) {
            axios.delete(`${apiBase}/${id}`).then(() => location.reload());
        }
    }
</script>
@endsection