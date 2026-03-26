/**
 * Modern Form Handler untuk SIGASKU MANDIRI
 * Handles AJAX form submission dengan loading states dan error handling
 */

class ModernFormHandler {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.submitBtn = this.form.querySelector('button[type="submit"]');
        this.originalBtnText = this.submitBtn ? this.submitBtn.innerHTML : '';
        this.init();
    }

    init() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        }
    }

    async handleSubmit(e) {
        e.preventDefault();

        // Show loading state
        this.setLoadingState(true);

        // Get form data
        const formData = new FormData(this.form);

        try {
            // Send AJAX request
            const response = await fetch(this.form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Success
                this.handleSuccess(data);
            } else {
                // Error
                this.handleError(data);
            }

        } catch (error) {
            console.error('Form submission error:', error);
            this.showToast('Terjadi kesalahan saat mengirim data', 'error');
        } finally {
            this.setLoadingState(false);
        }
    }

    setLoadingState(loading) {
        if (!this.submitBtn) return;

        if (loading) {
            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2 inline" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;
            this.submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        } else {
            this.submitBtn.disabled = false;
            this.submitBtn.innerHTML = this.originalBtnText;
            this.submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    }

    handleSuccess(data) {
        // Show success toast
        this.showToast(data.message || 'Berhasil!', 'success');

        // Redirect after short delay
        if (data.data && data.data.redirect_url) {
            setTimeout(() => {
                window.location.href = data.data.redirect_url;
            }, 1000);
        }
    }

    handleError(data) {
        // Show error messages
        if (data.errors) {
            // Display field-specific errors
            Object.keys(data.errors).forEach(field => {
                const fieldElement = this.form.querySelector(`[name="${field}"]`);
                if (fieldElement) {
                    this.showFieldError(fieldElement, data.errors[field][0]);
                }
            });

            this.showToast('Mohon periksa kembali form Anda', 'error');
        } else {
            this.showToast(data.message || 'Terjadi kesalahan', 'error');
        }
    }

    showFieldError(field, message) {
        // Remove existing error
        const existingError = field.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }

        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-red-500 text-sm mt-1 animate-fade-in';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);

        // Add error styling to field
        field.classList.add('border-red-500', 'focus:ring-red-500');

        // Remove error on input
        field.addEventListener('input', function removeError() {
            field.classList.remove('border-red-500', 'focus:ring-red-500');
            if (errorDiv && errorDiv.parentElement) {
                errorDiv.remove();
            }
            field.removeEventListener('input', removeError);
        }, { once: true });
    }

    showToast(message, type = 'info') {
        // Remove existing toast
        const existingToast = document.getElementById('dynamicToast');
        if (existingToast) {
            existingToast.remove();
        }

        // Color scheme based on type
        const colors = {
            success: 'from-green-500 to-green-600',
            error: 'from-red-500 to-red-600',
            warning: 'from-yellow-500 to-yellow-600',
            info: 'from-blue-500 to-blue-600'
        };

        const icons = {
            success: 'M5 13l4 4L19 7',
            error: 'M6 18L18 6M6 6l12 12',
            warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
            info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
        };

        // Create toast
        const toast = document.createElement('div');
        toast.id = 'dynamicToast';
        toast.className = `fixed top-4 right-4 bg-gradient-to-r ${colors[type]} text-white px-6 py-4 rounded-xl shadow-2xl z-50 transform transition-all duration-300 animate-slide-in-right`;
        toast.innerHTML = `
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-${type === 'success' ? 'green' : type === 'error' ? 'red' : type === 'warning' ? 'yellow' : 'blue'}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icons[type]}"/>
                    </svg>
                </div>
                <span class="font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
}

// Progressive form validation (validate per step)
class ProgressiveFormValidator {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.currentStep = 1;
    }

    async validateCurrentStep() {
        const formData = new FormData(this.form);
        formData.append('step', this.currentStep);

        try {
            const response = await fetch('/api/gugatan/validate-step', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                // Show validation errors
                if (data.errors) {
                    this.displayValidationErrors(data.errors);
                }
                return false;
            }

            return true;

        } catch (error) {
            console.error('Validation error:', error);
            return false;
        }
    }

    displayValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const fieldElement = this.form.querySelector(`[name="${field}"]`);
            if (fieldElement) {
                // Add error message below field
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-red-500 text-sm mt-1 animate-fade-in';
                errorDiv.textContent = errors[field][0];
                
                // Remove existing error
                const existingError = fieldElement.parentElement.querySelector('.text-red-500');
                if (existingError) {
                    existingError.remove();
                }
                
                fieldElement.parentElement.appendChild(errorDiv);
                fieldElement.classList.add('border-red-500');
            }
        });
    }

    setCurrentStep(step) {
        this.currentStep = step;
    }
}

// Auto-save form data to localStorage
class FormAutoSave {
    constructor(formId, storageKey) {
        this.form = document.getElementById(formId);
        this.storageKey = storageKey || 'form_autosave';
        this.init();
    }

    init() {
        if (!this.form) return;

        // Load saved data on page load
        this.loadSavedData();

        // Save data on input
        this.form.addEventListener('input', () => {
            this.saveFormData();
        });

        // Clear saved data on successful submit
        this.form.addEventListener('submit', () => {
            this.clearSavedData();
        });
    }

    saveFormData() {
        const formData = new FormData(this.form);
        const data = {};

        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        localStorage.setItem(this.storageKey, JSON.stringify(data));
        console.log('Form data auto-saved');
    }

    loadSavedData() {
        const savedData = localStorage.getItem(this.storageKey);
        
        if (savedData) {
            try {
                const data = JSON.parse(savedData);
                
                Object.keys(data).forEach(key => {
                    const field = this.form.querySelector(`[name="${key}"]`);
                    if (field && !field.value) {
                        field.value = data[key];
                    }
                });

                console.log('Form data loaded from autosave');
            } catch (error) {
                console.error('Error loading autosave data:', error);
            }
        }
    }

    clearSavedData() {
        localStorage.removeItem(this.storageKey);
        console.log('Autosave data cleared');
    }
}

// Export for use in other files
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ModernFormHandler, ProgressiveFormValidator, FormAutoSave };
}