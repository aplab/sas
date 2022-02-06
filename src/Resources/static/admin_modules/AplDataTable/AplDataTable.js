'use strict';

/**
 * Created by polyanin on 17.11.2016.
 */
function AplDataTable(container) {

    (
        /**
         * static init
         *
         * @param o self same object
         * @param c same function
         */
        function (o, c) {
            if (undefined === c.instance) {
                c.instance = o;
            } else {
                if (c.instance !== o) {
                    console.log('Instance already exists. Only one instance allowed!');
                    throw new Error('Instance already exists. Only one instance allowed!');
                }
            }
            if (undefined === c.getInstance) {
                c.getInstance = function () {
                    return c.instance;
                };
            }
        }
    )(this, AplDataTable);

    let prefix = '.apl-data-table-';

    let content = container.find(prefix + 'content').eq(0);

    let scroll_horizontal_wrapper = container.find(prefix + 'scroll-horizontal-wrapper').eq(0);
    let scroll_horizontal = container.find(prefix + 'scroll-horizontal').eq(0);
    let scroll_horizontal_content = container.find(prefix + 'scroll-horizontal-content').eq(0);

    let scroll_vertical_wrapper = container.find(prefix + 'scroll-vertical-wrapper').eq(0);
    let scroll_vertical = container.find(prefix + 'scroll-vertical').eq(0);
    let scroll_vertical_content = container.find(prefix + 'scroll-vertical-content').eq(0);

    let body = container.find(prefix + 'body').eq(0);
    let data = container.find(prefix + 'data').eq(0);

    let sidebar_body_col = container.find(prefix + 'sidebar-body-col').eq(0);
    //let sidebar_header = container.find(prefix + 'sidebar-header').eq(0);
    let sidebar_header_checkbox = container.find(prefix + 'sidebar-header :checkbox').eq(0);

    let header_row = container.find(prefix + 'header-row').eq(0);

    let scrollbar_calc_outer = $('<div>').addClass('apl-data-table-scrollbar-calc-outer');
    let scrollbar_calc_inner = $('<div>').addClass('apl-data-table-scrollbar-calc-inner');

    let prev_trigger = container.find(prefix + 'prev').eq(0);
    let next_trigger = container.find(prefix + 'next').eq(0);
    let page_select = container.find(prefix + 'page select').eq(0);
    let limit_select = container.find(prefix + 'limit select').eq(0);
    let base_url = container.data('baseUrl');

    container.append(scrollbar_calc_outer);
    scrollbar_calc_outer.append(scrollbar_calc_inner);

    data.children('div').on('click', function () {
        // if (isTouchDevice()) {
        //     return;
        // }
        let o = $(this);
        data.children('div').not(o).removeClass('apl-data-table-active');
        o.toggleClass('apl-data-table-active');
    });

    data.children('div').each(function (i, o) {
        let checkbox_code = '<div class="custom-control custom-checkbox">\n' +
            '  <input type="checkbox" class="custom-control-input" id="%%PLACEHOLDER%%">\n' +
            '  <label class="custom-control-label" for="%%PLACEHOLDER%%"></label>\n' +
            '</div>';
        let div = $('<div>');
        let $o = $(o);
        div.css({
            height: $o.height()
        });
        sidebar_body_col.append(div);
        div.append($(checkbox_code.replace(/%%PLACEHOLDER%%/g, 'apl-data-table-sidebar-header-check-' + i)));
    });

    /**
     *
     * @returns {{h: number, v: number}}
     */
    let calcScrollbarWidth = function () {
        let ow = scrollbar_calc_outer.width();
        let iw = scrollbar_calc_inner.width();
        let oh = scrollbar_calc_outer.height();
        let ih = scrollbar_calc_inner.height();
        return {
            h: Math.round(oh - ih),
            v: Math.round(ow - iw)
        }
    };

    let init = function () {
        let system_scrollbar_size = calcScrollbarWidth();
        let data_width = data.width();
        let data_height = data.height();
        scroll_horizontal_content.css({
            width: data_width
        });
        scroll_vertical_content.css({
            height: data_height
        });
        let threshold = 0;
        let hcalc = function () {
            if ((data_width - scroll_horizontal.width()) > threshold) {
                content.css({
                    bottom: system_scrollbar_size.h
                });
                scroll_horizontal_wrapper.css({
                    height: system_scrollbar_size.h || 4,
                });
                scroll_vertical_wrapper.css({
                    bottom: system_scrollbar_size.h
                });
            } else {
                content.css({
                    bottom: 0
                });
                scroll_horizontal_wrapper.css({
                    height: 0
                });
                scroll_vertical_wrapper.css({
                    bottom: 0
                });
            }
        };
        let vcalc = function () {
            if ((data_height - scroll_vertical.height()) > threshold) {
                content.css({
                    right: system_scrollbar_size.v
                });
                scroll_vertical_wrapper.css({
                    width: system_scrollbar_size.v || 4
                });
                scroll_horizontal_wrapper.css({
                    right: system_scrollbar_size.v
                });
            } else {
                content.css({
                    right: 0
                });
                scroll_vertical_wrapper.css({
                    width: 0
                });
                scroll_horizontal_wrapper.css({
                    right: 0
                });
            }
        };
        vcalc();
        hcalc();
        vcalc();
        setTimeout(function () {
            let sidebar_body_col_divs = sidebar_body_col.children('div');
            data.children('div').each(function (i, o) {
                sidebar_body_col_divs.eq(i).css({
                    height: $(o).height()
                });
            });
        }, 1);
    };

    init();

    this.reinit = function () {
        setTimeout(function () {
            init();
        }, 10);
        setTimeout(function () {
            init();
        }, 100);
        setTimeout(function () {
            init();
        }, 1000);
    };

    $(window).resize(function () {
        init();
    });

    scroll_vertical.scroll(function () {
        let scroll_top = -1 * $(this).scrollTop();
        data.css({
            top: scroll_top
        });
        sidebar_body_col.css({
            top: scroll_top
        });
    });

    scroll_horizontal.scroll(function () {
        let scroll_left = -1 * $(this).scrollLeft();
        data.css({
            left: scroll_left
        });
        header_row.css({
            left: scroll_left
        });
    });

    body.on('mousewheel', function (event) {
        let current = scroll_vertical.scrollTop();
        scroll_vertical.scrollTop(current + -111 * event.deltaY);
    });

    let start_position_x = 0;
    let start_position_y = 0;


    body.on('touchstart', function (event) {
        let e = event.originalEvent;
        start_position_x = scroll_horizontal.scrollLeft() + e.touches[0].pageX;
        start_position_y = scroll_vertical.scrollTop() + e.touches[0].pageY;
    });

    body.on('touchend', function (/*event*/) {
        //let e = event.originalEvent;
        start_position_x = 0;
        start_position_y = 0;
    });

    body.on('touchmove', function (event) {
        let e = event.originalEvent;
        scroll_horizontal.scrollLeft(start_position_x - e.touches[0].pageX);
        scroll_vertical.scrollTop(start_position_y - e.touches[0].pageY);
    });

    sidebar_header_checkbox.prop({
        checked: false
    }).change(function () {
        sidebar_body_col.find(':checkbox').prop({
            checked: sidebar_header_checkbox.prop('checked')
        });
    });

    /**
     * Обработчик группового выделения строк
     */
    let last_sidebar_checkbox;
    let all_sidebar_checkboxes = sidebar_body_col.find(':checkbox');
    all_sidebar_checkboxes.each(function (i, o) {
        $(o).dblclick(function (event) {
            event.stopPropagation();
        });
        // click handler
        $(o).click(function (event) {
            event.stopPropagation();
            if (!last_sidebar_checkbox) {
                last_sidebar_checkbox = this;
                return;
            }
            if (last_sidebar_checkbox === this) {
                return;
            }
            if (!event.shiftKey) {
                last_sidebar_checkbox = this;
                return;
            }
            let flag = 0;
            for (let i = 0; i < all_sidebar_checkboxes.length; i++) {
                if (all_sidebar_checkboxes[i] === this || all_sidebar_checkboxes[i] === last_sidebar_checkbox) {
                    if (flag === 0) {
                        flag = 1;
                    } else if (flag === 1) {
                        all_sidebar_checkboxes[i].checked = last_sidebar_checkbox.checked;
                        break;
                    }
                }
                if (flag === 1) {
                    all_sidebar_checkboxes[i].checked = last_sidebar_checkbox.checked;
                }
            }
            last_sidebar_checkbox = this;
        });
    });

    /**
     * Retrieve checked rows
     *
     * @returns {{length: number}}
     */
    this.getCheckedRows = function () {
        let elements = {
            length: 0,
            items: []
        };
        let rows = data.children('div');
        let index, element;
        let checked = sidebar_body_col.children('div').has(':checked');
        if (checked.length) {
            let i;
            for (i = 0; i < checked.length; i++) {
                index = sidebar_body_col.children('div').index(checked[i]);
                element = rows.eq(index);
                elements.items[i] = {
                    index: index,
                    data: {
                        pk: element.data('pk')
                    }
                };
            }
            elements.length = i;
        }
        return elements;
    };

    /**
     * Retrieve currently-selected row if it only one!
     *
     * @returns {{length: number}}
     */
    this.getCurrentRow = function () {
        let elements = {
            length: 0,
            items: {}
        };
        let rows = data.children('div');
        let selected = data.children('[class$="-active"]');
        if (selected.length === 1) {
            let element = selected.eq(0);
            let index = rows.index(element);
            elements.items[0] = {
                index: index,
                data: {
                    pk: element.data('pk')
                }
            };
            elements.length = 1;
        }
        return elements;
    };

    let navigate = function () {
        let f = $('<form method="post">');
        let page_number = $('<input type="hidden" name="pageNumber">').val(page_select.val());
        let items_per_page = $('<input type="hidden" name="itemsPerPage">').val(limit_select.val());
        f.append(page_number).append(items_per_page);
        container.append(f);
        f.submit();
    };

    page_select.change(function () {
        navigate();
    });

    limit_select.change(function () {
        navigate();
    });

    if (!(prev_trigger.hasClass('disabled'))) {
        prev_trigger.click(function () {
            prev_trigger.addClass('disabled');
            page_select.val(parseInt(page_select.val(), 10) - 1);
            navigate();
        });
    }

    if (!(next_trigger.hasClass('disabled'))) {
        next_trigger.click(function () {
            next_trigger.addClass('disabled');
            page_select.val(parseInt(page_select.val(), 10) + 1);
            navigate();
        });
    }

    this.del = function () {
        this.doAction('/del', 'delete')
    };

    this.duplicate = function () {
        this.doAction('/duplicate', 'duplicate')
    };

    this.doAction = function (url, text) {
        AplabAdmin.collapseActionMenu();
        let items;
        items = this.getCheckedRows();
        if (!items.length) {
            items = this.getCurrentRow();
        }
        if (!items.length) {
            alert('Nothing selected');
            return;
        }
        if (!confirm('Confifm ' + text + ' items: ' + items.length)) {
            return;
        }
        let post_data = {};
        for (let i = 0; i < items.length; i++) {
            let pk = items.items[i].data.pk;
            for (let p in pk) {
                if (undefined === post_data[p]) {
                    post_data[p] = [];
                }
                post_data[p].push(pk[p]);
            }
        }
        let f = $('<form method="post">');
        f.prop({
            action: (base_url + url).replace(/\/{2,}/, '/')
        });
        for (let p in post_data) {
            let input = $('<input type="hidden" name="' + p + '">')
                .val(JSON.stringify(post_data[p]));
            f.append(input);
        }
        container.append(f);
        f.submit();
    };

    /**
     * Touch device detector
     *
     * @returns {boolean}
     */
    // let isTouchDevice = function () {
    //     return 'ontouchstart' in document.documentElement;
    // };

    data.find(':checkbox').change(function () {
        let o = $(this);
        let value = o.prop('checked') ? 1 : 0;
        let name = o.prop('name');
        let data_class = o.data('class');
        if (data_class === undefined) {
            return;
        }
        let pk = o.closest('.wExt').data('pk');
        if (pk === undefined) {
            return;
        }
        let post_data = {
            pk: pk,
            name: name,
            value: value,
            class: data_class
        };
        let url = '/xhr/' + '/aplDataTable/editProperty/';
        url = url.replace(/\/{2,}/, '/');
        $.post(
            url,
            post_data,
            function (data) {
                try {
                    if ('ok' === data.status) {
                        o.prop('checked', value);
                        return;
                    }
                } catch (e) {
                    alert('error: ' + e.message);
                }
                try {
                    if ('error' === data.status) {
                        alert('error: ' + data.message);
                    }
                } catch (e) {
                    alert('error: ' + e.message);
                }
            },
            'json'
        );
    });

    this.batchAddFilesPlugin = function () {
        let uploader = AplAdminFileUploader.getInstance();
        uploader.setTitle('Upload files');
        uploader.setUrl('/xhr/uploadFile/');
        uploader.done = function () {
            uploader.purgeWindow();
            location.reload();
        };
        uploader.showWindow();
    };

    this.galleryBuilderPlugin = function () {
        let uploader = AplAdminFileUploader.getInstance();
        uploader.setTitle('Gallery builder');
        uploader.setUrl('/xhr/galleryBuilder/');
        uploader.done = function () {
            uploader.purgeWindow();
            location.reload();
        };
        uploader.showWindow();
    };

    this.galleryBuilderMassFillAltPlugin = function () {
        let user_input = prompt('Enter alt field for mass update', 'Кукла ручной работы, Игрушка ручной работы, Handmade doll, Handmade toy, Кукла своими руками, Игрушка своими руками');
        if (null === user_input) {
            return;
        }
        let form = document.createElement('form');
        let oForm = $(form);
        oForm.attr({
            method: 'POST',
            action: '/gallery-builder/alt-all',
        });

        let e = document.createElement('input');
        $(e).attr({
            type: 'hidden',
            name: 'alt',
            value: user_input,
        });

        oForm.append(e);
        body.append(oForm);
        oForm.submit();
    };

    /**
     * Save handler
     */
    this.importFromVk = function (form_action_url) {
        let user_input = prompt('Enter VK wall post url:', '');
        if (null === user_input) {
            return;
        }
        let form = document.createElement('form');
        let oForm = $(form);
        oForm.attr({
            method: 'POST',
            action: form_action_url,
        });

        let e = document.createElement('input');
        $(e).attr({
            type: 'hidden',
            name: 'vkWallPostUrl',
            value: user_input,
        });

        oForm.append(e);
        body.append(oForm);
        oForm.submit();
    };
}
