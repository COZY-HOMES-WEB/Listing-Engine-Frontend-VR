
**Plugin Meta Information:**
- Plugin Name: Listing Engine Frontend
- Plugin URI: https://arttechfuzion.com
- Author: Art-Tech Fuzion

---

**Objective:**
Develop a WordPress plugin that replicates the `list-view.html` template (located in `/screen` folder) via a shortcode. The plugin must display property listings with dynamic data fetched from custom database tables, follow strict styling guidelines, and implement proper asset management with future-ready URL routing.

---

**Core Requirements:**

### 1. Styling & Design Guidelines
- Use **only** colors defined in `global-assets/css/global.css` — no inline CSS, no hardcoded hex/rgba values.
- Set `font-family: inherit;` to respect the active WordPress theme's typography.
- All UI components must be styled via external CSS files only.

### 2. File Structure & Asset Management
- Maintain a modular, separated file structure (HTML templates, CSS, JS, PHP logic in distinct files/folders).
- Create `includes/assets-loader.php` to:
  - Define all asset paths (CSS/JS)
  - Conditionally load assets only on pages where the shortcode is used
  - Prevent unnecessary global asset loading
- Implement a basic URL routing system (`includes/url-router.php`) for future scalability (e.g., pretty permalinks for property details).

### 3. Shortcode Functionality
- Create a shortcode `[listing_engine_view]` that renders the property listing template anywhere on the site.
- On clicking a property card, redirect to a dynamic detail page with the property ID passed securely (obfuscated/hidden in URL, not plain query param).

### 4. Detail Page Redirection Logic
- Before redirecting, query the `wp_admin_management` table:
  - Check if an entry exists where `name = 'Listing Single View'`
  - If **not found**: Trigger a global toaster message: "Page not found"
  - If **found**: Extract the `page_id`, redirect to that page, and append the property ID in a hidden/encoded format (e.g., base64 or hash fragment)

### 5. Data Fetching & Display Logic (Per Property Card)

**Source Table:** `wp_ls_listings`

#### A. Image Gallery
- Query `wp_ls_img` table using `wp_ls_listings.id`
- Decode the JSON stored in the `image` column to extract: `id`, `url`, `sort_order`
- Display images sorted ascending by `sort_order` (0 = cover image, displayed first)
- Use the `url` field to construct the full image path

#### B. Title Format: `{type} in {location}`
- Fetch `type` value from `wp_ls_listings.type`
- Join with `wp_ls_types` table on `id` → get `name` column for display
- Fetch `location` ID from `wp_ls_listings.location`
- Join with `wp_ls_locations` table on `id` → get `name` column for display
- Render final title as: `[Type Name] in [Location Name]`

#### C. Subtitle/Summary: `"X bedroom, Y bed"`
- Fetch `bedroom` and `bed` values directly from `wp_ls_listings`
- Format and display as: `"{bedroom} bedroom, {bed} bed"` (e.g., "1 bedroom, 1 bed")

#### D. Price Display
- Fetch `price` from `wp_ls_listings`
- Display format: `"{price}/night"` (e.g., "₹2,500/night")

### 6. Dynamic Page Header Logic
- If URL has **no parameters**: Display static title → `"Premium Property"`
- If URL **contains parameters** (e.g., location filter):
  - Extract location from query params
  - Count total listings for that location from `wp_ls_listings`
  - Display dynamic title: `"Over {count} homes in {location}"`  
  *(Example: "Over 1,000 homes in Noida")*

### 7. Wishlist Icon (Placeholder)
- Include a heart SVG icon in each property card for future wishlist functionality
- No backend logic required now — static icon only

### 8. Global UI Components (Reusable)
Create in `global-assets/`:

#### A. Toaster Notification
- **CSS**: `global-assets/css/toaster.css`
- **JS**: `global-assets/js/toaster.js`
- **Template**: `global-assets/templates/toaster.html`
- Features:
  - Accepts dynamic message input
  - Auto-dismiss after 2 seconds
  - Consistent styling via global.css variables

#### B. Confirmation Modal
- **CSS**: `global-assets/css/confirmation.css`
- **JS**: `global-assets/js/confirmation.js`
- **Template**: `global-assets/templates/confirmation.html`
- Features:
  - Displays custom message
  - Two buttons: "Yes" (returns `true` + triggers callback) / "No" (returns `false` + closes modal)
  - Reusable JS API for integration

### 9. Code Quality Standards
- All files must be properly linked with absolute/relative paths defined centrally in `assets-loader.php`
- Add clear, concise comments in PHP/JS explaining:
  - Purpose of each function/block
  - Database query logic
  - Data transformation steps
- Ensure code is "crystal clear" — readable, maintainable, and well-organized
- No console.logs or debug code in production build

---

**Deliverables Checklist:**
✅ Shortcode `[listing_engine_view]` rendering dynamic property cards  
✅ Click-to-detail flow with DB validation & secure redirect  
✅ Image gallery with JSON decode + sort_order logic  
✅ Dynamic title/subtitle/price formatting with table joins  
✅ Conditional page header ("Over X homes in Y")  
✅ Placeholder heart icon (SVG)  
✅ Global toaster & confirmation components (CSS/JS/Template)  
✅ Strict adherence to global.css styling (no inline/rgba)  
✅ Modular file structure with asset-loader.php  
✅ URL routing scaffold for future use  
✅ Comprehensive inline documentation  

---

Bhai, yeh prompt ab ekdum professional aur developer-friendly hai. Isme har requirement clearly define hai, logical flow maintain kiya gaya hai, aur future scalability ka bhi dhyaan rakha gaya hai. Aap isse directly kisi developer ko assign kar sakte ho ya AI se code generate karwa sakte ho. 

Agar koi specific section ko aur detail mein chahiye ho toh bata dena, main refine kar dunga! 🚀