@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4 border-start border-5 border-info">
        <div>
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-bookmark-star-fill text-info me-2"></i> Especializaciones</h2>
            <p class="text-muted mb-0 small text-uppercase fw-semibold">Áreas específicas por Carrera</p>
        </div>
        <button class="btn btn-info text-white shadow-sm px-4 fw-bold rounded-pill" onclick="openModal('create')">
            <i class="bi bi-plus-circle-fill me-2"></i> Nueva Especialización
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-muted">ID</th>
                            <th>Especialización</th>
                            <th>Carrera Perteneciente</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($especializaciones as $esp)
                        <tr id="row-{{ $esp->id }}" class="align-middle">
                            <td class="ps-4 text-muted small">#{{ $esp->id }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-5">{{ $esp->nombre }}</div>
                                <div class="text-muted small">Módulo de Configuración</div>
                            </td>
                            <td>
                                <span class="badge bg-soft-success text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                    <i class="bi bi-mortarboard me-1"></i>
                                    {{ $esp->carrera->nombre ?? 'Sin Carrera' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-info btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="openModal('edit', {{ $esp->id }}, '{{ $esp->nombre }}', {{ $esp->carrera_id }})"
                                            title="Editar Especialización">
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
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-tags display-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted fw-bold">No hay especializaciones registradas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="espModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-info text-white py-3">
                <h5 class="modal-title fw-bold" id="modalTitle">Nueva Especialización</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="espForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="esp_id">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Nombre de la Especialización</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-info"><i class="bi bi-tag-fill"></i></span>
                            <input type="text" id="nombre" class="form-control ps-2" placeholder="Ej: Redes o Programación" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Asignar a Carrera</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-info"><i class="bi bi-mortarboard"></i></span>
                            <select id="carrera_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione una carrera...</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }} ({{ $carrera->sede->nombre ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white px-4 shadow-sm fw-bold rounded-pill" id="btnSave">Guardar Especialización</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-soft-success { background-color: #e8f5e9; }
    .action-btn { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
    .action-btn:hover { transform: scale(1.1); }
    .table-hover tbody tr:hover { background-color: #f0faff; }
    .fade-out { opacity: 0; transform: translateX(20px); transition: all 0.4s ease; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const apiBase = '/api/v1/especializaciones';
    let myModal = new bootstrap.Modal(document.getElementById('espModal'));

    function openModal(mode, id = null, nombre = '', carrera_id = '') {
        document.getElementById('espForm').reset();
        document.getElementById('esp_id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('carrera_id').value = carrera_id;
        
        const modalTitle = document.getElementById('modalTitle');
        const btnSave = document.getElementById('btnSave');

        if(mode === 'edit') {
            modalTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i>Editar Especialización';
            btnSave.innerText = 'Actualizar Especialización';
        } else {
            modalTitle.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Nueva Especialización';
            btnSave.innerText = 'Guardar Especialización';
        }
        myModal.show();
    }

    document.getElementById('espForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('esp_id').value;
        const data = {
            nombre: document.getElementById('nombre').value,
            carrera_id: document.getElementById('carrera_id').value
        };
        
        const request = id ? axios.put(`${apiBase}/${id}`, data) : axios.post(apiBase, data);

        request.then(() => {
            myModal.hide();
            location.reload();
        }).catch(err => {
            alert('Error: ' + (err.response.data.message || 'Datos inválidos'));
        });
    });

    function deleteEspecializacion(id) {
        if(confirm('¿Eliminar esta especialización?')) {
            axios.delete(`${apiBase}/${id}`).then(() => {
                document.getElementById(`row-${id}`).classList.add('fade-out');
                setTimeout(() => location.reload(), 400);
            });
        }
    }
</script>
@endsection