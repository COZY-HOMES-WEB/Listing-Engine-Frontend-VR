<?php
/**
 * Admin Dashboard Template
 *
 * @package ListingEngineFrontend
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap lef-dashboard-wrap">
	<h1 class="wp-heading-inline">Listing Engine Dashboard</h1>
	
	<div class="lef-dashboard-container">
		<div class="lef-dashboard-welcome-panel">
			<h2>Welcome to Listing Engine Frontend</h2>
			<p class="about-description">Manage your listings, configuration, and database all in one place.</p>
		</div>

		<div class="lef-dashboard-widgets">
			<div class="lef-dashboard-widget">
				<h3>Quick Actions</h3>
				<ul class="lef-quick-actions">
					<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=lef-database' ) ); ?>" class="button button-primary">Manage Database</a></li>
				</ul>
			</div>
			<div class="lef-dashboard-widget">
				<h3>System Status</h3>
				<p>All systems running smoothly.</p>
			</div>
		</div>
	</div>
</div>
