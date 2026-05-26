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
                            <textarea id="titulo" class="form-control border-0 shadow-sm" rows="3" required placeholder="Ej: Sistema de Gestión..."></textarea>
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