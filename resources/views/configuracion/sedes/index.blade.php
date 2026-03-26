@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4 border-start border-5 border-primary">
        <div>
            <h2 class="fw-bold mb-0 text-dark"><i class="bi bi-building-fill text-primary me-2"></i> Gestión de Sedes</h2>
            <p class="text-muted mb-0 small text-uppercase fw-semibold">Administración de Núcleos y Extensiones</p>
        </div>
        <button class="btn btn-primary shadow-sm px-4 fw-bold rounded-pill" onclick="openModal('create')">
            <i class="bi bi-plus-circle-fill me-2"></i> Nueva Sede
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-muted">ID</th>
                            <th>Nombre del Núcleo</th>
                            <th class="text-center">Carreras</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sedes as $sede)
                        <tr id="row-{{ $sede->id }}" class="align-middle">
                            <td class="ps-4 text-muted small">#{{ $sede->id }}</td>
                            <td>
                                <div class="fw-bold text-dark fs-5">{{ $sede->nombre }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar3 me-1"></i> Registrado: {{ $sede->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-soft-info text-primary px-3 py-2 border border-primary border-opacity-10">
                                    <i class="bi bi-mortarboard-fill me-1"></i> {{ $sede->carreras->count() }} Programas
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-primary btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="openModal('edit', {{ $sede->id }}, '{{ $sede->nombre }}')"
                                            title="Editar Sede">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm rounded-circle shadow-sm action-btn" 
                                            onclick="deleteSede({{ $sede->id }})"
                                            title="Eliminar Sede">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="bi bi-clipboard-x display-1 text-muted opacity-25"></i>
                                <p class="mt-3 text-muted fw-bold">No hay sedes registradas actualmente.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sedeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="modalTitle">
                    <i class="bi bi-plus-circle me-2"></i>Nueva Sede
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="sedeForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="sede_id">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Nombre de la Sede</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0 text-primary">
                                <i class="bi bi-building"></i>
                            </span>
                            <input type="text" id="nombre" class="form-control border-start-0 ps-0 fs-6" 
                                   placeholder="Ej: Núcleo Caracas - Chuao" required>
                        </div>
                        <div class="form-text text-muted">Asegúrate de que el nombre sea el oficial del núcleo.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold rounded-pill" id="btnSave">
                        <i class="bi bi-check-circle-fill me-2"></i> Guardar Sede
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilos personalizados para mejorar la UI */
    .bg-soft-info { background-color: #e0f2fe; }
    
    .action-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    .table-hover tbody tr:hover {
        background-color: #fbfcfe;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: var(--bs-primary);
    }

    .fade-out {
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.4s ease;
    }
</style>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const apiBase = '/api/v1/sedes';
    let myModal = new bootstrap.Modal(document.getElementById('sedeModal'));

    // Función para abrir el modal en modo CREAR o EDITAR
    function openModal(mode, id = null, nombre = '') {
        document.getElementById('sedeForm').reset();
        document.getElementById('sede_id').value = id;
        document.getElementById('nombre').value = nombre;
        
        const modalTitle = document.getElementById('modalTitle');
        const btnSave = document.getElementById('btnSave');

        if(mode === 'edit') {
            modalTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i>Editar Sede';
            btnSave.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i>Actualizar Sede';
            btnSave.classList.replace('btn-primary', 'btn-warning');
        } else {
            modalTitle.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Nueva Sede';
            btnSave.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>Guardar Sede';
            btnSave.classList.replace('btn-warning', 'btn-primary');
        }
        myModal.show();
    }

    // Enviar datos a la API
    document.getElementById('sedeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('sede_id').value;
        const nombre = document.getElementById('nombre').value;
        
        // Si hay ID, usamos PUT (Editar), si no, POST (Crear)
        const request = id 
            ? axios.put(`${apiBase}/${id}`, { nombre }) 
            : axios.post(apiBase, { nombre });

        request.then(res => {
            myModal.hide();
            // Recargamos para ver los cambios reflejados
            location.reload(); 
        }).catch(err => {
            const msg = err.response.data.message || 'Error al procesar la solicitud';
            alert('⚠️ Error: ' + msg);
        });
    });

    // Eliminar Sede
    function deleteSede(id) {
        if(confirm('¿Estás totalmente seguro? Esta acción eliminará permanentemente la sede y todas sus carreras asociadas.')) {
            axios.delete(`${apiBase}/${id}`)
                .then(() => {
                    const row = document.getElementById(`row-${id}`);
                    row.classList.add('fade-out');
                    setTimeout(() => location.reload(), 400);
                })
                .catch(err => alert('No se pudo eliminar la sede.'));
        }
    }
</script>
@endsection