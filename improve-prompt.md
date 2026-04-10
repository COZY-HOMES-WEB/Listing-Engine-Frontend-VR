# **COMPREHENSIVE WORDPRESS SHORTCODE DEVELOPMENT PROMPT**


**IMPORTANT:** Before writing any code, you MUST read and analyze the existing `selected-list-view.html` file located in the `/screens/` folder. This file contains the UI reference design showing TWO distinct view layouts:
- **Grid View Layout**
- **Carousel View Layout**

Study both designs carefully and replicate their visual structure in your PHP implementation while making them dynamically functional.

---

## **🎯 CORE FUNCTIONALITY SPECIFICATIONS**

### **1. SHORTCODE REGISTRATION**

Register a WordPress shortcode named: **`selected_list_view`** Main listing table name is `wp_ls_listings`

This shortcode must accept the following attributes with their specifications:

#### **Attribute: `view` (Optional)**
- **Purpose:** Determines which layout format to use for displaying listings
- **Accepted Values:**
  - `"carousel"` - Displays items in a sliding carousel/slider format
- **Default Value:** `"grid"` (If this attribute is omitted, always default to grid view)
- **Example Usage:**
  ```
  [selected_list_view]                    // Shows Grid View (default)
  [selected_list_view view="carousel"]    // Shows Carousel View
  ```

#### **Attribute: `count` (Optional)**
- **Purpose:** Controls the maximum number of listing items to display
- **Data Type:** Integer
- **Default Value:** `10` (If attribute is omitted, show exactly 10 items)
- **Validation:** Must be a positive integer; if invalid input provided, fall back to default
- **Example Usage:**
  ```
  [selected_list_view count="5"]          // Shows 5 items
  [selected_list_view count="20"]         // Shows 20 items
  [selected_list_view]                    // Shows 10 items (default)
  ```

#### **Attribute: `location` (Optional)**
- **Purpose:** Filter listings by geographic location
- **Data Type:** String (location name/slug)
- **Database Logic:** 
  1. Query the `wp_ls_location` table
  2. Match the provided value against the `name` column (case-insensitive match recommended)
  3. Retrieve the matching row's ID
  4. Use this ID to filter the main listings table
- **Example Usage:**
  ```
  [selected_list_view location="New York"]
  [selected_list_view location="los angeles"]
  ```

#### **Attribute: `type` (Optional)**
- **Purpose:** Filter listings by property/listing type (e.g., "home", "apartment", "office", etc.)
- **Data Type:** String (type name/slug)
- **Database Logic:**
  1. Query the `wp_ls_types` table
  2. Match the provided value against the `name` column (case-insensitive match recommended)
  3. Retrieve the matching row's ID
  4. Use this ID to filter the main listings table
- **Example Usage:**
  ```
  [selected_list_view type="home"]
  [selected_list_view type="apartment"]
  [selected_list_view type="commercial"]
  ```

### **2. COMPLETE SHORTCODE USAGE EXAMPLES**

Here are all possible combinations of the shortcode:

```markdown
// BASIC USAGE (No Parameters)
[selected_list_view]
→ Result: Grid view displaying 10 latest listings

// VIEW SELECTION ONLY
[selected_list_view view="carousel"]
→ Result: Carousel view displaying 10 latest listings

// WITH COUNT PARAMETER
[selected_list_view view="carousel" count="5"]
→ Result: carousel view displaying 5 latest listings

// WITH LOCATION FILTER
[selected_list_view view="carousel" count="10" location="new york"]
→ Result: carousel view showing 10 listings from New York

// WITH TYPE FILTER
[selected_list_view view="carousel" count="15" type="apartment"]
→ Result: carousel view showing 15 apartment-type listings

// COMBINED LOCATION + TYPE FILTER
[selected_list_view view="carousel" count="10" location="new york" type="home"]
→ Result: carousel view showing 10 home-type listings in New York
```

---

## **💾 DATABASE ARCHITECTURE & QUERY LOGIC**

### **Database Tables Involved:**

#### **Table 1: `wp_ls_location`**
- **Purpose:** Stores location/area information
- **Columns Used:**
  - `id` (Primary Key) - Unique identifier for each location
  - `name` - Location name (e.g., "New York", "London", "Mumbai")

#### **Table 2: `wp_ls_types`**
- **Purpose:** Stores listing type categories
- **Columns Used:**
  - `id` (Primary Key) - Unique identifier for each type
  - `name` - Type name (e.g., "Home", "Apartment", "Office", "Commercial")

#### **Table 3: `wp_ls_listings` (Main Listings Table)**
- **Purpose:** Contains all listing data
- **Columns Used:**
  - `id` (Primary Key)
  - `title` - Listing title/name
  - `location` (Foreign Key) - References `wp_ls_location.id`
  - `type` (Foreign Key) - References `wp_ls_types.id`
  - *Other columns as needed for display (image, price, description, etc.)*

#### **Table 4: `wp_admin_management`**
- **Purpose:** Stores admin configuration settings
- **Columns Used:**
  - `name` - Setting identifier/key
  - `page_id` - Associated WordPress page ID value

### **Query Execution Flow:**

```
START
  │
  ├─▶ Check if 'location' parameter exists?
  │     │
  │     ├─ YES → Query wp_ls_location WHERE name = [location_value]
  │     │        └─ Get location_id
  │     │
  │     └─ NO → Skip location filter
  │
  ├─▶ Check if 'type' parameter exists?
  │     │
  │     ├─ YES → Query wp_ls_types WHERE name = [type_value]
  │     │        └─ Get type_id
  │     │
  │     └─ NO → Skip type filter
  │
  ├─▶ Build Main Query for wp_ls_listings:
  │     │
  │     ├─ BASE: SELECT * FROM wp_ls_listings
  │     │
  │     ├─ IF location_id EXISTS:
  │     │     ADD: WHERE location = [location_id]
  │     │
  │     ├─ IF type_id EXISTS:
  │     │     ADD: AND/OR type = [type_id]
  │     │
  │     ├─ ORDER BY: id DESC (Latest first) or date column if available
  │     │
  │     └─ LIMIT: [count_value] (Default: 10)
  │
  └─▶ Return Results Array
```

**Important Query Scenarios:**

| Scenario | Location Param | Type Param | Query Behavior |
|----------|---------------|------------|----------------|
| No Filters | ❌ | ❌ | Show latest 10 listings (no WHERE clause) |
| Location Only | ✅ | ❌ | Filter by location_id only |
| Type Only | ❌ | ✅ | Filter by type_id only |
| Both Filters | ✅ | ✅ | Filter by both location_id AND type_id |

---


### **"SEE ALL" CARD COMPONENT**

**CRITICAL REQUIREMENT:** At the end of EVERY listing display (both grid and carousel), append a special "See All" card/button component.

**See All Card Behavior Based on Parameters:**

#### **Scenario A: No Shortcode Parameters Provided**
When shortcode is used without filters: `[selected_list_view]` or `[selected_list_view view="carousel"]`

**Database Action:**
```sql
SELECT page_id 
FROM wp_admin_management 
WHERE name = 'Listing Archive'
LIMIT 1;
```

**Card Functionality:**
- Displays "See All Listings" or similar CTA text
- Links to the retrieved `page_id`
- Redirects user to the general archive/listing page
- Card design should be visually distinct (outline style or different background)

#### **Scenario B: With Filter Parameters Present**
When shortcode includes `location`, `type`, or both: `[selected_list_view location="new york" type="home"]`

**Card Functionality:**
- Displays "See All [Type] in [Location]" dynamic text
- Constructs URL with query parameters preserving current filters
- Redirect pattern: `{archive_page_url}?location={value}&type={value}`
- Example: `https://website.com/listings/?location=new+york&type=home`
- URL encoding must be applied to parameter values (spaces become '+')

**URL Construction Logic:**
```
Base URL: https://example.com/{page_slug}/ (from wp_admin_management)

Query Parameters:
- If location param exists: ?location={url_encoded_location}
- If type param exists: &type={url_encoded_type} (append with &)

Final URL Example:
https://example.com/listings/?location=new+york&type=home
```

**See All Card Visual Design:**
- Positioned as the last item in grid/carousel
- Centered text/icon layout
- Arrow icon indicating external navigation
- Hover effect suggesting clickability
- Consistent height with other cards (grid) or slightly different (carousel emphasis)

---



**Code Quality Requirements:**
- Use WordPress coding standards
- Implement proper data sanitization (sanitize_text_field, absint, etc.)
- Prepare all SQL statements properly ($wpdb->prepare())
- Add PHPDoc comments to all functions
- Use meaningful variable names
- Implement error handling (try-catch where appropriate)
- Return empty state message if no listings found

---



## **✅ IMPLEMENTATION CHECKLIST**

Before completing the task, ensure ALL of the following are implemented:

### **Functionality Checklist:**
- [ ] Shortcode `[selected_list_view]` registered and working
- [ ] Grid view renders correctly with proper responsive behavior
- [ ] Carousel view renders correctly with navigation controls
- [ ] `count` attribute limits displayed items (default: 10)
- [ ] `location` attribute filters by wp_ls_location table
- [ ] `type` attribute filters by wp_ls_types table
- [ ] Combined filters work together (AND logic)
- [ ] No-parameter scenario shows latest listings
- [ ] See All card appears at the end of every listing set
- [ ] See All card links to correct archive page (from wp_admin_management)
- [ ] See All card preserves filter parameters in URL when filters are active
- [ ] Database queries use prepared statements (security)
- [ ] All inputs are sanitized


### **Code Quality Checklist:**
- [ ] PHP file properly structured with sections
- [ ] Comprehensive comments throughout code
- [ ] WordPress coding standards followed
- [ ] CSS organized with clear section comments
- [ ] JavaScript modular and well-documented
- [ ] No hardcoded values (use constants/variables)
- [ ] Error handling implemented
- [ ] Files enqueued properly (not hardcoded script tags)

---

## **🔒 SECURITY & BEST PRACTICES**

1. **SQL Injection Prevention:**
   - Always use `$wpdb->prepare()` for database queries
   - Never concatenate user input directly into SQL

2. **XSS Prevention:**
   - Sanitize output with `esc_html()`, `esc_attr()`, `esc_url()`
   - Use `wp_kses()` for allowed HTML in output

3. **Input Validation:**
   - Validate `count` is integer before using in LIMIT clause
   - Sanitize `location` and `type` strings before DB lookup

4. **Performance:**
   - Implement caching if possible (transient API)
   - Optimize images (use WordPress image functions)
   - Minimize DOM queries in JavaScript

5. **Accessibility:**
   - Semantic HTML elements
   - ARIA labels on interactive elements
   - Keyboard navigation support
   - Sufficient color contrast ratios

---

## **📝 DELIVERABLES SUMMARY**

You must produce these **four files**, fully functional and production-ready:

1. **`selected-list-view.php`** - Complete shortcode implementation with:
   - Shortcode registration
   - Database query functions
   - HTML generation for both views
   - Asset enqueueing
   - Comprehensive documentation/comments

2. **`selected-list-view.css`** - Complete stylesheet with:
   - Grid view styles
   - Carousel view styles
   - Card components
   - See All card styles
   - Responsive design
   - Animations/transitions

3. **`selected-list-view.js`** - Complete JavaScript with:
   - Carousel functionality
   - Event handling
   - Touch/swipe support
   - Accessibility features
   - Clean, documented code

4. **Documentation/Comments** within all files explaining:
   - How to use the shortcode
   - Available parameters
   - Database structure requirements
   - Customization options

---

---

## **❓ ADDITIONAL NOTES & CLARIFICATIONS**

- **WordPress Globals:** You'll need access to `$wpdb` for database operations
- **Image Handling:** Use WordPress functions like `get_the_post_thumbnail()` or equivalent custom field retrieval
- **URL Generation:** Use `get_permalink()` or `home_url()` for generating URLs, never hardcode domains
- **Namespace Prefix:** Consider using `slv_` (Selected List View) prefix for all CSS classes and JS functions to avoid conflicts
- **Backward Compatibility:** Ensure the shortcode works even if only some attributes are provided
- **Error Gracefulness:** If database tables don't exist or queries fail, display user-friendly error messages (consider wp_debug mode checks)
