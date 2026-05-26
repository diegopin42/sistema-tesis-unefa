@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('web.tesis.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-primary p-4 border-0">
                        <h4 class="mb-0 text-white fw-bold">
                            <i class="bi bi-cloud-arrow-up me-2"></i> Nuevo Registro de Tesis
                        </h4>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        {{-- Título --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Título de la Investigación</label>
                            <textarea name="titulo" class="form-control @error('titulo') is-invalid @enderror" rows="2" required
                                placeholder="Ingrese el título completo...">{{ old('titulo') }}</textarea>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Autor y Tutor --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Autor (Estudiante)</label>
                                <select name="autor_id" class="form-select select2-custom @error('autor_id') is-invalid @enderror" required>
                                    <option value="">Buscar por Cédula o Nombre...</option>
                                    @foreach($personas as $p)
                                        <option value="{{ $p->id }}" data-cedula="{{ $p->cedula }}" {{ old('autor_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->cedula }} | {{ $p->nombre }} {{ $p->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tutor Académico</label>
                                <select name="tutor_id" class="form-select select2-custom @error('tutor_id') is-invalid @enderror" required>
                                    <option value="">Buscar por Cédula o Nombre...</option>
                                    @foreach($personas as $p)
                                        <option value="{{ $p->id }}" data-cedula="{{ $p->cedula }}" {{ old('tutor_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->cedula }} | {{ $p->nombre }} {{ $p->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Especialización --}}
                        <div class="mb-5">
                            <label class="form-label fw-bold">Especialización</label>
                            <select name="especializacion_id" class="form-select select2-custom @error('especializacion_id') is-invalid @enderror" required>
                                <option value="">Seleccione carrera y especialidad...</option>
                                @foreach($especializaciones->groupBy(fn($item) => $item->carrera->nombre . " - " . $item->carrera->sede->nombre) as $carrera => $esps)
                                    <optgroup label="{{ $carrera }}">
                                        @foreach($esps as $e)
                                            <option value="{{ $e->id }}" {{ old('especializacion_id') == $e->id ? 'selected' : '' }}>
                                                {{ $e->nombre }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- Zona de Carga de Archivo (Drag & Drop + Explorador) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Documento Final (PDF o Word)</label>
                            <div id="drop-zone" class="drop-zone border-2 border-dashed rounded-4 p-5 text-center bg-light position-relative">
                                
                                {{-- Vista inicial --}}
                                <div id="drop-prompt" class="d-flex flex-column align-items-center">
                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-1 mb-2"></i>
                                    <h5 class="fw-bold">Arrastra el archivo aquí</h5>
                                    <p class="text-muted small">o si lo prefieres</p>
                                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" id="btn-browse">
                                        <i class="bi bi-folder2-open me-2"></i>Buscar en carpetas
                                    </button>
                                    <small class="text-muted mt-3">Máximo 10MB (PDF, DOC, DOCX)</small>
                                </div>

                                {{-- Vista de archivo seleccionado --}}
                                <div id="file-info" class="d-none">
                                    <div class="d-flex align-items-center justify-content-center bg-white p-3 rounded shadow-sm border">
                                        <i class="bi bi-file-check-fill text-success fs-2 me-3"></i>
                                        <div class="text-start">
                                            <p id="file-name" class="mb-0 fw-bold small text-truncate" style="max-width: 250px;"></p>
                                            <p id="file-size" class="mb-0 text-muted extra-small"></p>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-4" onclick="resetFile(event)">
                                            <i class="bi bi-trash me-1"></i> Quitar
                                        </button>
                                    </div>
                                </div>

                                <input type="file" name="archivo" id="archivo" class="d-none" accept=".pdf,.doc,.docx" required>
                            </div>
                            @error('archivo')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Acciones --}}
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('web.tesis.index') }}" class="btn btn-light px-4 border">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold rounded-pill shadow">
                                Registrar Tesis
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Estilos --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--single {
        height: 45px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        display: flex;
        align-items: center;
    }
    .drop-zone {
        cursor: pointer;
        transition: all 0.3s ease;
        border-color: #cbd5e0 !important;
    }
    .drop-zone:hover, .drop-zone--over {
        background-color: #f0f7ff !important;
        border-color: #0d6efd !important;
    }
    .extra-small { font-size: 0.75rem; }
</style>

{{-- Scripts --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // 1. Select2
        $('.select2-custom').select2({
            width: '100%',
            templateResult: function (data) {
                if (!data.id) return data.text;
                let cedula = $(data.element).data('cedula');
                return $(`<span><b class="text-primary">${cedula || ''}</b> - ${data.text.split('|')[1] || data.text}</span>`);
            }
        });

        // 2. Lógica de Archivos
        const dropZone = $('#drop-zone');
        const input = $('#archivo');
        const info = $('#file-info');
        const prompt = $('#drop-prompt');
        const btnBrowse = $('#btn-browse');

        // Abrir explorador al dar clic en la zona o el botón
        dropZone.on('click', () => input[0].click());
        btnBrowse.on('click', (e) => {
            e.stopPropagation(); // Evita doble clic
            input[0].click();
        });

        // Evento cuando se selecciona archivo (Explorador)
        input.on('change', function () {
            if (this.files.length) handleFile(this.files[0]);
        });

        // Eventos Drag & Drop
        dropZone.on('dragover', (e) => { 
            e.preventDefault(); 
            dropZone.addClass('drop-zone--over'); 
        });

        dropZone.on('dragleave drop', () => dropZone.removeClass('drop-zone--over'));

        dropZone.on('drop', (e) => {
            e.preventDefault();
            const files = e.originalEvent.dataTransfer.files;
            if (files.length) {
                input[0].files = files; // Asigna el archivo al input oculto
                handleFile(files[0]);
            }
        });

        function handleFile(file) {
            // Validación de tamaño en Frontend (10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert("El archivo es muy pesado (Máximo 10MB)");
                resetFile(new Event('click'));
                return;
            }

            $('#file-name').text(file.name);
            $('#file-size').text((file.size / 1024 / 1024).toFixed(2) + ' MB');
            
            prompt.addClass('d-none');
            info.removeClass('d-none');
        }

        window.resetFile = function (e) {
            e.stopPropagation();
            input.val('');
            info.addClass('d-none');
            prompt.removeClass('d-none');
        }
    });
</script>
@endsection