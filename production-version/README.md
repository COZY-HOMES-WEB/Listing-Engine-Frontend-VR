# Listing Engine Frontend

| | |
|---|---|
| **Plugin Name** | Listing Engine Frontend |
| **Plugin URI** | https://arttechfuzion.com |
| **Description** | A powerful WordPress plugin for vacation rental and property listing websites. Build professional property listing experiences with search, filters, wishlists, reviews, reservation management, and user dashboards. |
| **Version** | 1.0.0 |
| **Requires at least** | WordPress 5.0 |
| **Requires PHP** | 7.4 |
| **Author** | Art-Tech Fuzion |
| **Author URI** | https://arttechfuzion.com |
| **License** | GPL v2 or later |
| **License URI** | https://www.gnu.org/licenses/gpl-2.0.html |

---

## Overview

Listing Engine Frontend provides a complete vacation rental solution for WordPress websites. It includes property browsing, advanced search, secure detail pages, wishlists, reviews, reservation management, and user dashboards for travellers, hosts, and administrators.

Perfect for property listing websites, vacation rental platforms, and hospitality businesses looking to manage their listings directly within WordPress.

---

## Core Features

- **Property Listings** — Browse properties with advanced filters (location, dates, guests, amenities, price)
- **Search Bar** — Premium search bar with location suggestions, date range picker, and guest selection
- **Property Details** — Secure detail pages with image galleries, amenities, host info, reviews, and booking options
- **Wishlist** — Save favorite properties for later
- **Reviews** — Guests can leave reviews after completed stays
- **Reservations** — Request-based reservation flow with email notifications
- **User Dashboards** — Separate dashboards for travellers, hosts, and administrators
- **OTP Verification** — Secure profile changes with OTP
- **Payout Management** — Store bank and UPI details for hosts

---

## Quick Start

### Installation

1. Copy the plugin folder to `wp-content/plugins/`
2. Run `composer install` (if vendor/ is missing)
3. Activate the plugin in WordPress admin
4. Create pages with required shortcodes

### Required Shortcodes

| Page | Shortcode |
|------|-----------|
| All Properties | `[listing_engine_view]` |
| Property Detail | `[single_property_view]` |
| User Profile | `[lef_my_profile]` |
| Search Bar | `[premium_search_bar]` |
| Featured Listings | `[selected_list_view]` |

### Setup Steps

1. Create WordPress pages with the shortcodes above
2. Map pages in `wp_admin_management` table
3. Go to **LEF > Database** to create required tables
4. Ensure companion listing tables exist

---

## User Roles

| Role | Access |
|------|--------|
| **Traveller** | Browse properties, make reservations, write reviews, manage bookings |
| **Host** | All traveller features + create/edit/manage listings, payout details |
| **Administrator** | All features + manage reservations, repair database, plugin settings |

---

## Shortcodes Reference

### `[listing_engine_view]`
Main property archive page with filters, sorting, and wishlist.

### `[single_property_view]`
Property detail page. Requires `property_ref` URL parameter.

### `[lef_my_profile]`
User dashboard for profile, bookings, and listings.

### `[premium_search_bar]`
Standalone search bar for header/hero sections.

### `[selected_list_view]`
Curated property sections for homepage blocks.

---

## Support

For issues or questions, refer to the main documentation in the repository root or contact the plugin administrator.

---

## Credits

Developed by **Art-Tech Fuzion** — https://arttechfuzion.com