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
        <a href="{{ route('web.tesis.create') }}" class="btn btn-primary shadow-sm px-4 fw-bold rounded-pill">
            <i class="bi bi-plus-circle-fill me-2"></i> Registrar Nueva Tesis
        </a>
    </div>

    @include('tesis.partials.filtros')

    @include('tesis.partials.lista')

</div>

@include('tesis.partials.modal')

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

    // Búsqueda avanzada en tiempo real (Frontend)
    function filterTesis() {
        const term = document.getElementById('searchTerm').value.toLowerCase();
        const carreraId = document.getElementById('filterCarrera').value;
        const especializacionId = document.getElementById('filterEspecializacion').value;
        // const sedeId = document.getElementById('filterSede').value; // Descomentar si usas sedes

        document.querySelectorAll('.tesis-item').forEach(item => {
            const content = item.dataset.searchtext;
            const itemCarrera = item.dataset.carrera;
            const itemEsp = item.dataset.especializacion;
            // const itemSede = item.dataset.sede;

            const matchTerm = content.includes(term);
            const matchCarrera = carreraId === '' || itemCarrera === carreraId;
            const matchEsp = especializacionId === '' || itemEsp === especializacionId;
            // const matchSede = sedeId === '' || itemSede === sedeId;

            item.style.display = (matchTerm && matchCarrera && matchEsp) ? 'block' : 'none';
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
        if(id) formData.append('_method', 'PUT');

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
        if(confirm('¿Seguro que desea eliminar esta tesis? Esta acción borrará el registro y el archivo PDF.')) {
            axios.delete(`${apiBase}/${id}`).then(() => location.reload());
        }
    }
</script>
@endsection