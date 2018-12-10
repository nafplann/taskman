const App = {
    init() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },
    slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    },
    baseUrl(path = '') {
        return $('meta[name="base-url"]').attr('content') + path;
    },
    userId() {
        return $('meta[name="user-id"]').attr('content');
    },
    loading(state = true) {
        state 
            ? $('#main-preloader').removeClass('hidden')
            : $('#main-preloader').addClass('hidden')
    },
    hex2rgba(hex, alpha = 1) {
        let [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16));
        return `rgba(${r},${g},${b},${alpha})`;
    },
    ajax(url, method, dataType, data) {
        return $.ajax({
            url: url,
            type: method,
            datatype: dataType,
            data: data,
            error(err) {
                // console.log('Error fetching data from ' + url, err);
            }
        });
    },
    ajaxFile(url, method, dataType, data) {
        return $.ajax({
            url: url,
            type: method,
            datatype: dataType,
            data: data,
            contentType: false,
            processData: false
        });
    },
    serializeForm(form) {
        var data = form.serializeArray();
        var submit = form.find('.submit');

        $.each(submit, function() {
            var name = $(this).attr('name');
            var value = $(this).attr('value');
            var text = $(this).text();
            if (name && (value || text)) {
                data.push({ name: name, value: (value) ? value : text });
            }
        });

        return data;
    },
    loadModal(size = 'md', backdrop = 'static') {
        let modalId = 'modal-' + new Date().getTime();

        let modal = `<div id="${modalId}" class="modal">
            <div class="modal-content">
                <div class="progress" id="modal-preloader">
                    <div class="indeterminate"></div>
                </div>
            </div>`;

        $('body').append(modal);

        $('#'+modalId).modal({ 
            dismissible: false,
            onCloseEnd: function() {
                $('#'+modalId).remove();
            }
        });

        $('#'+modalId).modal('open');
        
        return $('#'+modalId);
    },
    enable(element) {
        element.removeClass('is-loading')
            .attr('disabled', false);
    },
    disable(element) {
        element.addClass('is-loading')
            .attr('disabled', true);
    },
    disableSubmit(form) {
        form.find('button[type="submit"]')
            .addClass('m-loader m-loader--light m-loader--right')
            .attr('disabled', true);
    },
    enableSubmit(form) {
        form.find('button[type="submit"]')
            .removeClass('m-loader m-loader--light m-loader--right')
            .attr('disabled', false);
    },
    getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    },
    alert(title, messages, type) {
        
        let html = '';

        if (typeof messages === 'object') {
            messages.forEach(message => {
                html += `<p class="has-text-danger">${message}</p>`;
            });
        } else {
            html = messages;
        }
        
        swal({ 
            title, 
            html, 
            type,
            confirmButtonText: 'Okay',
        });
    },
    formFailed(form, message) {
        App.enableSubmit(form);
        App.alert('Failed', message, 'error');
    },
    capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    },
    titleToSlug(text) {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-');
    },
    datatable(element, options) {
        return $(element).DataTable($.extend({
            dom:`<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>
                <'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>`,
            responsive: true,
            searching: true,
            processing: true,
            paging: true,   
            language: {
                processing: `<div class="m-blockui "><span>Please wait...</span><span><div class="m-loader  m-loader--success m-loader--lg"></div></span></div>`
            }
        }, options));
    },
    slimSelect(element, options) {
        return new SlimSelect($.extend({
            select: element,
        }, options));
    },
    daterangepicker(element, options, callback = null) {
        $(element).daterangepicker($.extend({
            buttonClasses: 'm-btn btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            startDate: moment().subtract(7, 'days'),
            endDate: moment().subtract(1, 'days'),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(7, 'days'), moment().subtract(1, 'days')],
                'Last 30 Days': [moment().subtract(30, 'days'), moment().subtract(1, 'days')],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, options), callback);
    }
};

export default App;
