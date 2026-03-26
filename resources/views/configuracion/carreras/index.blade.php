@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4 border-start border-5 border-success">
        <div>
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-mortarboard-fill text-success me-2"></i> Gestión de Carreras</h2>
            <p class="text-muted mb-0 small text-uppercase fw-semibold">Programas Académicos por Núcleo</p>
        </div>
        <button class="btn btn-success shadow-sm px-4 fw-bold rounded-pill" onclick="openModal('create')">
            <i class="bi bi-plus-circle-fill me-2"></i> Nueva Carrera
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-muted">ID</th>
                            <th>Carrera</th>
                            <th>Sede / Núcleo</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($carreras as $carrera)
                        <tr id="row-{{ $carrera->id }}" class="align-middle">
                            <td class="ps-4 text-muted small">#{{ $carrera->id }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-5">{{ $carrera->nombre }}</div>
                                <div class="text-muted small">Estatus: Activo</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $carrera->sede->nombre ?? 'Sin Sede' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-success btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="openModal('edit', {{ $carrera->id }}, '{{ $carrera->nombre }}', {{ $carrera->sede_id }})"
                                            title="Editar Carrera">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="deleteCarrera({{ $carrera->id }})"
                                            title="Eliminar Carrera">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted fw-bold">No hay carreras registradas.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="carreraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-success text-white py-3">
                <h5 class="modal-title fw-bold" id="modalTitle">Nueva Carrera</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="carreraForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="carrera_id">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Nombre de la Carrera</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-success"><i class="bi bi-book"></i></span>
                            <input type="text" id="nombre" class="form-control ps-2" placeholder="Ej: Ingeniería de Sistemas" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Asignar a Sede</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-success"><i class="bi bi-building"></i></span>
                            <select id="sede_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione un núcleo...</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success px-4 shadow-sm fw-bold rounded-pill" id="btnSave">Guardar Carrera</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .action-btn { width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; }
    .action-btn:hover { transform: scale(1.1); }
    .table-hover tbody tr:hover { background-color: #f6fff8; }
    .fade-out { opacity: 0; transform: translateX(20px); transition: all 0.4s ease; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const apiBase = '/api/v1/carreras';
    let myModal = new bootstrap.Modal(document.getElementById('carreraModal'));

    function openModal(mode, id = null, nombre = '', sede_id = '') {
        document.getElementById('carreraForm').reset();
        document.getElementById('carrera_id').value = id;
        document.getElementById('nombre').value = nombre;
        document.getElementById('sede_id').value = sede_id;
        
        const modalTitle = document.getElementById('modalTitle');
        const btnSave = document.getElementById('btnSave');

        if(mode === 'edit') {
            modalTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i>Editar Carrera';
            btnSave.classList.replace('btn-success', 'btn-warning');
            btnSave.innerText = 'Actualizar Carrera';
        } else {
            modalTitle.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Nueva Carrera';
            btnSave.classList.replace('btn-warning', 'btn-success');
            btnSave.innerText = 'Guardar Carrera';
        }
        myModal.show();
    }

    document.getElementById('carreraForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('carrera_id').value;
        const data = {
            nombre: document.getElementById('nombre').value,
            sede_id: document.getElementById('sede_id').value
        };
        
        const request = id ? axios.put(`${apiBase}/${id}`, data) : axios.post(apiBase, data);

        request.then(() => {
            myModal.hide();
            location.reload();
        }).catch(err => {
            alert('Error: ' + (err.response.data.message || 'Datos inválidos'));
        });
    });

    function deleteCarrera(id) {
        if(confirm('¿Eliminar esta carrera? Se perderán las tesis asociadas.')) {
            axios.delete(`${apiBase}/${id}`).then(() => {
                document.getElementById(`row-${id}`).classList.add('fade-out');
                setTimeout(() => location.reload(), 400);
            });
        }
    }
</script>
@endsection