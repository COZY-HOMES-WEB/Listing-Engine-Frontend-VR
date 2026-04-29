# Listing Engine Frontend (VR)

| | |
|---|---|
| **Plugin Name** | Listing Engine Frontend |
| **Plugin Slug** | `LEF-(VR)` |
| **Version** | 1.0.0 |
| **Author** | Art-Tech Fuzion |
| **Author URI** | https://arttechfuzion.com |
| **Plugin URI** | https://arttechfuzion.com |
| **Description** | A WordPress plugin for vacation rental and property listing websites with search, filters, wishlists, reviews, reservations, and user dashboards. |
| **Requires at least** | WordPress 5.0 |
| **Requires PHP** | 7.4 |
| **License** | GPL v2 or later |

---

## Table of Contents

1. [About This Plugin](#about-this-plugin)
2. [Getting Started](#getting-started)
   - [Prerequisites](#prerequisites)
   - [Download the Repository](#download-the-repository)
   - [Set Up Local WordPress](#set-up-local-wordpress)
   - [Install and Run the Plugin](#install-and-run-the-plugin)
3. [Features Overview](#features-overview)
4. [Installation](#installation)
5. [User Guide](#user-guide)
6. [Shortcodes Reference](#shortcodes-reference)
7. [Developer Guide](#developer-guide)
   - [Folder Structure](#folder-structure)
   - [Customizing the Plugin](#customizing-the-plugin)
   - [Adding Shortcodes](#adding-shortcodes)
   - [Adding AJAX Endpoints](#adding-ajax-endpoints)
   - [Phone Validation System](#phone-validation-system)
8. [Companion Routing Plugin](#companion-routing-plugin)
9. [Database Tables](#database-tables)
10. [Deployment Guide](#deployment-guide)
11. [Troubleshooting](#troubleshooting)
12. [Credits](#credits)

---

## About This Plugin

**Listing Engine Frontend** is a WordPress plugin that powers the customer-facing experience for vacation rental and property listing websites. It connects property browsing, search with advanced filters, secure single-property pages, wishlist management, review system, reservation workflows, and role-based dashboards for travellers, hosts, and administrators into a single cohesive platform.

The plugin integrates with WordPress shortcodes, AJAX handlers, user roles, email notifications, and custom database tables to deliver a complete property listing experience.

---

## Getting Started

### Prerequisites

- **Git** — [Download Git](https://git-scm.com/downloads)
- **Local WordPress environment** — [LocalWP](https://localwp.com/) (recommended), XAMPP, Docker, or MAMP/WAMP
- **A code editor** — VS Code, Sublime, PHPStorm, or similar

### Download the Repository

#### Option 1: Clone via Git (recommended)

```bash
git clone https://github.com/your-username/Vacation-Rental-Listing-Engine-Frontend.git
cd Vacation-Rental-Listing-Engine-Frontend
```

#### Option 2: Download as ZIP

1. Open the repository on GitHub
2. Click **Code** > **Download ZIP**
3. Extract to your desired location

### Set Up Local WordPress

#### Using LocalWP (Recommended)

1. Install [LocalWP](https://localwp.com/)
2. Create a new site and wait for setup to complete
3. Click **WP Admin** to access the dashboard

WordPress path:
- **macOS:** `~/Local Sites/<site-name>/app/public`
- **Windows:** `C:\Users\<YourName>\Local Sites\<site-name>\app\public`

#### Using XAMPP

1. Start Apache + MySQL from XAMPP Control Panel
2. Extract WordPress into `htdocs/wordpress`
3. Create a database via `http://localhost/phpmyadmin`
4. Complete WordPress setup at `http://localhost/wordpress`

### Install and Run the Plugin

#### 1. Copy plugin to WordPress

```bash
# LocalWP (macOS)
cp -r production-version ~/Local\ Sites/<site-name>/app/public/wp-content/plugins/listing-engine-frontend

# XAMPP (Windows)
xcopy /E /I production-version C:\xampp\htdocs\wordpress\wp-content\plugins\listing-engine-frontend
```

Or drag the `production-version` folder into `wp-content/plugins/` and rename it to `listing-engine-frontend`.

#### 2. Activate the plugin

Go to **WP Admin > Plugins** and activate **Listing Engine Frontend**. The **LEF** menu will appear in the sidebar.

#### 3. Install the companion Admin Management plugin

This plugin requires a companion plugin that manages the `wp_admin_management` table for page routing. Install and activate it the same way.

#### 4. Create required pages

Create these pages in **WP Admin > Pages > Add New**:

| Page Name       | Shortcode                  |
|-----------------|----------------------------|
| Listing Archive | `[listing_engine_view]`    |
| Property Detail | `[single_property_view]`   |
| My Profile      | `[lef_my_profile]`         |
| Home (optional) | `[premium_search_bar]`     |

#### 5. Set up route mapping

Use the companion plugin to map routes in `wp_admin_management`:
- `Listing Archive` → Listing Archive page ID
- `Listing Single View` → Property Detail page ID

#### 6. Create LEF database tables

Go to **LEF > Database** and click **Create / Repair** for each table.

### Working with the Code

```bash
# Navigate to production folder
cd Vacation-Rental-Listing-Engine-Frontend/production-version

# Sync changes to minify version
cp -r production-version/* minify-version/

# Commit and push
git add . && git commit -m "description" && git push origin main
```

All changes in `production-version/` reflect immediately in WordPress — no build step required.

---

## Features Overview

- **Property Archive** — Full listing grid with URL-driven filters for location, type, price, amenities, guests, check-in/out dates, and sorting.
- **Premium Search Bar** — Standalone search hero with location autocomplete, date picker, guest selector, and GPS-based reverse geocoding via OpenStreetMap Nominatim.
- **Curated Property Sections** — Display featured or location-filtered properties in grid or carousel layouts.
- **Single Property Pages** — Image gallery, description, amenities, host info, blocked-date awareness, reviews, wishlist toggle, similar properties, and reservation form.
- **User Dashboard** — Profile editing, OTP verification, password management, and role-based sections (bookings for travellers, listings for hosts, payouts for hosts/admins).
- **Admin Panel** — Reservation management, LEF database repair, and shortcode reference.
- **Email Notifications** — OTP, reservation confirmations, and profile update emails via `wp_mail()`.

---

## Installation

1. **Choose the correct version:**
   - `production-version/` — Readable source code for development.
   - `minify-version/` — Distribution-ready copy for deployment.

2. **Place the plugin** in `wp-content/plugins/listing-engine-frontend/`.

3. **Activate** from WP Admin > Plugins.

4. **Create pages** with shortcodes listed in [Shortcodes Reference](#shortcodes-reference).

5. **Install companion Admin Management plugin** for `wp_admin_management` routing.

6. **Create LEF tables** from LEF > Database.

7. **Add route records** in `wp_admin_management` through the companion plugin.

---

## User Guide

### For Site Owners

- Add listing pages using shortcodes.
- Manage reservations from **LEF > Manage Reserv**.
- Create or repair tables from **LEF > Database**.
- Reference shortcodes from **LEF > Dashboard**.

### For Travellers

- Browse and search properties by location, dates, guests, and amenities.
- Save favourites to wishlist.
- Submit reservation requests.
- Leave reviews after completed stays.
- Manage bookings and profile from dashboard.

### For Hosts

- Create, edit, duplicate, and delete listings.
- Manage listing status.
- Store payout details (bank account, UPI).
- View and manage listings from dashboard.

---

## Shortcodes Reference

### `[listing_engine_view]`

Main property archive page with full filtering, sorting, and wishlist support.

```text
[listing_engine_view]
```

**URL Parameters:**

| Parameter   | Description            |
|-------------|------------------------|
| `location`  | Filter by location     |
| `address`   | Filter by address      |
| `type`      | Filter by property type|
| `guests`    | Filter by guest count  |
| `checkin`   | Check-in date          |
| `checkout`  | Check-out date         |
| `amenities` | Filter by amenities    |
| `min-price` | Minimum price          |
| `max-price` | Maximum price          |
| `sort`      | Sort order             |

### `[selected_list_view]`

Curated property sections for homepages or landing pages.

```text
[selected_list_view count="6" view="grid" location="Goa" type="Villa"]
```

| Attribute  | Values            | Default | Description              |
|------------|-------------------|---------|--------------------------|
| `count`    | integer           | `9`     | Number of properties     |
| `view`     | `grid`, `carousel`| `grid`  | Display layout           |
| `location` | string            | empty   | Filter by location       |
| `type`     | string            | empty   | Filter by property type  |

### `[premium_search_bar]`

Standalone search bar for hero sections.

```text
[premium_search_bar]
```

### `[single_property_view]`

Property detail page. Resolves property from `property_ref` URL parameter automatically.

```text
[single_property_view]
```

### `[lef_my_profile]`

Logged-in user dashboard with role-based access.

```text
[lef_my_profile]
```

---

## Developer Guide

### Folder Structure

| Path                            | Responsibility                                        |
|---------------------------------|-------------------------------------------------------|
| `listing-engine-frontend.php`   | Main plugin bootstrap                                 |
| `includes/shortcode-handler.php`| Shortcode registration and rendering                  |
| `includes/url-router.php`       | Secure property URL generation and `property_ref` decode |
| `includes/assets-loader.php`    | CSS/JS enqueueing                                     |
| `includes/ajax-handler.php`     | AJAX controller (search, reservations, profile, reviews, listings) |
| `includes/helpers.php`          | Shared helpers                                        |
| `includes/db-schema.php`        | LEF table schema definitions                          |
| `includes/class-db-handler.php` | DB status and repair logic                            |
| `frontend/template/`            | Frontend shortcode templates                          |
| `backend/template/`             | Admin screen templates                                |
| `mails/`                        | Email templates                                       |
| `global-assets/`                | Shared CSS/JS/UI components                           |

### Customizing the Plugin

- **Markup:** `frontend/template/` or `backend/template/`
- **Styles:** `frontend/assets/css/`, `backend/assets/css/`, or `global-assets/css/global.css`
- **JavaScript:** `frontend/assets/js/` or `backend/assets/js/`
- **Email Templates:** `mails/`

### Adding Shortcodes

1. Register in `includes/shortcode-handler.php`
2. Create/update template in `frontend/template/`
3. Enqueue assets in `includes/assets-loader.php`
4. Add AJAX handlers in `includes/ajax-handler.php` if needed

### Adding AJAX Endpoints

1. Add PHP action handler in `includes/ajax-handler.php`
2. Register `wp_ajax_{action}` hook (and `wp_ajax_nopriv_{action}` for guests)
3. Localize data/nonce in `includes/assets-loader.php`
4. Update the matching JS file

### Phone Validation System

Phone validation is handled via JavaScript — no external dependencies required.

**File:** `global-assets/js/phone-core.js`

**`PhoneCore` API:**
- `getCountries()` — Returns all country data
- `findCountry(code)` — Find country by calling code
- `detectCountry(number)` — Auto-detect country from number prefix
- `validate(number, country)` — Validate phone against selected country rules
- `format(number)` — Format phone number display

**Supported:** 40+ countries across all major regions.

**To add/modify countries:** Edit the `countries` array in `phone-core.js`:

```js
{ name: "Country", code: "+XX", flag: "🏳️", min: 10, max: 10, regex: /^\d{10}$/ }
```

**Server validation:** Handled via `wp_ajax_lef_edit_prof_validate_phone` in `includes/ajax-handler.php`.

---

## Companion Routing Plugin

This plugin requires a companion plugin that manages the `wp_admin_management` database table for page-to-route mapping.

### What is `wp_admin_management`?

A custom WordPress table that stores routing configurations. This plugin reads from it to determine which pages handle:
- Listing archive
- Property detail pages
- Logout URL

### Setup

1. Install the companion Admin Management plugin on the same WordPress site
2. Add route records through its admin interface

### Required Route Records

| Name                  | Points To                                  |
|-----------------------|--------------------------------------------|
| `Listing Archive`     | Page with `[listing_engine_view]`          |
| `Listing Single View` | Page with `[single_property_view]`         |
| `Logout` / `logout`   | Optional custom logout route               |

### Without Routing

- Missing `Listing Archive` → Search bar and "See all" cards fail to redirect
- Missing `Listing Single View` → Detail pages return `error_not_found`
- Missing `Logout` → Falls back to `wp_logout_url()`

### How Routing Works

`includes/url-router.php` queries `wp_admin_management` to:
1. Find the page ID for `Listing Single View`
2. Generate the page permalink
3. Append the obfuscated `property_ref` parameter (Base64-encoded listing ID)

The search bar and curated list sections use the same table to find the archive page URL for redirects.

---

## Database Tables

### Tables Managed by This Plugin

Created/repaired via **LEF > Database**:

| Table                  | Purpose              |
|------------------------|----------------------|
| `wp_ls_reservation`    | Reservation requests |
| `wp_ls_reviews`        | Review records       |
| `wp_ls_wishlist`       | Wishlist entries     |

### Tables Required from Companion System

| Table                     | Purpose               |
|---------------------------|-----------------------|
| `wp_ls_property`          | Property records      |
| `wp_ls_img`               | Property images       |
| `wp_ls_location`          | Location data         |
| `wp_ls_types`             | Property types        |
| `wp_ls_amenities`         | Amenities data        |
| `wp_ls_block_date`        | Blocked dates         |
| `wp_authme_otp_storage`   | OTP storage           |

**Note:** This plugin is not fully standalone. Missing companion tables will break listing data, OTP, and profile features.

---

## Deployment Guide

### Version Strategy

| Version              | Purpose                                       |
|----------------------|-----------------------------------------------|
| `production-version` | Development and customization (readable source) |
| `minify-version`     | Distribution-ready for deployment             |

### Deployment Steps

1. Make changes in `production-version/`
2. Sync to `minify-version/`: `cp -r production-version/* minify-version/`
3. Create a ZIP of `minify-version/`
4. Rename to `LEF-(VR).zip` (recommended for zero conflict, or use any custom name)
5. Upload via WP Admin > Plugins > Add New > Upload Plugin

**Always keep `minify-version/` clean and deployment-ready.**

### Companion Plugin Requirement

Ensure the companion Admin Management plugin is installed on the target WordPress site before deploying.

---

## Troubleshooting

### Property detail page redirects away

- Confirm companion plugin is installed and active
- Verify `Listing Single View` mapping exists in `wp_admin_management`
- Check `property_ref` URL parameter is present and valid
- Confirm property ID exists in `wp_ls_property`

### Search bar does not redirect correctly

- Confirm companion plugin is installed and active
- Verify `Listing Archive` mapping exists in `wp_admin_management`
- Confirm archive page contains `[listing_engine_view]`

### Country dropdown is empty

- Verify `global-assets/js/phone-core.js` is loaded (check `includes/assets-loader.php`)
- Open browser console and confirm `window.PhoneCore` is defined
- Check for JavaScript errors on the profile page

### OTP email not received

- Configure WordPress mail (`wp_mail()`)
- Confirm `wp_authme_otp_storage` table exists
- Check server email delivery settings

### Wishlist / reviews / bookings fail

- Create LEF tables from **LEF > Database**
- Verify companion listing tables exist
- Check AJAX nonce and login state

---

## Credits

**Developed by [Art-Tech Fuzion](https://arttechfuzion.com)**
