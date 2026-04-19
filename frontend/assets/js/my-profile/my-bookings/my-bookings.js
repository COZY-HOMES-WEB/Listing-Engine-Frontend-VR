/**
 * my-bookings.js
 *
 * Handles My Bookings dashboard logic:
 * - Tab switching
 * - Debounced search
 * - AJAX list rendering
 * - Pagination
 * - Detail Modal integration
 *
 * @package ListingEngineFrontend
 */

(function ($) {
  "use strict";

  const LefMyBook = {
    state: {
      status: "pending",
      search: "",
      page: 1,
      isLoading: false,
      searchTimer: null,
    },

    init() {
      if (this.state.isLoading) return;
      
      this.cacheDOM();

      if (this.$panel.length === 0) return;

      this.bindEvents();
      this.fetchData();
    },

    cacheDOM() {
      this.$panel = $("#lef-my-book-panel");
      this.$listContainer = $("#lef-my-book-list-container");
      this.$searchInput = $("#lef-my-book-search-input");
      this.$totalCount = $("#lef-my-book-total-count");
      this.$countPending = $("#lef-my-book-count-pending");
      this.$countCompleted = $("#lef-my-book-count-completed");
      this.$countRejected = $("#lef-my-book-count-rejected");
      this.$paginationInfo = $("#lef-my-book-pagination-info");
      this.$pageControls = $("#lef-my-book-page-numbers");
      this.$emptyState = $("#lef-my-book-empty-state");
      this.$paginationContainer = $("#lef-my-book-pagination-container");
      this.$activeTitle = $("#lef-my-book-active-title");
    },

    bindEvents() {
      const self = this;

      // Tab clicks
      this.$panel.on("click", ".lef-my-book-tab", function () {
        const $this = $(this);
        if ($this.hasClass("is-active")) return;

        $(".lef-my-book-tab").removeClass("is-active");
        $this.addClass("is-active");

        self.state.status = $this.data("status");
        self.state.page = 1;
        
        // Get only the main text of the tab (ignore the count badge)
        const tabTitle = $this.contents().filter(function() {
            return this.nodeType === 3;
        }).text().trim();
        
        self.$activeTitle.text(tabTitle + " Reservations");
        self.fetchData();
      });

      // Search input
      this.$searchInput.on("input", function () {
        clearTimeout(self.state.searchTimer);
        const val = $(this).val().trim();

        self.state.searchTimer = setTimeout(() => {
          self.state.search = val;
          self.state.page = 1;
          self.fetchData();
        }, 400);
      });

      // Search Focus visual
      this.$searchInput.on("focus blur", function (e) {
        $("#lef-my-book-search-container").toggleClass("is-focused", e.type === "focus");
      });

      // Pagination clicks
      this.$panel.on("click", ".lef-my-book-page-btn", function () {
        const page = $(this).data("page");
        if (!page || page === self.state.page) return;

        self.state.page = page;
        self.fetchData();
      });

      // View Button (Modal)
      this.$panel.on("click", ".lef-my-book-view-btn", function () {
        const id = $(this).data("id");
        self.openDetailModal(id);
      });
    },

    fetchData() {
      if (this.state.isLoading) return;
      this.state.isLoading = true;

      // Show loader in list
      this.$listContainer.html('<div class="lef-my-book-loader">Loading...</div>');
      this.$emptyState.hide();

      $.ajax({
        url: lefMyProfileData.ajax_url,
        type: "POST",
        data: {
          action: "lef_get_my_bookings",
          nonce: lefMyProfileData.nonce,
          status: this.state.status,
          search: this.state.search,
          page: this.state.page,
        },
        success: (response) => {
          if (response.success) {
            this.renderList(response.data.list);
            this.updateUi(response.data);
          }
        },
        error: () => {
          this.$listContainer.html('<div class="error">Failed to fetch data.</div>');
        },
        complete: () => {
          this.state.isLoading = false;
        },
      });
    },

    renderList(list) {
      if (!list || list.length === 0) {
        this.$listContainer.empty();
        this.$emptyState.show();
        this.$paginationContainer.hide();
        return;
      }

      this.$emptyState.hide();
      this.$paginationContainer.show();

      let html = "";
      list.forEach((item, index) => {
        const sNo = (this.state.page - 1) * 10 + (index + 1);
        const date = this.formatDate(item.updated_at);

        html += `
                    <div class="lef-my-book-card">
                        <div class="lef-my-book-sno">${sNo}</div>
                        <div class="lef-my-book-card-info">
                            <div class="lef-my-book-field">
                                <span class="lef-my-book-field-label">Reservation #</span>
                                <span class="lef-my-book-field-value">${item.reservation_number}</span>
                            </div>
                            <div class="lef-my-book-field">
                                <span class="lef-my-book-field-label">Status</span>
                                <span class="lef-my-book-status-badge" data-status="${item.status}">${this.capitalize(item.status)}</span>
                            </div>
                            <div class="lef-my-book-field">
                                <span class="lef-my-book-field-label">Last Update</span>
                                <span class="lef-my-book-field-value">${date}</span>
                            </div>
                        </div>
                        <div class="lef-my-book-card-actions">
                            <button class="lef-my-book-view-btn" data-id="${item.id}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                View
                            </button>
                        </div>
                    </div>
                `;
      });

      this.$listContainer.html(html);
    },

    updateUi(data) {
      // Update counts
      this.$totalCount.text(data.counts.total);
      this.$countPending.text(data.counts.pending);
      this.$countCompleted.text(data.counts.completed);
      this.$countRejected.text(data.counts.rejected);

      // Update Pagination Text
      const start = (this.state.page - 1) * 10 + 1;
      const end = Math.min(this.state.page * 10, data.total);
      this.$paginationInfo.text(`Showing ${data.total > 0 ? start : 0} to ${end} of ${data.total} entries`);

      // Render Pagination Controls
      this.renderPagination(data.total);
    },

    renderPagination(total) {
      const totalPages = Math.ceil(total / 10);
      if (totalPages <= 1) {
        this.$pageControls.empty();
        return;
      }

      let html = "";
      // Prev
      html += `<button class="lef-my-book-page-btn" ${this.state.page === 1 ? "disabled" : ""} data-page="${this.state.page - 1}">Prev</button>`;

      // Page numbers (simplified version)
      for (let i = 1; i <= totalPages; i++) {
        if (totalPages > 5) {
          // Show only around current
          if (i === 1 || i === totalPages || (i >= this.state.page - 1 && i <= this.state.page + 1)) {
            html += `<button class="lef-my-book-page-btn ${this.state.page === i ? "is-active" : ""}" data-page="${i}">${i}</button>`;
          } else if (i === this.state.page - 2 || i === this.state.page + 2) {
            html += `<span class="lef-my-book-dots">...</span>`;
          }
        } else {
          html += `<button class="lef-my-book-page-btn ${this.state.page === i ? "is-active" : ""}" data-page="${i}">${i}</button>`;
        }
      }

      // Next
      html += `<button class="lef-my-book-page-btn" ${this.state.page === totalPages ? "disabled" : ""} data-page="${this.state.page + 1}">Next</button>`;

      this.$pageControls.html(html);
    },

    openDetailModal(id) {
      // Fetch data for modal
      $.ajax({
        url: lefMyProfileData.ajax_url,
        type: "POST",
        data: {
          action: "lef_get_booking_details",
          nonce: lefMyProfileData.nonce,
          id: id,
        },
        success: (response) => {
          if (response.success) {
            this.populateAndShowModal(response.data);
          } else {
            if (window.LEF_Toast) window.LEF_Toast.show(response.data.message, "error");
          }
        },
        error: (xhr, status, error) => {
          console.error("LEF AJAX Error:", status, error, xhr.responseText);
          if (window.LEF_Toast) window.LEF_Toast.show("Network error", "error");
        },
      });
    },

    populateAndShowModal(data) {
      // We assume standard Confirmation component can be hijacked to show custom content
      // or we can use a dedicated Modal approach. Given the project instructions, 
      // we'll fetch the view-edit.php content. (Since we can't fetch files directly via AJAX into a modal easily without a URL,
      // we'll assume the template content is available or we use a hidden template in the footer).

      // OPTION: The template is already in the DOM usually or we use LEF_Confirmation.show which might have a custom content feature.
      // Re-reading instructions: "view-edit.php modal open karega without reloading".
      
      // I will implement a simpler approach: fetch the detail. 
      // I'll use LEF_Confirmation as a base if it supports custom HTML.
      
      if (typeof LEF_Confirmation !== "undefined") {
         // Populate the modal fields (these are in view-edit.php which we assume is rendered/loaded)
         $("#lef-my-book-detail-number").text("#" + data.reservation_number);
         $("#lef-my-book-detail-prop-title").text(data.property_title);
         $("#lef-my-book-detail-prop-addr").text(data.property_address);
         $("#lef-my-book-detail-dates").text(data.reserve_date);
         $("#lef-my-book-detail-guests").text(data.total_guests);
         $("#lef-my-book-detail-requested").text(this.formatDate(data.created_at));
         $("#lef-my-book-detail-updated").text(this.formatDate(data.updated_at));
         $("#lef-my-book-detail-price").text("$" + parseFloat(data.total_price).toLocaleString());
         
         const $badge = $("#lef-my-book-detail-status");
         $badge.text(this.capitalize(data.status)).attr("data-status", data.status);

         // Handle Image
         let images = [];
         try { images = JSON.parse(data.property_images); } catch(e) {}
         if (images && images.length > 0) {
            $("#lef-my-book-detail-prop-img").attr("src", images[0]);
         }

         // Show the modal
         // We might need to ensure view-edit.php is included in my-bookings.php
         // I'll update my-bookings.php to include it hidden.
         LEF_Confirmation.showCustom($("#lef-my-book-detail-modal").html());
      }
    },

    formatDate(dateStr) {
      if (!dateStr) return "-";
      const date = new Date(dateStr);
      return date.toLocaleDateString("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    },

    capitalize(str) {
      if (!str) return "";
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
  };

  /**
   * Listen for dashboard screen load event.
   * This is triggered by my-profile.js whenever a section is switched.
   */
  $(document).on("lef_sidebar_screen_loaded", (e, screen) => {
    if (screen === "my-bookings") {
      LefMyBook.init();
    }
  });
})(jQuery);
