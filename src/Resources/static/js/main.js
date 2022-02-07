$(document).ready(function () {

    /**
     * Global object
     *
     * @constructor
     */
    window.AplabAdmin = function () {
    };

    /**
     * Returns common cookie key name
     * @returns {string}
     */
    AplabAdmin.getCookieKey = function () {
        return 'aplab-admin-data';
    };

    AplabAdmin.openLauncher = function () {
        let body = $('body');
        body.addClass('apl-admin-launcher-is-opened');
        body.addClass('apl-admin-launcher-is-visible');
        Mousetrap.bind(['esc'], AplabAdmin.closeLauncher);
        Mousetrap.unbind(['ctrl+alt+`']);
    };

    AplabAdmin.closeLauncher = function () {
        let body = $('body');
        body.removeClass('apl-admin-launcher-is-visible');
        setTimeout(function () {
            body.removeClass('apl-admin-launcher-is-opened');
        }, 150);
        Mousetrap.unbind(['esc']);
        Mousetrap.bind(['ctrl+alt+`'], AplabAdmin.openLauncher);
    };

    /**
     * Initialize
     */
    AplabAdmin.init = function () {
        $('#aplab-admin-open-launcher').click(AplabAdmin.openLauncher);
        $('#apl-admin-launcher-close').click(AplabAdmin.closeLauncher);
        Mousetrap.bind(['ctrl+alt+`'], AplabAdmin.openLauncher);
        let owl = $('.apl-admin-launcher-body');
        owl.owlCarousel({
            navigation: false, // Show next and prev buttons

            slideSpeed: 300,
            paginationSpeed: 400,

            items: 1,
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false,
            dotsContainer: '#carousel-custom-dots'
        });
        $('.owl-dot').click(function () {
            owl.trigger('to.owl.carousel', [$(this).index(), 300]);
        });
        owl.on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY > 0) {
                owl.trigger('prev.owl');
            } else {
                owl.trigger('next.owl');
            }
            e.preventDefault();
        });
    };

    /**
     * Returns cookie stored data
     *
     * @returns {*}
     */
    AplabAdmin.getCookieData = function () {
        var data = Cookies.getJSON(AplabAdmin.getCookieKey());
        var type = typeof (data);
        if ('object' !== type.toLowerCase()) {
            data = {};
            Cookies.set(AplabAdmin.getCookieKey(), data);
        }
        return data;
    };

    /**
     * Expand actionsbar handler
     */
    AplabAdmin.expandActionMenu = function () {
        AplActionMenu.getInstance('apl-admin-action-menu').show();
        $('body').on('click', AplabAdmin.clickOutsideActionMenuHandler);
    };

    AplabAdmin.collapseActionMenu = function () {
        $('body').off('click', AplabAdmin.clickOutsideActionMenuHandler);
        AplActionMenu.getInstance('apl-admin-action-menu').hide();
    };

    AplabAdmin.clickOutsideActionMenuHandler = function (event) {
        if ($(event.target).closest('#apl-admin-action-menu').length) {
            return;
        }
        AplabAdmin.collapseActionMenu();
    };

    $('#aplab-admin-open-action-menu').on('click', function (event) {
        event.stopPropagation();
        AplabAdmin.expandActionMenu();
    });

    /**
     * Show image uploader
     */
    AplabAdmin.showImageUploader = function () {
        var uploader = AplAdminFileUploader.getInstance();
        uploader.setTitle('Upload images only');
        uploader.setUrl('/xhr/uploadImage/');
        uploader.done = function () {
            AplAdminFileUploader.getInstance().purgeWindow();
            AplAdminImageHistory.getInstance().showWindow();
        };
        uploader.showWindow();
    };

    /**
     * Call initialization.
     */
    AplabAdmin.init(/** test 6 */);

    // Expand all dump levels of all sf-dumps on a page.
    $("pre.sf-dump").each(function () {
        $(this).find("a.sf-dump-toggle:gt(0)").each(function (i, a) {
            a.click();
        });
    });

    AplabAdmin.createShortcut = function () {
        let ucfirst = function( str ) {
            let f = str.charAt(0).toUpperCase();
            return f + str.substr(1, str.length-1);
        }
        let url = location.pathname;
        let name = $.trim(url.replace(/[^a-zA-Z0-9]+/g,' '));
        if (name.length) {
            name = ucfirst(name);
        }
        let form = $('<form>');
        form.prop({
            method: 'POST',
            action: '/desktop-entry/add',
            target: '_self'
        });
        let create = function (name, value) {
            let e = $('<input type="hidden">').prop({
                name: 'apl-instance-editor[' + name + ']',
                value
            });
            form.append(e);
        }
        create('name', name);
        create('sortOrder', 0);
        create('url', url);
        create('icon', '');
        create('evalScript', '');
        $('body').append(form);
        form.submit();
    };
});
