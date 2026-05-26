<div class="row" id="tesis-container">
    @forelse($tesis as $t)
        <div class="col-md-6 mb-4 tesis-item" 
             data-searchtext="{{ strtolower($t->titulo . ' ' . ($t->autor->nombre ?? '') . ' ' . ($t->tutor->nombre ?? '')) }}" 
             data-carrera="{{ $t->especializacion->carrera_id ?? '' }}"
             data-especializacion="{{ $t->especializacion_id ?? '' }}">

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
                                <a href="{{ asset('storage/' . $t->ruta_pdf) }}" target="_blank" class="btn btn-outline-danger btn-sm px-3" title="Abrir PDF en visor">
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