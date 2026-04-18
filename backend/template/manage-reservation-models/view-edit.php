<?php
/**
 * View/Edit Reservation Template.
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Assuming $reserv is passed here from the AJAX handler.
if ( ! isset( $reserv ) ) {
    return;
}
?>

<div class="lef-reserv-details">
    <!-- Property Info -->
    <div class="lef-reserv-detail-section">
        <h3 class="lef-reserv-section-title">Property Information</h3>
        <div class="lef-reserv-detail-grid">
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Property Name</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['property_title'] ); ?></span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Location</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['prop_location'] ); ?></span>
            </div>
        </div>
    </div>

    <!-- Booking Info -->
    <div class="lef-reserv-detail-section">
        <h3 class="lef-reserv-section-title">Booking Information</h3>
        <div class="lef-reserv-detail-grid">
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Reservation Number</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['reservation_number'] ); ?></span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Status</span>
                <span class="lef-reserv-status-badge" data-lef-reserv-status="<?php echo esc_attr( $reserv['status'] ); ?>">
                    <?php echo esc_html( ucfirst( $reserv['status'] ) ); ?>
                </span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Check-in</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['check_in'] ); ?></span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Check-out</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['check_out'] ); ?></span>
            </div>
        </div>
    </div>

    <!-- Guest Info -->
    <div class="lef-reserv-detail-section">
        <h3 class="lef-reserv-section-title">Guest Details</h3>
        <div class="lef-reserv-detail-grid">
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Guest Name</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['user_name'] ); ?></span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Email</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['user_email'] ); ?></span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Guests Breakdown</span>
                <span class="lef-reserv-detail-value">
                    <?php 
                    $g = $reserv['guests'];
                    echo esc_html( "{$g['adults']} Adults, {$g['children']} Children, {$g['infants']} Infants" ); 
                    ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Payment Info -->
    <div class="lef-reserv-detail-section">
        <h3 class="lef-reserv-section-title">Payment Information</h3>
        <div class="lef-reserv-detail-grid">
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Total Price</span>
                <span class="lef-reserv-detail-value lef-reserv-price-highlight">
                    ₹<?php echo esc_html( number_format( $reserv['total_price'], 2 ) ); ?>
                </span>
            </div>
            <div class="lef-reserv-detail-item">
                <span class="lef-reserv-detail-label">Request Date</span>
                <span class="lef-reserv-detail-value"><?php echo esc_html( $reserv['created_at'] ); ?></span>
            </div>
        </div>
    </div>
</div>
