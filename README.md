# Vacation Rental Listing Engine Frontend

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

`Listing Engine Frontend` is a WordPress plugin for vacation rental and property listing websites. It provides the customer-facing browsing experience, single-property experience, reservation flow, profile dashboard, host listing tools, and admin reservation management layer for a listing engine style project.

It connects WordPress pages, shortcodes, AJAX handlers, user roles, reservation records, reviews, wishlists, email notifications, and host/traveller dashboards into one workflow.

---

## Table of Contents

1. [What this plugin provides](#what-this-plugin-provides)
2. [Who this plugin is for](#who-this-plugin-is-for)
3. [Repository structure](#repository-structure)
4. [Shortcodes](#shortcodes)
   - [`[listing_engine_view]`](#1-listing_engine_view)
   - [`[selected_list_view]`](#2-selected_list_view)
   - [`[premium_search_bar]`](#3-premium_search_bar)
   - [`[single_property_view]`](#4-single_property_view)
   - [`[lef_my_profile]`](#5-lef_my_profile)
5. [Main feature breakdown](#main-feature-breakdown)
6. [Technologies and libraries used](#technologies-and-libraries-used)
7. [Database overview](#database-overview)
8. [Required page and route mapping](#required-page-and-route-mapping)
9. [Installation and setup](#installation-and-setup)
10. [Developer guide](#developer-guide)
11. [Common issues and fixes](#common-issues-and-fixes)
12. [Summary](#summary)

---

## What this plugin provides

- A full property archive page with search, filters, sorting, wishlist actions, and availability-aware results.
- Curated property sections for homepage blocks, landing pages, and location-based sections.
- A standalone premium search bar that redirects users into the archive with filters already applied.
- Secure single-property pages with image galleries, amenities, host info, blocked dates, reviews, wishlist, similar properties, and reservation request flow.
- A logged-in user dashboard for profile editing, OTP-based verification, payout details, traveller bookings, and host listings.
- An admin panel for plugin documentation, reservation management, and database repair for LEF-owned tables.
- Email notifications for OTP verification, reservation requests, and profile-update success messages.

---

## Who this plugin is for

### Site owner / admin

- Add listing pages and detail pages with shortcodes.
- Review and update reservation statuses.
- Repair the plugin's reservation, review, and wishlist tables from the WordPress admin.

### Traveller / end user

- Browse properties.
- Search by location, dates, and guests.
- Save properties to wishlist.
- Submit reservation requests.
- Review completed stays.
- Manage bookings from the profile dashboard.

### Host

- Manage own listings from the profile dashboard.
- Create, edit, duplicate, delete, and status-manage hosted properties.
- Store payout details.

### Developer

- Customize templates, AJAX endpoints, email templates, CSS, and JS without a frontend build step.
- Extend WordPress shortcodes and profile modules.
- Integrate the plugin with a companion listing-management system.

---

## Repository structure

This repository currently ships in two copies:

- `production-version/` - readable source version intended for active development and maintenance.
- `minify-version/` - distribution copy intended for packaged deployment.

The documentation in this README applies to both copies unless you intentionally maintain them differently.

---

## Shortcodes

### 1. `[listing_engine_view]`

Use this shortcode to render the main listing archive page.

It provides:

- full property listing grid
- URL-driven filtering
- guest count filtering
- date-based blocked property filtering
- amenity filtering
- price filtering
- sorting
- wishlist toggling

Typical usage:

```text
[listing_engine_view]
```

Recommended page:

- Your main "All Properties" or "Listing Archive" page

Supported URL filters for developers:

| Parameter   | Description              |
|-------------|--------------------------|
| `location`  | Filter by location        |
| `address`  | Filter by address        |
| `type`      | Filter by property type  |
| `guests`    | Filter by guest count     |
| `checkin`   | Filter by check-in date   |
| `checkout`  | Filter by check-out date |
| `amenities` | Filter by amenities     |
| `min-price`  | Minimum price filter    |
| `max-price`  | Maximum price filter   |
| `sort`      | Sort results            |

Example archive URL:

```text
/listing-archive/?location=Goa&guests=4&checkin=2026-05-01&checkout=2026-05-05&sort=price_low_to_high
```

---

### 2. `[selected_list_view]`

Use this shortcode to show a curated subset of properties in either grid or carousel format.

It is ideal for:

- homepage sections
- city landing pages
- featured categories
- destination highlights

Basic usage:

```text
[selected_list_view count="6"]
```

Examples:

```text
[selected_list_view count="6"]
[selected_list_view view="carousel" location="Goa"]
[selected_list_view view="grid" location="Mumbai" type="Villa"]
```

Supported attributes:

| Attribute  | Type     | Default | Purpose                      |
|------------|----------|---------|-------------------------------|
| `count`    | integer  | `9`    | Number of properties to show |
| `view`     | string   | `grid` | `grid` or `carousel`         |
| `location` | string   | empty  | Filter by location name      |
| `type`     | string   | empty  | Filter by property type      |

Behavior notes:

- Adds a "See all" card when more properties exist than the current `count`.
- The "See all" card routes users to the main listing archive page with the same filters applied.

---

### 3. `[premium_search_bar]`

Use this shortcode to render a standalone search bar. It is designed for hero sections and top-of-page search sections.

It provides:

- location suggestions
- date range selection
- guest count selection
- mobile and desktop search UI
- redirect into the archive page with applied filters

Usage:

```text
[premium_search_bar]
```

Recommended page:

- homepage hero
- top banner section
- dedicated search landing page

---

### 4. `[single_property_view]`

Use this shortcode on the dedicated property detail page.

It provides:

- image gallery
- description
- amenities
- host details
- blocked-date aware availability logic
- review listing
- review submission eligibility checks
- wishlist toggle
- similar properties
- reservation request form

Usage:

```text
[single_property_view]
```

Important routing note:

- This shortcode does not take a manual property ID attribute.
- The plugin resolves the property from the URL parameter `property_ref`.
- `property_ref` is generated internally through `lef_get_secure_detail_url()`.
- If `property_ref` is missing or invalid, the user is redirected away from the page.

---

### 5. `[lef_my_profile]`

Use this shortcode to render the logged-in user dashboard.

It provides:

- Edit Profile
- OTP-based verification for sensitive profile changes
- Payout Details
- My Bookings
- My Listings

Usage:

```text
[lef_my_profile]
```

Important behavior:

- Guests see a login-required message.
- `administrator` and `host` users can access `Payout` and `My Listings`.
- `traveller` users can access `My Bookings`.

---

## Main feature breakdown

### Property archive experience

- Reads published properties from listing tables.
- Filters by location, address, type, price, amenities, guests, and availability.
- Shows wishlist state for logged-in users.
- Generates secure detail page links.

### Search experience

- Search suggestions are fetched through WordPress AJAX.
- When browser GPS coordinates are available, reverse geocoding is attempted through OpenStreetMap Nominatim to improve nearby suggestions.
- Search submits users to the archive page with query parameters.

### Single property experience

- Fetches property, host, images, amenities, blocked dates, reviews, and wishlist state.
- Only logged-in users can submit reservations.
- Only users with completed reservations can submit or edit reviews.
- Reservation requests create records and trigger email notifications.

### Profile dashboard

- `Edit Profile`: profile image upload, email/mobile validation, password change, OTP verification.
- `Payout`: stores bank and UPI details in user meta.
- `My Bookings`: travellers and admins can browse reservations with filters and pagination.
- `My Listings`: hosts can create, edit, duplicate, delete, and status-manage their own properties.

### Admin dashboard

- `LEF > Dashboard`: quick links and shortcode reference.
- `LEF > Database`: create/repair LEF-owned tables.
- `LEF > Manage Reserv`: browse reservation requests and update status.

---

## Technologies and libraries used

### WordPress core features

- Shortcode API
- AJAX API via `admin-ajax.php`
- User roles and user meta
- Media upload API
- `wp_mail()` email delivery
- `dbDelta()` for LEF-owned table repair
- Admin menu APIs

### Frontend / admin JS

- WordPress bundled `jQuery`
- Custom vanilla-style plugin scripts in `frontend/assets/js/` and `backend/assets/js/`

### Composer dependency

This plugin includes Composer support for phone-country data and phone validation:

- `giggsey/libphonenumber-for-php`

Installed transitively with it:

- `giggsey/locale`

Used for:

- country list generation
- country calling code lookup
- flag rendering
- phone-number validation during profile updates

### External service

- OpenStreetMap Nominatim reverse geocoding is used for search suggestions when latitude/longitude is provided.

### PHP extensions / environment expectations

Recommended:

- PHP CLI available on the machine if you want to run Composer
- `mbstring` enabled
- standard JSON support enabled
- working WordPress mail configuration if you want OTP and reservation emails to send successfully

---

## No Node or build pipeline required

This plugin does not require:

- Node.js
- npm
- Vite
- Webpack
- Sass compilation

The plugin runs directly with PHP, WordPress, CSS, and browser-side JS. After editing PHP, CSS, or JS files, you can test immediately in WordPress.

---

## Database overview

### Tables created / repaired by this plugin

These are the LEF-owned tables exposed in `LEF > Database`:

| Table              | Purpose                |
|--------------------|-----------------------|
| `wp_ls_reservation` | reservation requests |
| `wp_ls_reviews`     | review records        |
| `wp_ls_wishlist`    | wishlist entries     |

### Tables expected from the companion listing engine / existing project

This plugin also expects the following tables to already exist in the wider system:

| Table                    | Purpose                           |
|--------------------------|-----------------------------------|
| `wp_ls_property`         | property records                  |
| `wp_ls_img`              | property images                   |
| `wp_ls_location`        | location data                     |
| `wp_ls_types`           | property types                    |
| `wp_ls_amenities`       | amenities data                   |
| `wp_ls_block_date`     | blocked dates                    |
| `wp_admin_management`   | route/page mapping               |
| `wp_authme_otp_storage` | OTP storage                      |

Important note:

- This plugin is not fully standalone.
- It depends on an existing listing-management data model for properties, images, locations, types, amenities, blocked dates, and route/page mapping.
- If those tables are missing, the frontend can load but listing data, routing, OTP verification, or profile features will not work correctly.

---

## Required page and route mapping

The plugin reads some routing/page information from `wp_admin_management`.

Recommended entries:

| Name               | What it should point to                               |
|--------------------|----------------------------------------------------|
| `Listing Archive`   | The page that contains `[listing_engine_view]`        |
| `Listing Single View` | The page that contains `[single_property_view]` |
| `Logout` / `logout` | Optional logout mapping if your project uses DB-driven logout routing |

Notes:

- The search bar and selected list sections use `Listing Archive`.
- Secure property URLs use `Listing Single View`.
- The profile screen falls back to `wp_logout_url()` if no custom logout mapping is available.

---

## Installation and setup

### Step 1. Choose the plugin copy

Use one of the following:

- `production-version/` for active development and readable source code
- `minify-version/` if you maintain a lighter distribution copy

### Step 2. Place the plugin in WordPress

Copy the chosen folder into:

```text
wp-content/plugins/
```

Example final path:

```text
wp-content/plugins/listing-engine-frontend/
```

Make sure the plugin root contains:

- `listing-engine-frontend.php`
- `includes/`
- `frontend/`
- `backend/`
- `global-assets/`
- `mails/`
- `composer.json`
- `vendor/` or a plan to run `composer install`

### Step 3. Install PHP Composer if needed

If `vendor/` is already present and correct, you may not need to run Composer immediately. If you are setting up from a clean copy, updating dependencies, or rebuilding `vendor/`, install Composer first.

Official Composer docs:

- [Introduction](https://getcomposer.org/doc/00-intro.md)
- [Download / install page](https://getcomposer.org/download/)

#### macOS / Linux

Prerequisite:

- `php -v` should work in Terminal

Typical Composer installation flow from the official docs:

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

If `/usr/local/bin` does not exist on your system:

```bash
sudo mkdir -p /usr/local/bin
sudo mv composer.phar /usr/local/bin/composer
```

Verify:

```bash
composer --version
```

Tip:

- Composer's installer checksum changes over time, so for the most current verified install snippet, always prefer the official download page linked above.

#### Windows

Prerequisites:

- PHP must be installed and available to the installer. Common local environments include XAMPP, WAMP, Laragon, LocalWP, or a standalone PHP install.

Official easy method:

1. Download `Composer-Setup.exe` from [getcomposer.org](https://getcomposer.org/download/).
2. Run the installer.
3. When prompted, point it to your `php.exe` if it is not auto-detected.
4. Finish the setup.
5. Close the current Command Prompt / PowerShell window.
6. Open a new terminal and run:

```powershell
composer --version
```

If `composer` is not recognized:

- reopen the terminal
- verify that PHP is installed
- verify that Composer was added to PATH during installation

### Step 4. Install plugin dependencies

From the plugin root:

```bash
cd wp-content/plugins/listing-engine-frontend
composer install
```

If you are using a local-only Composer PHAR instead of global Composer:

```bash
php composer.phar install
```

What this does:

- installs the PHP dependency
- creates or refreshes the `vendor/` directory
- makes `vendor/autoload.php` available for phone utilities

### Step 5. Activate the plugin

In WordPress admin:

1. Go to `Plugins`
2. Activate `Listing Engine Frontend`

After activation, the admin menu `LEF` should appear.

### Step 6. Create the required WordPress pages

Recommended pages:

| Page purpose            | Shortcode                                      |
|-------------------------|-----------------------------------------------|
| Listing Archive         | `[listing_engine_view]`                      |
| Property Detail        | `[single_property_view]`                    |
| Profile Dashboard     | `[lef_my_profile]`                          |
| Optional homepage section | `[premium_search_bar]` and/or `[selected_list_view]` |

### Step 7. Configure page mapping records

In your `wp_admin_management` table, ensure route/page records exist for:

- `Listing Archive`
- `Listing Single View`
- optional logout route entries used by your wider system

Without these records:

- archive redirects may fall back incorrectly
- secure single-property URLs may fail
- search bar routing may not point to the correct page

### Step 8. Create or repair LEF tables

Go to:

```text
WordPress Admin > LEF > Database
```

For each LEF-owned table:

- click `Refresh` to inspect current status
- click `Create / Repair` if the table is missing or incomplete

This handles:

- reservation table
- reviews table
- wishlist table

### Step 9. Confirm the companion system exists

Before going live, verify that your wider listing system already has:

- property records
- property images
- location/type/amenity data
- block-date data
- `wp_admin_management`
- `wp_authme_otp_storage`

If not, some screens will render but actual data operations will fail.

### Step 10. Confirm WordPress email works

This plugin uses `wp_mail()` for:

- OTP emails
- reservation request emails
- profile update success emails

If email is not configured on the server, OTP and reservation notifications will fail even if the UI loads correctly.

---

## Recommended setup checklist

Before handing the plugin to content editors or clients, confirm:

- [ ] Composer dependency is installed and `vendor/` exists.
- [ ] The `LEF` admin menu is visible.
- [ ] `LEF > Database` reports healthy tables.
- [ ] Archive page loads listings.
- [ ] Search bar redirects to the archive page.
- [ ] Property cards open the detail page through secure URLs.
- [ ] Wishlist works for logged-in users.
- [ ] Reservation requests are saved and emails send.
- [ ] Profile screen loads for logged-in users.
- [ ] Country dropdown appears in Edit Profile.
- [ ] OTP emails send and profile verification works.
- [ ] Hosts can open `My Listings`.
- [ ] Travellers can open `My Bookings`.
- [ ] Admins can manage reservations from `LEF > Manage Reserv`.

---

## Developer guide

### Important files and folders

| Path                               | Responsibility                                              |
|-------------------------------------|-------------------------------------------------------------|
| `listing-engine-frontend.php`       | Main plugin bootstrap                                      |
| `includes/shortcode-handler.php`    | Registers and renders shortcodes                           |
| `includes/url-router.php`           | Builds secure property detail URLs and decodes `property_ref` |
| `includes/assets-loader.php`         | Enqueues frontend/admin CSS and JS                        |
| `includes/ajax-handler.php`        | Main AJAX controller for search, reservations, profile, reviews, listings, and bookings |
| `includes/helpers.php`               | Shared helpers and Composer-backed phone utilities         |
| `includes/db-schema.php`             | LEF-owned schema definitions                          |
| `includes/class-db-handler.php`     | DB status and repair logic                             |
| `frontend/template/`              | Frontend shortcode templates                          |
| `backend/template/`              | Admin screen templates                                |
| `mails/`                         | Email templates                                       |
| `global-assets/`                  | shared CSS/JS/UI components                          |

### How to customize frontend behavior

To customize markup:

- edit files in `frontend/template/`

To customize styles:

- edit files in `frontend/assets/css/`
- edit shared variables in `global-assets/css/global.css`

To customize interactivity:

- edit files in `frontend/assets/js/`

To customize admin UI:

- edit `backend/template/`
- edit `backend/assets/css/`
- edit `backend/assets/js/`

### How to add or change a shortcode

1. Register or update the shortcode in `includes/shortcode-handler.php`
2. Create or update the template in `frontend/template/`
3. Enqueue related assets in `includes/assets-loader.php`
4. Add AJAX handlers in `includes/ajax-handler.php` if needed

### How to add or change an AJAX feature

1. Add the PHP action handler in `includes/ajax-handler.php`
2. Register the `wp_ajax_...` hook
3. If guests need access, also add `wp_ajax_nopriv_...`
4. Localize required data or nonce in `includes/assets-loader.php`
5. Update the matching JS file

### How to update phone-country support

The profile screen uses Composer-loaded phone utilities. If country data or validation stops working:

```bash
composer install
```

If you intentionally upgrade the package:

```bash
composer update giggsey/libphonenumber-for-php
```

After upgrading, retest:

- country dropdown rendering
- phone validation
- OTP flow

### How image handling works

- Profile pictures are uploaded through the WordPress Media API.
- Property images are stored and edited through listing tables and AJAX handlers.
- This plugin expects listing images to exist in `wp_ls_img`.

### How email handling works

Email templates live in:

- `mails/otp-verify.php`
- `mails/email-reservation.php`
- `mails/update-success.php`

The plugin uses `wp_mail()` instead of a custom mail library.

---

## Important integration notes

- There is no activation hook that automatically creates every required table in the whole ecosystem.
- Only LEF-owned tables are managed by the plugin's Database screen.
- Core listing tables are expected to come from the wider listing engine / companion plugin.
- The OTP storage table is expected to exist already.
- The plugin relies heavily on `admin-ajax.php`, not custom REST endpoints.
- If `vendor/autoload.php` is missing, country list and phone validation features will degrade or fail.

---

## Common issues and fixes

### Property detail page redirects away immediately

Possible causes:

- `Listing Single View` page mapping is missing
- secure `property_ref` URL is missing or invalid
- property ID does not exist in `wp_ls_property`

### Search bar loads but does not redirect correctly

Possible causes:

- `Listing Archive` page mapping is missing in `wp_admin_management`
- archive page does not contain `[listing_engine_view]`

### Country dropdown is empty in Edit Profile

Possible causes:

- Composer dependencies were not installed
- `vendor/autoload.php` is missing
- `mbstring` is missing or PHP CLI environment is incomplete

Fix:

```bash
composer install
```

### OTP email is not received

Possible causes:

- WordPress mail is not configured
- `wp_authme_otp_storage` table is missing
- email delivery is blocked by the server

### Wishlist / reviews / bookings fail

Possible causes:

- LEF database tables were not created from `LEF > Database`
- companion listing tables are missing
- AJAX nonce or login state is invalid

### My Listings is empty for a host

Possible causes:

- no properties exist with matching `host_id`
- user does not have the expected `host` or `administrator` role

---

## Deployment note

If you deploy the plugin to another server and do not plan to run Composer there, make sure the `vendor/` directory is included in the deployed plugin package.

---

## Deployment instructions for production

If you need to make any changes or modifications to this plugin, always do so in the `production-version/` folder. This folder contains the readable source code intended for development and maintenance.

When you are ready to deploy:

1. Make your changes in `production-version/`
2. Sync all changes to `minify-version/` (this is the distribution copy)
3. Create a ZIP file of the `minify-version/` folder
4. Rename the ZIP file to `LEF-(VR)` (this naming convention ensures zero conflict with other plugins)
   - You may also use any custom name if preferred

The `minify-version/` folder should be kept clean and ready for deployment at all times.

---

## Summary

Use this plugin when you need the frontend and operational layer of a vacation-rental listing system inside WordPress:

- property browsing
- search
- secure detail pages
- wishlists
- reviews
- reservation requests
- traveller dashboard
- host listing management
- admin reservation handling

For best results, connect it to the companion listing engine data tables, install Composer dependencies, map the required pages, and verify email/OTP infrastructure before launch.

---

## Credits

**Developed by Art-Tech Fuzion** — https://arttechfuzion.com