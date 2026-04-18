/**
 * Reservation Detail View JS
 * Handles AJAX detail fetching and modal lifecycle.
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        const $modal = $('#lef-reserv-detail-modal');
        const $modalContent = $('#lef-reserv-modal-content');
        const $cardList = $('#lef-reserv-card-list');

        /**
         * Handle View Details Click
         */
        function lefReservHandleViewDetails() {
            const id = $(this).data('id');
            $modalContent.html('<div style="text-align:center;padding:40px;">Loading details...</div>');
            $modal.fadeIn(200);

            $.ajax({
                url: lefReservData.ajax_url,
                type: 'POST',
                data: {
                    action: 'lef_reserv_get_details',
                    nonce: lefReservData.nonce,
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        $modalContent.html(response.data.html);
                    } else {
                        $modalContent.html(`<div class="error" style="color:var(--leb-error-color);padding:20px;">${response.data.message}</div>`);
                    }
                },
                error: function() {
                    $modalContent.html('<div class="error" style="color:var(--leb-error-color);padding:20px;">Failed to load details.</div>');
                }
            });
        }

        /**
         * Close Modal
         */
        function lefReservCloseModal() {
            $modal.fadeOut(200);
        }

        // Bind Events
        $cardList.on('click', '.lef-reserv-view-btn', lefReservHandleViewDetails);
        $('#lef-reserv-modal-close').on('click', lefReservCloseModal);
        
        // Close on outside click
        $(window).on('click', function(e) {
            if ($(e.target).is($modal)) {
                lefReservCloseModal();
            }
        });
    });

})(jQuery);
