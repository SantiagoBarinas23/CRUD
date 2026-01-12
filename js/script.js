// js/script.js

// Función para confirmar eliminaciones
function confirmDelete(e, message = "¿Estás seguro de que quieres eliminar este usuario?") {
    if (!confirm(message)) {
        e.preventDefault();
        return false;
    }
    return true;
}

// Función para validar formularios
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    return isValid;
}

// Función para mostrar/ocultar contraseña
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validar que las contraseñas coincidan
function validatePasswordMatch(passwordId, confirmPasswordId) {
    const password = document.getElementById(passwordId).value;
    const confirmPassword = document.getElementById(confirmPasswordId).value;
    const submitBtn = document.querySelector('button[type="submit"]');
    
    if (confirmPassword === '') return true;
    
    if (password !== confirmPassword) {
        document.getElementById(confirmPasswordId).classList.add('is-invalid');
        submitBtn.disabled = true;
        return false;
    } else {
        document.getElementById(confirmPasswordId).classList.remove('is-invalid');
        submitBtn.disabled = false;
        return true;
    }
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize DataTables with Spanish language
    if (typeof $.fn.DataTable !== 'undefined') {
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'desc']]
        });
    }

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Real-time search
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#usuariosTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});

// Export to CSV
function exportToCSV(filename = 'usuarios.csv') {
    const table = document.getElementById('usuariosTable');
    const rows = table.querySelectorAll('tr');
    const csv = [];
    
    rows.forEach(row => {
        const rowData = [];
        const cells = row.querySelectorAll('th, td');
        
        cells.forEach(cell => {
            // Remove action buttons and icons
            if (!cell.querySelector('.btn-action')) {
                rowData.push(cell.textContent.trim());
            }
        });
        
        if (rowData.length > 0) {
            csv.push(rowData.join(','));
        }
    });
    
    const csvContent = "data:text/csv;charset=utf-8," + csv.join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", filename);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Toast notifications
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    const toastId = 'toast-' + Date.now();
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.id = toastId;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', function () {
        toast.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'position-fixed top-0 end-0 p-3';
    container.style.zIndex = '1050';
    document.body.appendChild(container);
    return container;
}