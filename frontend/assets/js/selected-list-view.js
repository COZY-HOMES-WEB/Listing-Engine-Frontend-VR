/**
 * selected-list-view.js
 * 
 * Handles carousel navigation and card clicks for the [selected_list_view] shortcode.
 */

(function($) {
    'use strict';

    const SelectedListView = {
        init: function() {
            this.bindEvents();
            this.initCarousels();
        },

        bindEvents: function() {
            // 1. Universal Card Redirection
            $(document).on('click', '.lef-property-card', function(e) {
                // Prevent redirect if clicking on a UI button (like favorite)
                if ($(e.target).closest('button').length) return;

                const url = $(this).data('redirect');
                if (url && url !== '#') {
                    window.location.href = url;
                }
            });

            // 2. Favorite Toggle (Visual Only)
            $(document).on('click', '.lef-favorite-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).toggleClass('is-active');
                
                // Trigger global toaster if available
                if (typeof LEB_Toaster !== 'undefined') {
                    const isActive = $(this).hasClass('is-active');
                    LEB_Toaster.show(isActive ? 'Added to wishlist!' : 'Removed from wishlist', 'info');
                }
            });
        },

        initCarousels: function() {
            $('.lef-view-carousel').each(function() {
                const $container = $(this);
                const $track = $container.find('.lef-carousel-track');
                const $btnPrev = $container.find('.lef-nav-prev');
                const $btnNext = $container.find('.lef-nav-next');

                if (!$track.length) return;

                // Scroll Logic
                const scrollAmount = () => {
                    const firstCard = $track.find('.lef-property-card').first();
                    return firstCard.outerWidth() + 20; // card width + gap
                };

                $btnPrev.on('click', function() {
                    $track.animate({
                        scrollLeft: '-=' + scrollAmount()
                    }, 400);
                });

                $btnNext.on('click', function() {
                    $track.animate({
                        scrollLeft: '+=' + scrollAmount()
                    }, 400);
                });

                // Update Button Visibility
                const updateButtons = () => {
                    const scrollLeft = $track.scrollLeft();
                    const maxScroll = $track[0].scrollWidth - $track[0].clientWidth;

                    $btnPrev.toggleClass('is-hidden', scrollLeft <= 5);
                    $btnNext.toggleClass('is-hidden', scrollLeft >= maxScroll - 5);
                };

                $track.on('scroll', updateButtons);
                $(window).on('resize', updateButtons);
                updateButtons(); // Initial check
            });
        }
    };

    $(document).ready(function() {
        SelectedListView.init();
    });

})(jQuery);
