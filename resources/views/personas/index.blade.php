@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-md-4">
        <h2 class="fw-bold" style="color: var(--azul-unefa);">
            <img src="{{ asset('img/usuarios.png') }}" alt="Icono" width="35" class="me-2 mb-1">
            Gestión de Autores y Tutores
        </h2>
        <button class="btn btn-primary bg-unefa border-0 rounded-pill px-4 shadow-sm" onclick="abrirModalNuevo()">
            <span class="fs-5 me-1">+</span> Nuevo Registro
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4 mx-md-4">
        <div class="card-body p-4">
            
            <div class="row mb-4">
                <div class="col-md-5">
                    <div class="input-group shadow-sm rounded-pill border">
                        <span class="input-group-text bg-white border-0 ms-2 text-muted">🔍</span>
                        <input type="text" id="buscadorPersonas" class="form-control border-0 bg-white" placeholder="Buscar por cédula o nombre..." onkeyup="filtrarTabla()">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="text-white" style="background-color: var(--azul-unefa);">
                        <tr>
                            <th class="ps-3 rounded-start">Cédula</th>
                            <th>Nombres y Apellidos</th>
                            <th>Rol</th>
                            <th class="text-center rounded-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaPersonas">
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted">Cargando registros del sistema...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPersona" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--azul-unefa);">
                <h5 class="modal-title fw-bold" id="modalPersonaLabel">Registrar Persona</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formPersona">
                    <input type="hidden" id="personaId">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold">Cédula de Identidad</label>
                        <input type="text" id="cedula" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-bold">Nombre</label>
                            <input type="text" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted fw-bold">Apellidos</label>
                            <input type="text" id="apellidos" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold">Rol en la Institución</label>
                        <select id="rol" class="form-select" required>
                            <option value="" disabled selected>Seleccione...</option>
                            <option value="estudiante">Estudiante (Autor)</option>
                            <option value="tutor">Tutor (Docente)</option>
                            <option value="jurado">Jurado</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary bg-unefa border-0 rounded-pill px-4" onclick="guardarPersona()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modalElement = document.getElementById('modalPersona');
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
    const tbody = document.getElementById('tablaPersonas');
    const API_URL = '/api/v1/personas';

    // 1. CARGAR DATOS (READ)
    async function cargarPersonas() {
        try {
            const response = await fetch(API_URL);
            const res = await response.json();
            renderTabla(res.data || res);
        } catch (error) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error de conexión con la API.</td></tr>';
        }
    }

    function renderTabla(datos) {
        tbody.innerHTML = '';
        if(!datos || datos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">No hay registros encontrados.</td></tr>';
            return;
        }

        datos.forEach(p => {
            let badge = p.rol === 'estudiante' ? 'bg-primary' : 'bg-success';
            tbody.innerHTML += `
                <tr>
                    <td class="ps-3 fw-bold">${p.cedula}</td>
                    <td>${p.nombre} ${p.apellidos}</td>
                    <td><span class="badge ${badge} rounded-pill px-3">${p.rol.toUpperCase()}</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning rounded-circle me-1" onclick="editarPersona(${p.id})">✏️</button>
                        <button class="btn btn-sm btn-outline-danger rounded-circle" onclick="eliminarPersona(${p.id})">🗑️</button>
                    </td>
                </tr>`;
        });
    }

    // 2. ABRIR MODAL LIMPIO
    function abrirModalNuevo() {
        document.getElementById('formPersona').reset();
        document.getElementById('personaId').value = '';
        document.getElementById('modalPersonaLabel').innerText = 'Registrar Persona';
        modal.show();
    }

    // 3. GUARDAR / ACTUALIZAR (CREATE / UPDATE)
    async function guardarPersona() {
        const id = document.getElementById('personaId').value;
        const payload = {
            cedula: document.getElementById('cedula').value,
            nombre: document.getElementById('nombre').value,
            apellidos: document.getElementById('apellidos').value,
            rol: document.getElementById('rol').value,
        };

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_URL}/${id}` : API_URL;

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const res = await response.json();

            if (response.ok) {
                if (document.activeElement) document.activeElement.blur();
                modal.hide();
                cargarPersonas();
            } else {
                alert("Error: " + (res.message || "Datos inválidos"));
            }
        } catch (error) {
            console.error("Error:", error);
        }
    }

    // 4. CARGAR PARA EDITAR
    async function editarPersona(id) {
    try {
        // Usamos la constante API_URL que ya definimos como '/api/v1/personas'
        const response = await fetch(`${API_URL}/${id}`);
        
        if (!response.ok) throw new Error("Error al obtener datos");

        const res = await response.json();
        // Laravel Resources suelen envolver los datos en 'data'
        const p = res.data || res;

        // Llenamos el formulario con los nombres correctos de tu migración
        document.getElementById('personaId').value = p.id;
        document.getElementById('cedula').value = p.cedula;
        document.getElementById('nombre').value = p.nombre; // 'nombre' en singular
        document.getElementById('apellidos').value = p.apellidos;
        document.getElementById('rol').value = p.rol;

        document.getElementById('modalPersonaLabel').innerText = 'Editar Registro';
        modal.show();
    } catch (error) {
        console.error(error);
        alert("No se pudo obtener la información de la persona.");
    }
}

    // 5. ELIMINAR (DELETE)
    async function eliminarPersona(id) {
        if(!confirm("¿Deseas eliminar permanentemente este registro?")) return;

        try {
            const response = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            const res = await response.json();
            if(response.ok) {
                cargarPersonas();
            } else {
                alert(res.message);
            }
        } catch (error) {
            console.error("Error al eliminar");
        }
    }

    // 6. BUSCADOR (CLIENT SIDE)
    function filtrarTabla() {
        const busqueda = document.getElementById('buscadorPersonas').value.toLowerCase();
        const filas = tbody.getElementsByTagName('tr');
        
        for (let fila of filas) {
            const texto = fila.innerText.toLowerCase();
            fila.style.display = texto.includes(busqueda) ? '' : 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', cargarPersonas);
</script>
@endsection