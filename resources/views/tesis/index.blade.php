@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 p-4 bg-white shadow-sm rounded-4 border-start border-5 border-primary">
        <div>
            <h2 class="fw-bold mb-0 text-dark">
                <i class="bi bi-folder-fill text-warning me-2"></i> Repositorio de Tesis (Local)
            </h2>
            <p class="text-muted mb-0 small text-uppercase fw-semibold text-primary">Sistema de Gestión de Proyectos de Grado</p>
        </div>
        <button class="btn btn-primary shadow-sm px-4 fw-bold rounded-pill" onclick="openModal('create')">
            <i class="bi bi-plus-circle-fill me-2"></i> Registrar Nueva Tesis
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-5">
            <div class="input-group shadow-sm rounded-pill overflow-hidden border">
                <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="searchTerm" class="form-control border-0 py-2" placeholder="Buscar por título, autor o tutor..." onkeyup="filterTesis()">
            </div>
        </div>
    </div>

    <div class="row" id="tesis-container">
        @forelse($tesis as $t)
        <div class="col-md-6 mb-4 tesis-item" 
             data-title="{{ strtolower($t->titulo) }}" 
             data-author="{{ strtolower($t->autor->nombre ?? '') }}"
             data-tutor="{{ strtolower($t->tutor->nombre ?? '') }}">
            
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        @php
                            $badge = [
                                'recibida' => 'bg-secondary',
                                'en_revision' => 'bg-warning text-dark',
                                'aprobada' => 'bg-success',
                                'rechazada' => 'bg-danger'
                            ][$t->estado] ?? 'bg-info';
                        @endphp
                        <span class="badge {{ $badge }} text-uppercase px-3 py-2 rounded-pill shadow-sm small">
                            {{ str_replace('_', ' ', $t->estado) }}
                        </span>
                        <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $t->fecha_presentacion ?? 'Sin fecha' }}</small>
                    </div>

                    <h5 class="fw-bold text-dark mb-3 lh-sm text-truncate-3">{{ $t->titulo }}</h5>
                    
                    <div class="mb-4">
                        <div class="text-secondary small mb-1">
                            <i class="bi bi-mortarboard-fill text-primary me-2"></i> <strong>Autor:</strong> {{ $t->autor->nombre ?? 'N/A' }}
                        </div>
                        <div class="text-secondary small mb-1">
                            <i class="bi bi-person-badge-fill text-info me-2"></i> <strong>Tutor:</strong> {{ $t->tutor->nombre ?? 'N/A' }}
                        </div>
                        <div class="text-secondary small">
                            <i class="bi bi-diagram-3-fill text-success me-2"></i> <strong>Carrera:</strong> {{ $t->especializacion->carrera->nombre ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div class="btn-group shadow-sm rounded-3">
                            @if($t->ruta_pdf)
                                <a href="{{ asset('storage/' . $t->ruta_pdf) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-danger btn-sm px-3" 
                                   title="Abrir PDF en visor">
                                    <i class="bi bi-file-earmark-pdf-fill me-1"></i> Ver PDF
                                </a>
                            @endif
                            <button class="btn btn-outline-primary btn-sm px-3" 
                                onclick="openModal('edit', {{ $t->id }}, '{{ addslashes($t->titulo) }}', {{ $t->especializacion_id }}, {{ $t->autor_id }}, {{ $t->tutor_id }}, '{{ $t->estado }}', '{{ $t->fecha_presentacion }}')">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                        </div>
                        <button class="btn btn-link text-danger p-0 text-decoration-none small fw-bold" onclick="deleteTesis({{ $t->id }})">
                            <i class="bi bi-trash3"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="display-1 text-muted opacity-25"><i class="bi bi-cloud-slash"></i></div>
            <p class="text-muted mt-3 fw-bold italic">No hay registros para mostrar.</p>
        </div>
        @endforelse
    </div>
</div>

<div class="modal fade" id="tesisModal" tabindex="-1" aria-hidden="true border-0">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold" id="modalTitle">Registro de Tesis</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="tesisForm">
                <div class="modal-body p-4 bg-light">
                    <input type="hidden" id="tesis_id">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">TÍTULO DEL PROYECTO</label>
                            <textarea id="titulo" class="form-control border-0 shadow-sm" rows="3" required placeholder="Ej: Sistema de Gestión de Redes para la UNEFA..."></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-primary">ESPECIALIZACIÓN / CARRERA</label>
                            <select id="especializacion_id" class="form-select border-0 shadow-sm" required>
                                <option value="" disabled selected>Seleccione la especialidad...</option>
                                @foreach($especializaciones as $esp)
                                    <option value="{{ $esp->id }}">{{ $esp->nombre }} ({{ $esp->carrera->nombre }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ESTUDIANTE (AUTOR)</label>
                            <select id="autor_id" class="form-select border-0 shadow-sm" required>
                                <option value="" disabled selected>Seleccione estudiante...</option>
                                @foreach($personas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }} - {{ $p->cedula }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">TUTOR ACADÉMICO</label>
                            <select id="tutor_id" class="form-select border-0 shadow-sm" required>
                                <option value="" disabled selected>Seleccione profesor...</option>
                                @foreach($personas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">ESTADO ACTUAL</label>
                            <select id="estado" class="form-select border-0 shadow-sm">
                                <option value="recibida">Recibida</option>
                                <option value="en_revision">En Revisión</option>
                                <option value="aprobada">Aprobada</option>
                                <option value="rechazada">Rechazada</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">FECHA DE PRESENTACIÓN</label>
                            <input type="date" id="fecha_presentacion" class="form-control border-0 shadow-sm">
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top">
                            <label class="form-label fw-bold small text-danger"><i class="bi bi-filetype-pdf"></i> ARCHIVO PDF</label>
                            <input type="file" id="ruta_pdf_input" class="form-control border-0 shadow-sm" accept=".pdf">
                            <div id="fileHelp" class="form-text mt-2 text-muted"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white border-0 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold" id="btnSave">Guardar Registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-truncate-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; min-height: 3.6rem; }
    .hover-card { transition: all 0.3s ease; border: 1px solid rgba(0,0,0,.05)!important; }
    .hover-card:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.12)!important; }
    .bg-light { background-color: #f8f9fa!important; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const apiBase = '/api/v1/tesis';
    const myModal = new bootstrap.Modal(document.getElementById('tesisModal'));

    // Filtro instantáneo sin recargar página
    function filterTesis() {
        const term = document.getElementById('searchTerm').value.toLowerCase();
        document.querySelectorAll('.tesis-item').forEach(item => {
            const content = item.dataset.title + ' ' + item.dataset.author + ' ' + item.dataset.tutor;
            item.style.display = content.includes(term) ? 'block' : 'none';
        });
    }

    function openModal(mode, id = null, titulo = '', esp_id = '', autor_id = '', tutor_id = '', estado = 'recibida', fecha = '') {
        document.getElementById('tesisForm').reset();
        document.getElementById('tesis_id').value = id || '';
        document.getElementById('titulo').value = titulo;
        document.getElementById('especializacion_id').value = esp_id;
        document.getElementById('autor_id').value = autor_id;
        document.getElementById('tutor_id').value = tutor_id;
        document.getElementById('estado').value = estado;
        document.getElementById('fecha_presentacion').value = fecha;
        
        document.getElementById('modalTitle').innerText = id ? 'Editar Información de Tesis' : 'Registrar Nueva Tesis Académica';
        document.getElementById('fileHelp').innerText = id ? 'Solo suba un archivo nuevo si desea reemplazar el PDF actual.' : 'Cargue el documento final de la tesis en formato PDF.';
        
        myModal.show();
    }

    document.getElementById('tesisForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('tesis_id').value;
        const formData = new FormData();
        
        formData.append('titulo', document.getElementById('titulo').value);
        formData.append('especializacion_id', document.getElementById('especializacion_id').value);
        formData.append('autor_id', document.getElementById('autor_id').value);
        formData.append('tutor_id', document.getElementById('tutor_id').value);
        formData.append('estado', document.getElementById('estado').value);
        formData.append('fecha_presentacion', document.getElementById('fecha_presentacion').value);
        
        const file = document.getElementById('ruta_pdf_input').files[0];
        if(file) formData.append('ruta_pdf', file);

        if(id) formData.append('_method', 'PUT'); // Para que Laravel reconozca la edición con archivos

        const url = id ? `${apiBase}/${id}` : apiBase;

        axios.post(url, formData)
            .then(() => {
                myModal.hide();
                location.reload();
            })
            .catch(err => {
                alert('Error al guardar: Verifique que el archivo sea PDF y los datos estén completos.');
                console.error(err.response.data);
            });
    });

    function deleteTesis(id) {
        if(confirm('¿Seguro que desea eliminar esta tesis? Esta acción borrará el registro y el archivo PDF de la PC.')) {
            axios.delete(`${apiBase}/${id}`).then(() => location.reload());
        }
    }
</script>
@endsection