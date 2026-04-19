<?php
/**
 * View Booking Detail Modal Template.
 *
 * This file acts as a template for the booking detail modal content.
 * It is populated dynamically via JS.
 *
 * @package ListingEngineFrontend
 */
?>
<div class="lef-my-book-detail-wrapper" id="lef-my-book-detail-modal">
    <!-- Close icon and basic header info is usually handled by the global modal container -->
    <div class="lef-my-book-detail-content">
        
        <!-- Property Info Section -->
        <div class="lef-my-book-detail-hero">
            <div class="lef-my-book-detail-image">
                <img id="lef-my-book-detail-prop-img" src="" alt="Property" onerror="this.src='<?php echo LEF_PLUGIN_URL . 'global-assets/images/placeholder-avatar.png'; ?>'">
            </div>
            <div class="lef-my-book-detail-header">
                <span class="lef-my-book-detail-id" id="lef-my-book-detail-number">#RES-0000</span>
                <h3 class="lef-my-book-detail-title" id="lef-my-book-detail-prop-title">Property Title</h3>
                <p class="lef-my-book-detail-address" id="lef-my-book-detail-prop-addr">Property Address</p>
            </div>
        </div>

        <div class="lef-my-book-detail-grid">
            <!-- Left Column: Dates & Guests -->
            <div class="lef-my-book-detail-section">
                <h4 class="lef-my-book-detail-section-title">Booking Information</h4>
                <div class="lef-my-book-detail-item">
                    <label>Reserve Dates</label>
                    <span id="lef-my-book-detail-dates">-</span>
                </div>
                <div class="lef-my-book-detail-item">
                    <label>Total Guests</label>
                    <span id="lef-my-book-detail-guests">-</span>
                </div>
                <div class="lef-my-book-detail-item">
                    <label>Requested On</label>
                    <span id="lef-my-book-detail-requested">-</span>
                </div>
            </div>

            <!-- Right Column: Status & Price -->
            <div class="lef-my-book-detail-section">
                <h4 class="lef-my-book-detail-section-title">Price & Status</h4>
                <div class="lef-my-book-detail-item">
                    <label>Current Status</label>
                    <span class="lef-my-book-status-badge" id="lef-my-book-detail-status">-</span>
                </div>
                <div class="lef-my-book-detail-item">
                    <label>Total Paid</label>
                    <span class="lef-my-book-detail-price" id="lef-my-book-detail-price">$0.00</span>
                </div>
                <div class="lef-my-book-detail-item">
                    <label>Last Updated</label>
                    <span id="lef-my-book-detail-updated">-</span>
                </div>
            </div>
        </div>

        <div class="lef-my-book-detail-footer">
            <button type="button" class="lef-my-book-detail-close-btn" onclick="LEF_Confirmation.close()">Close Detail</button>
        </div>
    </div>
</div>

<style>
/* Localized modal styles to ensure zero-conflict Detail appearance */
.lef-my-book-detail-wrapper {
    padding: 10px;
    max-width: 700px;
}
.lef-my-book-detail-hero {
    display: flex;
    gap: 20px;
    margin-bottom: 24px;
    border-bottom: 1px solid var(--leb-border-color);
    padding-bottom: 20px;
}
.lef-my-book-detail-image img {
    width: 140px;
    height: 100px;
    border-radius: 8px;
    object-fit: cover;
}
.lef-my-book-detail-id {
    display: inline-block;
    background: var(--leb-bg-light);
    color: var(--leb-text-muted);
    font-size: 0.8rem;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 4px;
    margin-bottom: 8px;
}
.lef-my-book-detail-title {
    font-size: 1.3rem;
    font-weight: 800;
    margin: 0;
    color: var(--leb-secondary-color);
}
.lef-my-book-detail-address {
    color: var(--leb-text-muted);
    font-size: 0.9rem;
    margin: 6px 0 0;
}
.lef-my-book-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}
.lef-my-book-detail-section-title {
    font-size: 1rem;
    font-weight: 800;
    margin: 0 0 15px;
    color: var(--leb-secondary-color);
    border-left: 4px solid var(--leb-primary-color);
    padding-left: 10px;
}
.lef-my-book-detail-item {
    margin-bottom: 15px;
}
.lef-my-book-detail-item label {
    display: block;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--leb-text-muted);
    margin-bottom: 4px;
}
.lef-my-book-detail-item span {
    font-weight: 800;
    color: var(--leb-text-color);
}
.lef-my-book-detail-price {
    font-size: 1.25rem;
    color: var(--leb-primary-color) !important;
}
.lef-my-book-detail-footer {
    display: flex;
    justify-content: flex-end;
    border-top: 1px solid var(--leb-border-color);
    padding-top: 20px;
}
.lef-my-book-detail-close-btn {
    background: var(--leb-secondary-color);
    color: white;
    border: 0;
    border-radius: 8px;
    padding: 10px 24px;
    font-weight: 800;
    cursor: pointer;
}

@media (max-width: 600px) {
    .lef-my-book-detail-hero { flex-direction: column; }
    .lef-my-book-detail-grid { grid-template-columns: 1fr; }
}
</style>
