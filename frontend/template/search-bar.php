<?php
/**
 * search-bar.php Template
 *
 * @package ListingEngineFrontend
 */

if (! defined('ABSPATH')) {
    exit;
}

global $wpdb;

// Fallback Archive URL for template logic if needed
$archive_page_id = $wpdb->get_var($wpdb->prepare(
    "SELECT page_id FROM {$wpdb->prefix}admin_management WHERE name = %s",
    'Listing Archive'
));

$archive_url = $archive_page_id ? get_permalink($archive_page_id) : home_url('/');
?>

<div class="lef-search-container" id="lefSearchBar">
    <!-- Desktop Search Bar -->
    <div class="search-section desktop-only">
        <div class="search-bar">
            <!-- Location Field -->
            <div class="search-field" id="locationTrigger">
                <label>Where</label>
                <div class="search-field-wrapper">
                    <input type="text" placeholder="Search destinations" id="locationInput" autocomplete="off">
                    <button class="field-clear-btn" type="button" id="clearLocation">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Check In Field -->
            <div class="search-field" id="checkinTrigger">
                <label>Check in</label>
                <div class="search-field-wrapper">
                    <input type="text" placeholder="Add dates" readonly id="displayCheckin">
                    <button class="field-clear-btn" type="button" id="clearCheckin">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Check Out Field -->
            <div class="search-field" id="checkoutTrigger">
                <label>Check out</label>
                <div class="search-field-wrapper">
                    <input type="text" placeholder="Add dates" readonly id="displayCheckout">
                    <button class="field-clear-btn" type="button" id="clearCheckout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </div>

            <!-- Guests Field -->
            <div class="search-field" id="guestsTrigger">
                <label>Who</label>
                <div class="search-field-wrapper">
                    <input type="text" placeholder="Add guests" readonly id="displayGuests">
                    <button class="field-clear-btn" type="button" id="clearGuests">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 6L6 18M6 6l12 12" stroke-width="2" stroke-linecap="round"/></svg>
                    </button>
                </div>
            </div>

            <button class="search-btn" type="button" id="executeSearch">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Search Bar Trigger -->
    <div class="mobile-search-section mobile-only">
        <div class="mobile-search-trigger" id="mobileSearchTrigger">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <div class="mobile-search-text">
                <span id="mobileDisplayLocation">Anywhere</span>
                <span id="mobileDisplayMeta">Any week • Add guests</span>
            </div>
            <button class="mobile-search-filter-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 21v-7m0-4V3m8 18v-11m0-4V3m8 18v-3m0-4V3M1 14h6m2-6h6m2 10h6"/></svg>
            </button>
        </div>
    </div>

    <!-- Shared Popup (Desktop) -->
    <div class="search-popup" id="searchPopup">
        <!-- Location Section -->
        <div class="popup-section location-section" id="locationPopup">
            <div class="suggestions-list" id="suggestionsList">
                <!-- AJAX Results -->
            </div>
        </div>

        <!-- Date Section -->
        <div class="popup-section date-section" id="datePopup">
            <div class="calendar-wrapper">
                <div class="calendar-header">
                    <button class="calendar-nav-btn prev" type="button" id="prevMonth"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 18l-6-6 6-6"/></svg></button>
                    <div class="calendar-month-year" id="monthYear"></div>
                    <button class="calendar-nav-btn next" type="button" id="nextMonth"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 18l6-6-6-6"/></svg></button>
                </div>
                <div class="calendar-grid" id="calendarGrid">
                    <!-- JS Generated -->
                </div>
                <div class="calendar-footer">
                    <button class="calendar-btn clear" type="button" id="clearDatesPopup">Clear</button>
                    <button class="calendar-btn apply" type="button" id="applyDates">Apply</button>
                </div>
            </div>
        </div>

        <!-- Guests Section -->
        <div class="popup-section guests-section" id="guestsPopup">
            <div class="guest-counter">
                <!-- Adults -->
                <div class="guest-row">
                    <div class="guest-info">
                        <h4>Adults</h4>
                        <p>Ages 13 or above</p>
                    </div>
                    <div class="guest-controls">
                        <button class="guest-btn" type="button" data-type="minus" data-guest-type="adults">−</button>
                        <span class="guest-count" id="adultsCount">1</span>
                        <button class="guest-btn" type="button" data-type="plus" data-guest-type="adults">+</button>
                    </div>
                </div>
                <!-- Children -->
                <div class="guest-row">
                    <div class="guest-info">
                        <h4>Children</h4>
                        <p>Ages 2 – 12</p>
                    </div>
                    <div class="guest-controls">
                        <button class="guest-btn" type="button" data-type="minus" data-guest-type="children">−</button>
                        <span class="guest-count" id="childrenCount">0</span>
                        <button class="guest-btn" type="button" data-type="plus" data-guest-type="children">+</button>
                    </div>
                </div>
                <!-- Infants -->
                <div class="guest-row">
                    <div class="guest-info">
                        <h4>Infants</h4>
                        <p>Under 2</p>
                    </div>
                    <div class="guest-controls">
                        <button class="guest-btn" type="button" data-type="minus" data-guest-type="infants">−</button>
                        <span class="guest-count" id="infantsCount">0</span>
                        <button class="guest-btn" type="button" data-type="plus" data-guest-type="infants">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Modal -->
    <div class="mobile-modal-overlay" id="mobileModal">
        <div class="mobile-modal-header">
            <button class="mobile-modal-back" type="button" id="closeMobileModal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 6L6 18M6 6l12 12" stroke-width="2"/></svg></button>
            <div class="mobile-modal-title">Search</div>
            <button class="mobile-modal-clear" type="button" id="resetMobile">Clear all</button>
        </div>
        <div class="mobile-tabs">
            <div class="mobile-tab active" data-tab="location">Where</div>
            <div class="mobile-tab" data-tab="date">When</div>
            <div class="mobile-tab" data-tab="guests">Who</div>
        </div>
        <div class="mobile-content">
            <div class="mobile-tab-content active" id="mob-location">
                <div class="mobile-location-input">
                    <svg viewBox="0 0 24 24" stroke="currentColor" fill="none"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <input type="text" placeholder="Search destinations" id="mobLocationInput" autocomplete="off">
                </div>
                <div class="mobile-suggestions" id="mobSuggestionsList"></div>
            </div>
            <div class="mobile-tab-content" id="mob-date">
                 <div class="mobile-date-picker">
                    <div class="mobile-calendar-header">
                        <span id="mobMonthYear"></span>
                    </div>
                    <div class="mobile-calendar-nav">
                        <button class="mobile-calendar-nav-btn" type="button" id="mobPrevMonth"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 18l-6-6 6-6"/></svg></button>
                        <button class="mobile-calendar-nav-btn" type="button" id="mobNextMonth"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 18l6-6-6-6"/></svg></button>
                    </div>
                    <div class="calendar-grid" id="mobCalendarGrid"></div>
                 </div>
            </div>
            <div class="mobile-tab-content" id="mob-guests">
                 <div class="guest-counter">
                    <div class="guest-row">
                        <div class="guest-info"><h4>Adults</h4><p>Ages 13 or above</p></div>
                        <div class="guest-controls">
                            <button class="guest-btn" type="button" data-type="minus" data-guest-type="adults">−</button>
                            <span class="guest-count" id="mobAdultsCount">1</span>
                            <button class="guest-btn" type="button" data-type="plus" data-guest-type="adults">+</button>
                        </div>
                    </div>
                    <div class="guest-row">
                        <div class="guest-info"><h4>Children</h4><p>Ages 2 – 12</p></div>
                        <div class="guest-controls">
                            <button class="guest-btn" type="button" data-type="minus" data-guest-type="children">−</button>
                            <span class="guest-count" id="mobChildrenCount">0</span>
                            <button class="guest-btn" type="button" data-type="plus" data-guest-type="children">+</button>
                        </div>
                    </div>
                    <div class="guest-row">
                        <div class="guest-info"><h4>Infants</h4><p>Under 2</p></div>
                        <div class="guest-controls">
                            <button class="guest-btn" type="button" data-type="minus" data-guest-type="infants">−</button>
                            <span class="guest-count" id="mobInfantsCount">0</span>
                            <button class="guest-btn" type="button" data-type="plus" data-guest-type="infants">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer">
            <button class="mobile-search-btn" type="button" id="mobileExecuteSearch">Search</button>
        </div>
    </div>
</div>
