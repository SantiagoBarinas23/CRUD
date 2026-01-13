// js/login.js
// Scripts específicos para la página de login

document.addEventListener('DOMContentLoaded', function() {
    // ========== VARIABLES GLOBALES ==========
    const loginForm = document.getElementById('loginForm');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const demoSection = document.querySelector('.demo-section');
    const usernameInput = document.getElementById('usuario');
    const passwordInput = document.getElementById('clave');
    const loginBtn = document.querySelector('.login-btn');
    
    // ========== FUNCIONES AUXILIARES ==========
    
    /**
     * Muestra un toast notification
     * @param {string} type - Tipo de toast (success, error, info)
     * @param {string} title - Título del toast
     * @param {string} message - Mensaje del toast
     * @param {number} duration - Duración en milisegundos
     */
    function showToast(type, title, message, duration = 3000) {
        // Remover toast existente
        const existingToast = document.querySelector('.login-toast');
        if (existingToast) {
            existingToast.remove();
        }
        
        // Crear nuevo toast
        const toast = document.createElement('div');
        toast.className = `login-toast ${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };
        
        toast.innerHTML = `
            <div class="toast-icon">
                <i class="fas ${icons[type]}"></i>
            </div>
            <div class="toast-content">
                <h4>${title}</h4>
                <p>${message}</p>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto-remover después de la duración
        setTimeout(() => {
            toast.style.animation = 'slideInUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) reverse';
            setTimeout(() => toast.remove(), 500);
        }, duration);
    }
    
    /**
     * Crea partículas de fondo
     */
    function createParticles() {
        const particlesContainer = document.querySelector('.particles');
        if (!particlesContainer) return;
        
        // Crear partículas
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            // Posición aleatoria
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            
            // Tamaño aleatorio
            const size = Math.random() * 3 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            
            // Opacidad aleatoria
            particle.style.opacity = Math.random() * 0.5 + 0.3;
            
            // Duración de animación aleatoria
            const duration = Math.random() * 20 + 10;
            particle.style.animationDuration = duration + 's';
            particle.style.animationDelay = Math.random() * 5 + 's';
            
            particlesContainer.appendChild(particle);
        }
    }
    
    /**
     * Crea formas de fondo animadas
     */
    function createBackgroundShapes() {
        const bgContainer = document.querySelector('.login-bg');
        if (!bgContainer) return;
        
        // Crear formas adicionales
        for (let i = 0; i < 5; i++) {
            const shape = document.createElement('div');
            shape.className = 'bg-shape';
            
            // Tamaño aleatorio
            const size = Math.random() * 100 + 50;
            shape.style.width = size + 'px';
            shape.style.height = size + 'px';
            
            // Posición aleatoria
            shape.style.left = Math.random() * 100 + '%';
            shape.style.top = Math.random() * 100 + '%';
            
            // Opacidad aleatoria
            shape.style.opacity = Math.random() * 0.15 + 0.05;
            
            // Animación delay
            shape.style.animationDelay = Math.random() * 15 + 's';
            
            bgContainer.appendChild(shape);
        }
    }
    
    /**
     * Inicia el efecto de carga en el botón
     */
    function startLoading() {
        if (loginBtn) {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;
        }
    }
    
    /**
     * Detiene el efecto de carga en el botón
     */
    function stopLoading() {
        if (loginBtn) {
            loginBtn.classList.remove('loading');
            loginBtn.disabled = false;
        }
    }
    
    /**
     * Valida el formulario de login
     */
    function validateForm() {
        const username = usernameInput.value.trim();
        const password = passwordInput.value.trim();
        
        // Validar que no estén vacíos
        if (!username || !password) {
            showToast('error', 'Campos incompletos', 'Por favor, completa todos los campos requeridos.');
            return false;
        }
        
        // Validar longitud mínima
        if (password.length < 3) {
            showToast('error', 'Contraseña muy corta', 'La contraseña debe tener al menos 3 caracteres.');
            return false;
        }
        
        return true;
    }
    
    /**
     * Copia texto al portapapeles
     */
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('success', 'Copiado', 'Texto copiado al portapapeles');
        }).catch(err => {
            showToast('error', 'Error', 'No se pudo copiar el texto');
            console.error('Error al copiar: ', err);
        });
    }
    
    // ========== EVENT LISTENERS ==========
    
    // Toggle mostrar/ocultar contraseña
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const isPassword = passwordInput.type === 'password';
            
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
            
            // Feedback táctil
            this.style.transform = 'translateY(-50%) scale(0.9)';
            setTimeout(() => {
                this.style.transform = 'translateY(-50%) scale(1)';
            }, 150);
        });
    }
    
    // Demo credentials click
    if (demoSection) {
        demoSection.addEventListener('click', function(e) {
            // No hacer nada si se hace clic en un botón de copiar
            if (e.target.classList.contains('credential-value') || 
                e.target.closest('.credential-value')) {
                return;
            }
            
            // Cargar credenciales demo
            usernameInput.value = 'admin';
            passwordInput.value = 'admin123';
            
            // Efecto visual
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
            
            // Mostrar mensaje
            showToast('info', 'Credenciales cargadas', 'Las credenciales demo han sido cargadas en el formulario.');
            
            // Enfocar el botón de login
            loginBtn.focus();
        });
        
        // Copiar credenciales al hacer clic
        document.querySelectorAll('.credential-value').forEach(element => {
            element.addEventListener('click', function(e) {
                e.stopPropagation();
                const text = this.textContent;
                copyToClipboard(text);
                
                // Efecto visual
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);
            });
        });
    }
    
    // Validación en tiempo real
    if (usernameInput) {
        usernameInput.addEventListener('input', function() {
            const wrapper = this.closest('.input-wrapper');
            if (this.value.trim()) {
                wrapper.classList.add('has-value');
            } else {
                wrapper.classList.remove('has-value');
            }
        });
    }
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const wrapper = this.closest('.input-wrapper');
            if (this.value.trim()) {
                wrapper.classList.add('has-value');
            } else {
                wrapper.classList.remove('has-value');
            }
        });
    }
    
    // Envío del formulario
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar formulario
            if (!validateForm()) {
                return false;
            }
            
            // Iniciar carga
            startLoading();
            
            // Simular envío (en producción esto sería real)
            setTimeout(() => {
                // En producción, quitar este timeout y dejar que el form se envíe normalmente
                // this.submit();
                
                // Por ahora, mostrar mensaje de éxito
                showToast('success', '¡Credenciales válidas!', 'Redirigiendo al sistema...');
                
                // Simular redirección
                setTimeout(() => {
                    this.submit();
                }, 1500);
                
            }, 1500);
        });
    }
    
    // Efectos de focus en inputs
    const inputs = document.querySelectorAll('.login-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.input-wrapper').classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.input-wrapper').classList.remove('focused');
        });
    });
    
    // Efecto de tecleo en el campo de usuario al cargar
    window.addEventListener('load', function() {
        if (usernameInput && !usernameInput.value) {
            setTimeout(() => {
                usernameInput.focus();
                
                // Efecto de escritura automática
                let text = 'admin';
                let i = 0;
                const typeWriter = setInterval(() => {
                    if (i < text.length) {
                        usernameInput.value += text.charAt(i);
                        i++;
                        usernameInput.dispatchEvent(new Event('input'));
                    } else {
                        clearInterval(typeWriter);
                        passwordInput.focus();
                        
                        // Escribir contraseña
                        text = 'admin123';
                        i = 0;
                        const passWriter = setInterval(() => {
                            if (i < text.length) {
                                passwordInput.value += text.charAt(i);
                                i++;
                                passwordInput.dispatchEvent(new Event('input'));
                            } else {
                                clearInterval(passWriter);
                                showToast('info', 'Demo cargado', 'Credenciales demo auto-completadas');
                            }
                        }, 100);
                    }
                }, 150);
            }, 1000);
        }
    });
    
    // ========== INICIALIZACIÓN ==========
    
    // Crear efectos de fondo
    createParticles();
    createBackgroundShapes();
    
    // Configurar tooltips para botones
    if (togglePasswordBtn) {
        togglePasswordBtn.title = 'Mostrar/ocultar contraseña';
    }
    
    // Prevenir clic derecho
    document.addEventListener('contextmenu', function(e) {
        if (e.target.closest('.credential-value')) {
            e.preventDefault();
            showToast('info', 'Protegido', 'Esta acción está deshabilitada por seguridad');
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + D para cargar demo
        if (e.ctrlKey && e.key === 'd') {
            e.preventDefault();
            if (demoSection) {
                demoSection.click();
            }
        }
        
        // Ctrl + / para mostrar ayuda
        if (e.ctrlKey && e.key === '/') {
            e.preventDefault();
            showToast('info', 'Atajos de teclado', 
                'Ctrl+D: Cargar demo\nCtrl+/: Mostrar ayuda\nF1: Ver documentación');
        }
        
        // F1 para "ayuda"
        if (e.key === 'F1') {
            e.preventDefault();
            showToast('info', 'Ayuda', 
                'Contacta al administrador si necesitas acceso al sistema.');
        }
        
        // Enter para enviar desde cualquier campo
        if (e.key === 'Enter' && !e.target.closest('button')) {
            if (loginForm && loginForm.checkValidity()) {
                loginForm.dispatchEvent(new Event('submit'));
            }
        }
    });
    
    // ========== ANIMACIONES INICIALES ==========
    
    // Animar entrada de elementos
    const animatedElements = document.querySelectorAll('.login-alert, .form-group, .demo-section, .login-footer');
    animatedElements.forEach((element, index) => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }, 300 + (index * 100));
    });
    
    // Log de inicialización
    console.log('%c🔐 Login Script Inicializado', 'color: #4361ee; font-weight: bold; font-size: 14px;');
    console.log('%cSistema seguro de autenticación', 'color: #666;');
});