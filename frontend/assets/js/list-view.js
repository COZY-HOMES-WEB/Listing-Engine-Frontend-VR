/**
 * list-view.js
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        
        // 1. Image Carousel Logic
        $('.lef-property-grid').on('click', '.lef-image-nav', function(e) {
            e.stopPropagation();
            const $btn = $(this);
            const $container = $btn.closest('.lef-card-image-container');
            const images = JSON.parse($container.attr('data-images'));
            let current = parseInt($container.attr('data-current'));
            const direction = $btn.hasClass('lef-nav-next') ? 1 : -1;

            current = (current + direction + images.length) % images.length;
            
            $container.attr('data-current', current);
            $container.find('.lef-card-image').attr('src', images[current]);
        });

        // 2. Favorite Toggle
        $('.lef-property-grid').on('click', '.lef-favorite-btn', function(e) {
            e.stopPropagation();
            $(this).toggleClass('active');
            LEB_Toast.show('Wishlist functionality coming soon!', 'success');
        });

        // 3. Card Click Redirect
        $('.lef-property-grid').on('click', '.lef-property-card', function() {
            const redirectUrl = $(this).attr('data-redirect');
            
            if (redirectUrl === 'error_not_found') {
                LEB_Toast.show('Page not found', 'error');
            } else {
                window.location.href = redirectUrl;
            }
        });

    });

})(jQuery);
