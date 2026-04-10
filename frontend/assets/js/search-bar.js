(function($) {
    'use strict';

    const SearchBar = {
        state: {
            location: '',
            checkin: '',
            checkout: '',
            guests: {
                adults: 1,
                children: 0,
                infants: 0
            },
            activeSection: null,
            currentMonth: new Date(),
            selectedRange: { start: null, end: null }
        },

        init: function() {
            this.cacheDOM();
            this.bindEvents();
            this.renderCalendar();
            this.updateDisplay();
        },

        cacheDOM: function() {
            this.$container = $('#lefSearchBar');
            
            // Triggers/Fields
            this.$locationTrigger = $('#locationTrigger');
            this.$checkinTrigger = $('#checkinTrigger');
            this.$checkoutTrigger = $('#checkoutTrigger');
            this.$guestsTrigger = $('#guestsTrigger');
            
            // Inputs
            this.$locationInput = $('#locationInput');
            this.$displayCheckin = $('#displayCheckin');
            this.$displayCheckout = $('#displayCheckout');
            this.$displayGuests = $('#displayGuests');

            // Clear Buttons
            this.$clearLocation = $('#clearLocation');
            this.$clearCheckin = $('#clearCheckin');
            this.$clearCheckout = $('#clearCheckout');
            this.$clearGuests = $('#clearGuests');
            
            // Popups
            this.$popup = $('#searchPopup');
            this.$popupSections = $('.popup-section');
            this.$suggestionsList = $('#suggestionsList');
            
            // Mobile
            this.$mobileTrigger = $('#mobileSearchTrigger');
            this.$mobileModal = $('#mobileModal');
            this.$mobileTabs = $('.mobile-tab');
            this.$mobileTabContents = $('.mobile-tab-content');
            this.$mobLocationInput = $('#mobLocationInput');
            this.$mobSuggestionsList = $('#mobSuggestionsList');

            this.$executeSearch = $('#executeSearch, #mobileExecuteSearch');
        },

        bindEvents: function() {
            const _this = this;

            // Location interaction
            this.$locationInput.on('focus input', function() {
                _this.openSection('location');
                const val = $(this).val();
                if (val.length === 0) _this.renderDefaultSuggestions();
                else _this.handleLocationSearch(val);
                _this.toggleClearBtn(_this.$clearLocation, val.length > 0);
            });

            // Date interaction
            this.$checkinTrigger.add(this.$checkoutTrigger).on('click', () => this.openSection('date'));
            
            // Guest interaction
            this.$guestsTrigger.on('click', () => this.openSection('guests'));

            // Clear functionality
            this.$clearLocation.on('click', (e) => {
                e.stopPropagation();
                this.state.location = '';
                this.$locationInput.val('').focus();
                this.renderDefaultSuggestions();
                this.toggleClearBtn(this.$clearLocation, false);
                this.updateDisplay();
            });

            this.$clearCheckin.add(this.$clearCheckout).on('click', (e) => {
                e.stopPropagation();
                this.state.selectedRange = { start: null, end: null };
                this.state.checkin = '';
                this.state.checkout = '';
                this.updateDisplay();
                this.renderCalendar();
                this.renderCalendar(true);
            });

            this.$clearGuests.on('click', (e) => {
                e.stopPropagation();
                this.state.guests = { adults: 1, children: 0, infants: 0 };
                this.updateDisplay();
            });

            // Outside click to close
            $(document).on('click', (e) => {
                if (!$(e.target).closest('#lefSearchBar, #searchPopup').length) {
                    this.closePopup();
                }
            });

            // Suggestions selection
            $(document).on('click', '.suggestion-item', function() {
                const val = $(this).data('value');
                _this.setLocation(val);
                if (!_this.$mobileModal.hasClass('active')) _this.closePopup();
            });

            // Guest Controls
            $('.guest-btn').on('click', function(e) {
                e.stopPropagation();
                const type = $(this).data('type');
                const guestType = $(this).data('guest-type');
                _this.updateGuests(guestType, type);
            });

            // Search execution
            this.$executeSearch.on('click', () => this.executeSearch());

            // Mobile logic
            this.$mobileTrigger.on('click', () => this.$mobileModal.addClass('active'));
            $('#closeMobileModal').on('click', () => this.$mobileModal.removeClass('active'));
            this.$mobileTabs.on('click', function() {
                const tab = $(this).data('tab');
                _this.$mobileTabs.removeClass('active');
                $(this).addClass('active');
                _this.$mobileTabContents.removeClass('active');
                $('#mob-' + tab).addClass('active');
            });

            this.$mobLocationInput.on('focus input', function() {
                const val = $(this).val();
                if (val.length === 0) _this.renderDefaultSuggestions(true);
                else _this.handleLocationSearch(val, true);
            });

            // Calendar Nav
            $('#prevMonth').on('click', () => { this.state.currentMonth.setMonth(this.state.currentMonth.getMonth() - 1); this.renderCalendar(); });
            $('#nextMonth').on('click', () => { this.state.currentMonth.setMonth(this.state.currentMonth.getMonth() + 1); this.renderCalendar(); });
            $('#mobPrevMonth').on('click', () => { this.state.currentMonth.setMonth(this.state.currentMonth.getMonth() - 1); this.renderCalendar(true); });
            $('#mobNextMonth').on('click', () => { this.state.currentMonth.setMonth(this.state.currentMonth.getMonth() + 1); this.renderCalendar(true); });

            $('#clearDatesPopup').on('click', () => {
                this.state.selectedRange = { start: null, end: null };
                this.state.checkin = '';
                this.state.checkout = '';
                this.updateDisplay();
                this.renderCalendar();
            });

            $('#applyDates').on('click', () => this.closePopup());

            $('#resetMobile').on('click', () => {
                this.state.location = '';
                this.state.checkin = '';
                this.state.checkout = '';
                this.state.guests = { adults: 1, children: 0, infants: 0 };
                this.updateDisplay();
                this.renderCalendar(true);
                this.$mobLocationInput.val('');
            });
        },

        openSection: function(section) {
            this.state.activeSection = section;
            this.$popup.addClass('active');
            this.$popupSections.removeClass('active');
            $('#' + section + 'Popup').addClass('active');
            this.positionPopup(section);
        },

        positionPopup: function(section) {
            const trigger = $('#' + section + 'Trigger');
            if (!trigger.length) return;
            const triggerRect = trigger[0].getBoundingClientRect();
            const containerRect = this.$container[0].getBoundingClientRect();
            
            // Align popup under the active field or center it
            let left = triggerRect.left - containerRect.left;
            const popupWidth = this.$popup.outerWidth();
            const maxLeft = containerRect.width - popupWidth;
            
            if (left > maxLeft) left = maxLeft;
            if (left < 0) left = 0;
            
            this.$popup.css({
                'left': left + 'px',
                'transform': 'none'
            });
        },

        closePopup: function() {
            this.state.activeSection = null;
            this.$popup.removeClass('active');
        },

        toggleClearBtn: function($btn, show) {
            $btn.css('display', show ? 'flex' : 'none');
        },

        renderDefaultSuggestions: function(isMobile = false) {
            const defaults = [
                { name: 'Mumbai, India', type: 'Popular' },
                { name: 'Goa, India', type: 'Beach' },
                { name: 'Jaipur, India', type: 'Heritage' },
                { name: 'Bangalore, India', type: 'City' }
            ];
            this.renderSuggestions(defaults, isMobile);
        },

        handleLocationSearch: function(query, isMobile = false) {
            $.post(lefSearchData.ajaxurl, {
                action: 'lef_search_suggestions',
                query: query,
                nonce: lefSearchData.nonce
            }, (response) => {
                if (response.success) this.renderSuggestions(response.data, isMobile);
            });
        },

        renderSuggestions: function(data, isMobile = false) {
            let html = '';
            data.forEach(item => {
                html += `
                    <div class="suggestion-item" data-value="${item.name}">
                        <div class="suggestion-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                        <div class="suggestion-text">
                            <strong>${item.name}</strong>
                            <span>${item.type}</span>
                        </div>
                    </div>
                `;
            });
            if (isMobile) this.$mobSuggestionsList.html(html);
            else this.$suggestionsList.html(html);
        },

        setLocation: function(val) {
            this.state.location = val;
            this.$locationInput.val(val);
            this.$mobLocationInput.val(val);
            $('#mobileDisplayLocation').text(val);
            this.toggleClearBtn(this.$clearLocation, true);
            this.updateDisplay();
        },

        updateGuests: function(guestType, action) {
            if (action === 'plus') this.state.guests[guestType]++;
            else if (this.state.guests[guestType] > (guestType === 'adults' ? 1 : 0)) this.state.guests[guestType]--;
            
            this.updateDisplay();
        },

        renderCalendar: function(isMobile = false) {
            const date = new Date(this.state.currentMonth);
            const month = date.getMonth();
            const year = date.getFullYear();
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            
            (isMobile ? $('#mobMonthYear') : $('#monthYear')).text(monthNames[month] + " " + year);
            
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date(); today.setHours(0,0,0,0);

            let html = '<div class="cal-day-header">Su</div><div class="cal-day-header">Mo</div><div class="cal-day-header">Tu</div><div class="cal-day-header">We</div><div class="cal-day-header">Th</div><div class="cal-day-header">Fr</div><div class="cal-day-header">Sa</div>';
            for (let i = 0; i < firstDay; i++) html += '<div class="cal-day empty"></div>';
            
            for (let i = 1; i <= daysInMonth; i++) {
                const current = new Date(year, month, i);
                let classes = 'cal-day';
                if (current < today) classes += ' disabled';
                const time = current.getTime();
                if (this.state.selectedRange.start && time === this.state.selectedRange.start.getTime()) classes += ' selected';
                if (this.state.selectedRange.end && time === this.state.selectedRange.end.getTime()) classes += ' selected';
                if (this.state.selectedRange.start && this.state.selectedRange.end && time > this.state.selectedRange.start.getTime() && time < this.state.selectedRange.end.getTime()) classes += ' range';
                html += `<div class="${classes}" data-date="${year}-${String(month+1).padStart(2,'0')}-${String(i).padStart(2,'0')}">${i}</div>`;
            }
            
            (isMobile ? $('#mobCalendarGrid') : $('#calendarGrid')).html(html);
            const _this = this;
            $('.cal-day:not(.disabled):not(.empty)').on('click', function() { _this.handleDateClick($(this).data('date'), isMobile); });
        },

        handleDateClick: function(dateStr, isMobile = false) {
            const date = new Date(dateStr);
            if (!this.state.selectedRange.start || (this.state.selectedRange.start && this.state.selectedRange.end)) {
                this.state.selectedRange.start = date; this.state.selectedRange.end = null;
            } else if (date < this.state.selectedRange.start) {
                this.state.selectedRange.start = date;
            } else {
                this.state.selectedRange.end = date;
            }
            this.state.checkin = this.state.selectedRange.start ? this.formatDate(this.state.selectedRange.start) : '';
            this.state.checkout = this.state.selectedRange.end ? this.formatDate(this.state.selectedRange.end) : '';
            this.updateDisplay();
            this.renderCalendar(); this.renderCalendar(true);
        },

        formatDate: function(date) { return date.toISOString().split('T')[0]; },

        updateDisplay: function() {
            this.$displayCheckin.val(this.state.checkin || '');
            this.$displayCheckout.val(this.state.checkout || '');
            this.toggleClearBtn(this.$clearCheckin, this.state.checkin || this.state.checkout);
            
            const total = this.state.guests.adults + this.state.guests.children;
            this.$displayGuests.val(total > 0 ? total + (total === 1 ? ' guest' : ' guests') : '');
            this.toggleClearBtn(this.$clearGuests, total > 1 || this.state.guests.children > 0 || this.state.guests.infants > 0);
            
            $('#adultsCount, #mobAdultsCount').text(this.state.guests.adults);
            $('#childrenCount, #mobChildrenCount').text(this.state.guests.children);
            $('#infantsCount, #mobInfantsCount').text(this.state.guests.infants);
        },

        executeSearch: function() {
            let url = lefSearchData.archiveUrl;
            const params = [];
            if (this.state.location) params.push('location=' + encodeURIComponent(this.state.location));
            if (this.state.checkin) params.push('checkin=' + this.state.checkin);
            if (this.state.checkout) params.push('checkout=' + this.state.checkout);
            const total = this.state.guests.adults + this.state.guests.children + this.state.guests.infants;
            if (total > 0) params.push('guests=' + total);
            if (params.length > 0) url += (url.indexOf('?') > -1 ? '&' : '?') + params.join('&');
            window.location.href = url;
        }
    };

    $(document).ready(() => SearchBar.init());

})(jQuery);
