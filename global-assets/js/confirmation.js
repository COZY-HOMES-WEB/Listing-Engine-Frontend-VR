/**
 * confirmation.js
 */
const LEB_Confirm = {
    modal: null,
    callback: null,

    init() {
        this.modal = document.getElementById('lef-confirmation-modal');
        if (!this.modal) {
            const modalHtml = `
                <div id="lef-confirmation-modal" class="lef-modal">
                    <div class="lef-modal-content">
                        <h3 id="lef-confirm-title">Confirm Action</h3>
                        <p id="lef-confirm-message">Are you sure you want to proceed?</p>
                        <div class="lef-modal-actions">
                            <button id="lef-confirm-no" class="lef-btn lef-btn-secondary">No</button>
                            <button id="lef-confirm-yes" class="lef-btn lef-btn-primary">Yes</button>
                        </div>
                    </div>
                </div>`;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            this.modal = document.getElementById('lef-confirmation-modal');
        }
        
        // Always re-bind events to ensure they work on the newly created or existing modal
        this.modal.querySelector('#lef-confirm-no').onclick = () => this.close(false);
        this.modal.querySelector('#lef-confirm-yes').onclick = () => this.close(true);
    },

    open(options, callback) {
        this.init();
        if (!this.modal) return;

        this.callback = callback;
        document.getElementById('lef-confirm-title').innerText = options.title || 'Confirm Action';
        document.getElementById('lef-confirm-message').innerText = options.message || 'Are you sure?';

        this.modal.classList.add('show');
    },

    close(confirmed) {
        if (!this.modal) return;
        this.modal.classList.remove('show');
        if (this.callback) {
            this.callback(confirmed);
        }
    }
};

window.LEB_Confirm = LEB_Confirm;
