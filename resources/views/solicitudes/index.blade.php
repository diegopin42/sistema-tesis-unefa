@extends('layouts.app')

@section('content')
<div class="container py-4" x-data="solicitudesTable()">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Bandeja de Solicitudes (Landing)</h2>
        <button class="btn btn-outline-primary btn-sm" @click="fetchSolicitudes()" :disabled="isLoading">
            <span x-show="!isLoading"><i class="bi bi-arrow-clockwise"></i> Actualizar</span>
            <span x-show="isLoading" class="spinner-border spinner-border-sm" role="status"></span>
        </button>
    </div>

    <!-- Mensaje Error API -->
    <div x-show="errorMessage" class="alert alert-danger" x-text="errorMessage" style="display: none;"></div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0">Estudiante/Remitente</th>
                            <th class="px-4 py-3 border-0">Contacto</th>
                            <th class="px-4 py-3 border-0">Mensaje/Tema</th>
                            <th class="px-4 py-3 border-0 text-center">Estado</th>
                            <th class="px-4 py-3 border-0 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loading State -->
                        <template x-if="isLoading && solicitudes.length === 0">
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status"></div>
                                    <p class="text-muted mt-2">Cargando solicitudes desde la API...</p>
                                </td>
                            </tr>
                        </template>

                        <!-- Empty State -->
                        <template x-if="!isLoading && solicitudes.length === 0">
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1"></i>
                                    <p class="mt-2">No hay solicitudes nuevas.</p>
                                </td>
                            </tr>
                        </template>

                        <!-- Data Rows -->
                        <template x-for="solicitud in solicitudes" :key="solicitud.id">
                            <tr :class="solicitud.estado === 'pendiente' ? 'table-warning' : ''">
                                <td class="px-4 py-3 fw-medium">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;" x-text="solicitud.nombre.charAt(0).toUpperCase()"></div>
                                        <span x-text="solicitud.nombre"></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-muted" x-text="solicitud.correo"></td>
                                <td class="px-4 py-3 text-truncate" style="max-width: 250px;" x-text="solicitud.mensaje"></td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge rounded-pill" 
                                          :class="solicitud.estado === 'pendiente' ? 'bg-warning text-dark' : 'bg-success'"
                                          x-text="solicitud.estado.toUpperCase()">
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <button class="btn btn-sm btn-outline-success" 
                                            x-show="solicitud.estado === 'pendiente'"
                                            @click="marcarLeida(solicitud.id)"
                                            title="Marcar como leída">
                                        <i class="bi bi-check2-all"></i> Revisada
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('solicitudesTable', () => ({
            solicitudes: [],
            isLoading: false,
            errorMessage: '',

            init() {
                this.fetchSolicitudes();
            },

            async fetchSolicitudes() {
                this.isLoading = true;
                this.errorMessage = '';
                try {
                    const response = await fetch('/api/v1/solicitudes', {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error('Error al cargar la API');
                    const json = await response.json();
                    this.solicitudes = json.data;
                } catch (error) {
                    this.errorMessage = 'No se pudo conectar con el servidor API.';
                } finally {
                    this.isLoading = false;
                }
            },

            async marcarLeida(id) {
                try {
                    // Petición PATCH para actualizar estado a nivel de API
                    const response = await fetch(`/api/v1/solicitudes/${id}/read`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                    
                    if(response.ok) {
                        // Actualizar estado localmente en el arr (Reactividad) sin recargar
                        const s = this.solicitudes.find(x => x.id === id);
                        if (s) s.estado = 'revisado';
                    }
                } catch (error) {
                    alert('Error al marcar como leído');
                }
            }
        }));
    });
</script>
@endsection
