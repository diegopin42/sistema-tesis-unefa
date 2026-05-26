<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing - Sistema de Gestión de Tesis UNEFA</title>
    <!-- Incluir Vite para cargar Tailwind y Alpinejs -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Colores adaptados a Tailwind v4 style con custom properties */
        :root {
            --color-unefa-blue: #003399;
            --color-unefa-gold: #ffcc00;
        }
        .bg-unefa-blue { background-color: var(--color-unefa-blue); }
        .text-unefa-gold { color: var(--color-unefa-gold); }
        .bg-unefa-gold { background-color: var(--color-unefa-gold); }
        .hover\:bg-unefa-dark:hover { background-color: #002266; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-unefa-blue selection:text-white" x-data="landingForm()">

    <!-- Navbar Minimalista -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/unefa-seeklogo.png') }}" alt="Logo UNEFA" class="h-12 w-auto">
                    <div class="flex flex-col">
                        <span class="font-bold text-xl text-unefa-blue leading-tight">UNEFA</span>
                        <span class="text-[0.65rem] font-medium text-slate-500 uppercase tracking-wider">Gestión de Tesis</span>
                    </div>
                </div>
                <div>
                    <a href="/dashboard" class="text-sm font-semibold text-slate-600 hover:text-unefa-blue transition-colors duration-200">
                        Ir al Sistema &rarr;
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-unefa-blue">
        <!-- SVG Decorativo Subyacente -->
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute left-0 top-0 h-full w-full" preserveAspectRatio="xMidYMid slice" fill="none" viewBox="0 0 100 100">
                <pattern id="grid" width="8" height="8" patternUnits="userSpaceOnUse">
                    <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                
                <!-- Text Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium mb-6">
                        <span class="flex h-2 w-2 rounded-full bg-unefa-gold"></span>
                        Nuevo Sistema de Recepción
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                        Simplifica la gestión de <br class="hidden sm:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-unefa-gold to-yellow-200">tu Tesis</span>
                    </h1>
                    <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto lg:mx-0">
                        Envía tus datos y consultas iniciales para comenzar el proceso de registro de tesis en la UNEFA núcleo Caracas. Todo desde una plataforma moderna y rápida.
                    </p>
                </div>

                <!-- Formulario Floating Card -->
                <div class="relative w-full max-w-md mx-auto lg:ml-auto">
                    <!-- Elemento Decorativo (Glow) -->
                    <div class="absolute -inset-1 bg-gradient-to-r from-unefa-gold to-yellow-400 rounded-2xl blur opacity-30 animate-pulse"></div>
                    
                    <div class="relative bg-white rounded-2xl shadow-2xl p-8 sm:p-10 border border-slate-100">
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Inicia el Proceso</h3>
                        <p class="text-sm text-slate-500 mb-6">Completa el formulario para solicitar recepción.</p>
                        
                        <!-- Formulario Alpine -->
                        <form @submit.prevent="submitData" class="space-y-5">
                            <!-- Nombre -->
                            <div class="relative">
                                <input type="text" id="nombre" x-model="formData.nombre" required
                                    class="peer w-full px-4 pt-5 pb-2 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-unefa-blue focus:ring-1 focus:ring-unefa-blue transition-colors"
                                    placeholder=" " />
                                <label for="nombre" class="absolute left-4 top-4 text-slate-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5 peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-unefa-blue peer-valid:top-1.5 peer-valid:text-xs">
                                    Nombre Completo
                                </label>
                            </div>

                            <!-- Correo -->
                            <div class="relative">
                                <input type="email" id="correo" x-model="formData.correo" required
                                    class="peer w-full px-4 pt-5 pb-2 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-unefa-blue focus:ring-1 focus:ring-unefa-blue transition-colors"
                                    placeholder=" " />
                                <label for="correo" class="absolute left-4 top-4 text-slate-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5 peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-unefa-blue peer-valid:top-1.5 peer-valid:text-xs">
                                    Correo Institucional
                                </label>
                            </div>

                            <!-- Mensaje / Solicitud -->
                            <div class="relative">
                                <textarea id="mensaje" x-model="formData.mensaje" required rows="3"
                                    class="peer w-full px-4 pt-5 pb-2 text-sm text-slate-900 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-unefa-blue focus:ring-1 focus:ring-unefa-blue transition-colors resize-none"
                                    placeholder=" "></textarea>
                                <label for="mensaje" class="absolute left-4 top-4 text-slate-400 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:top-3.5 peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-unefa-blue peer-valid:top-1.5 peer-valid:text-xs">
                                    Título tentativo o duda
                                </label>
                            </div>

                            <!-- Botón Submit -->
                            <button type="submit" :disabled="isSubmitting"
                                class="w-full py-3 px-4 bg-unefa-blue hover:bg-unefa-dark text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <span x-show="!isSubmitting">Enviar Solicitud</span>
                                <!-- Spinner de carga (Alpine x-show) -->
                                <svg x-show="isSubmitting" style="display: none;" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </form>

                        <!-- Mensaje de Éxito o Error -->
                        <div x-show="message" x-transition.opacity style="display: none;"
                            class="mt-4 p-3 rounded-lg text-sm font-medium text-center"
                            :class="isSuccess ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200'">
                            <span x-text="message"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-8 text-center text-slate-500 text-sm">
        <p>&copy; {{ date('Y') }} Sistema de Tesis - UNEFA. Todos los derechos reservados.</p>
    </footer>

    <!-- Alpine Script embebido (para el componente) -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('landingForm', () => ({
                formData: {
                    nombre: '',
                    correo: '',
                    mensaje: '',
                    _token: '{{ csrf_token() }}'
                },
                isSubmitting: false,
                message: '',
                isSuccess: false,
                
                async submitData() {
                    this.isSubmitting = true;
                    this.message = '';
                    
                    try {
                        const response = await fetch('/api/v1/solicitudes', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                nombre: this.formData.nombre,
                                correo: this.formData.correo,
                                mensaje: this.formData.mensaje
                            })
                        });
                        
                        const result = await response.json();
                        
                        if (response.ok) {
                            this.isSuccess = true;
                            this.message = result.message;
                            // Resetear formulario
                            this.formData.nombre = '';
                            this.formData.correo = '';
                            this.formData.mensaje = '';
                        } else {
                            this.isSuccess = false;
                            this.message = result.message || 'Hubo un error al enviar tu solicitud.';
                        }
                    } catch (error) {
                        this.isSuccess = false;
                        this.message = 'Error de conexión. Inténtalo de nuevo.';
                    } finally {
                        this.isSubmitting = false;
                        
                        // Ocultar mensaje después de 5 segundos si fue exitoso
                        if (this.isSuccess) {
                            setTimeout(() => {
                                this.message = '';
                            }, 5000);
                        }
                    }
                }
            }));
        });
    </script>
</body>
</html>
