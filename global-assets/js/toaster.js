/**
 * toaster.js
 */
const LEB_Toast = {
    container: null,

    init() {
        this.container = document.getElementById('lef-toaster-container');
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = 'lef-toaster-container';
            this.container.className = 'lef-toaster-container';
            document.body.appendChild(this.container);
        }
    },

    show(message, type = 'info', duration = 2000) {
        this.init();

        const toast = document.createElement('div');
        toast.className = `lef-toast ${type}`;
        
        // Simple icon based on type
        let icon = '🔔';
        if (type === 'error') icon = '❌';
        if (type === 'success') icon = '✅';

        toast.innerHTML = `
            <span class="lef-toast-icon">${icon}</span>
            <span class="lef-toast-message">${message}</span>
        `;

        this.container.appendChild(toast);

        // Animate in
        setTimeout(() => toast.classList.add('show'), 10);

        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, duration);
    }
};

window.LEB_Toast = LEB_Toast;
