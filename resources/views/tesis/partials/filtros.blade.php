<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4 bg-light">
        <h6 class="fw-bold text-muted mb-3"><i class="bi bi-funnel-fill"></i> Filtros de Búsqueda Avanzada</h6>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group rounded-pill overflow-hidden border bg-white">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="searchTerm" class="form-control border-0 py-2 shadow-none" placeholder="Título, autor o tutor..." onkeyup="filterTesis()">
                </div>
            </div>

            <div class="col-md-4">
                <select id="filterCarrera" class="form-select border rounded-pill py-2 shadow-none" onchange="filterTesis()">
                    <option value="">Todas las Carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select id="filterEspecializacion" class="form-select border rounded-pill py-2 shadow-none" onchange="filterTesis()">
                    <option value="">Todas las Especializaciones</option>
                    @foreach($especializaciones as $esp)
                        <option value="{{ $esp->id }}">{{ $esp->nombre }} ({{ ucfirst($esp->tipo ?? '') }})</option>
                    @endforeach
                </select>
            </div>
            
            </div>
    </div>
</div>