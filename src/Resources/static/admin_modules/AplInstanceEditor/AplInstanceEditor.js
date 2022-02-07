/**
 * Created by polyanin on 06.12.2016.
 */
/**
 * Created by polyanin on 17.11.2016.
 */
function AplInstanceEditor(container) {

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
    )(this, arguments.callee);

    let prefix = '.apl-instance-editor-';
    let class_prefix = 'apl-instance-editor-';

    let tabs = container.find(prefix + 'tabs').eq(0);
    let tabs_wrapper = container.find(prefix + 'tabs-wrapper').eq(0);
    let head = container.find(prefix + 'head').eq(0);
    let body = container.find(prefix + 'body').eq(0);
    let arrow_left = container.find(prefix + 'arrow-left').eq(0);
    let arrow_right = container.find(prefix + 'arrow-right').eq(0);

    let tabs_width = [];
    let tabs_scroll = [];
    let tabs_width_sum = 0;
    let local_storage_key = class_prefix + md5(window.location);
    let default_tab_index = 0;
    let default_tabs_wrapper_scroll = 0;
    let base_url = container.data('baseUrl');
    let primary_key = container.data('primaryKey');

    let loadState = function () {
        let raw = localStorage.getItem(local_storage_key);
        let json = JSON.parse(raw);
        try {
            let i = parseInt(json.i);
            if (isNaN(i)) {
                default_tab_index = 0;
            } else {
                default_tab_index = i;
            }
            let s = parseInt(json.s);
            if (isNaN(s)) {
                default_tabs_wrapper_scroll = 0;
            } else {
                default_tabs_wrapper_scroll = s;
            }
        } catch (err) {
            //console.log(err)
        }
    };

    let saveState = function () {
        localStorage.setItem(local_storage_key, JSON.stringify({
            i: default_tab_index,
            s: default_tabs_wrapper_scroll,
        }));
    };

    loadState();

    /**
     * Calculate width
     */
    let recalcWidth = function () {
        if (head.width() < tabs_width_sum) {
            if (tabs_wrapper.scrollLeft() < 1) {
                arrow_left.hide();
            } else {
                arrow_left.show();
            }
            let check = head.width() + tabs_wrapper.scrollLeft();
            if ((tabs_width_sum - check) < 1) {
                arrow_right.hide();
            } else {
                arrow_right.show();
            }
        } else {
            arrow_left.hide();
            arrow_right.hide();
            tabs_wrapper.css({
                left: 0,
                right: 0
            })
        }
    };

    /**
     * Initialization
     */
    let init = function () {
        tabs_wrapper.scrollLeft(default_tabs_wrapper_scroll);
        let tabs_width_sum_tmp = 0;
        let found_tab = tabs.find(prefix + 'tab');
        if (default_tab_index > found_tab.length) {
            default_tab_index = 0;
        }
        found_tab.each(function (i, o) {
            tabs_width[i] = $(o).outerWidth(true);
            tabs_scroll[i] = tabs_width_sum_tmp;
            tabs_width_sum_tmp += tabs_width[i];
        });
        if (!tabs_width_sum) {
            found_tab.removeClass(class_prefix + 'tab-active')
                .eq(default_tab_index).addClass(class_prefix + 'tab-active');
        }
        tabs_width_sum_tmp += .3;
        if (!tabs_width_sum) {
            // first run only
            body.find(prefix + 'panel')
                .removeClass(class_prefix + 'panel-active')
                .eq(default_tab_index).addClass(class_prefix + 'panel-active');
        }
        tabs.css({
            width: tabs_width_sum_tmp
        });
        tabs_width_sum = tabs_width_sum_tmp;
        recalcWidth();
    };

    /**
     * Window resize handler
     */
    $(window).resize(function () {
        tabs_wrapper.scrollLeft(tabs_scroll[default_tab_index] - (tabs_wrapper.width() - tabs_width[default_tab_index]) / 2);
        default_tabs_wrapper_scroll = tabs_wrapper.scrollLeft();
    });

    /**
     * Window resizeend handler
     */
    $(window).on('resizeend', function () {
        recalcWidth();
        saveState();
    });

    /**
     * Tabs click handler
     */
    tabs.find(prefix + 'tab').click(function () {
        let all = tabs.find(prefix + 'tab');
        $(this).addClass(class_prefix + 'tab-active');
        all.not(this).removeClass(class_prefix + 'tab-active');
        let index = all.index(this);
        default_tab_index = index;
        // trying to scroll tabs wrapper so that the selected tab is in the center
        tabs_wrapper.scrollLeft(tabs_scroll[index] - (tabs_wrapper.width() - tabs_width[index]) / 2);
        default_tabs_wrapper_scroll = tabs_wrapper.scrollLeft();
        body.find(prefix + 'panel')
            .removeClass(class_prefix + 'panel-active')
            .eq(index).addClass(class_prefix + 'panel-active');
        saveState();
        recalcWidth();
        $('.CodeMirror').each(function(i, el){
            el.CodeMirror.refresh();
        });
    });

    /**
     * Left arrow click handler
     */
    arrow_left.click(function () {
        tabs_wrapper.scrollLeft(tabs_wrapper.scrollLeft() - 50);
        default_tabs_wrapper_scroll = tabs_wrapper.scrollLeft();
        recalcWidth();
        saveState();
    });

    /**
     * Right arrow click handler
     */
    arrow_right.click(function () {
        tabs_wrapper.scrollLeft(tabs_wrapper.scrollLeft() + 50);
        default_tabs_wrapper_scroll = tabs_wrapper.scrollLeft();
        recalcWidth();
        saveState();
    });

    // workaround
    (function() {
        for (let i = 0; i < 100; i += 10) {
            setTimeout(function () {
                init();
            }, (100 + i) * i);
        }
    })();

    recalcWidth();

    if (typeof(CKEDITOR) != 'undefined') {
        /**
         * CKEditor initialization
         *
         * @param config
         */
        CKEDITOR.editorConfig = function (config) {
            // Define changes to default configuration here. For example:
            config.language = 'en';
            config.defaultLanguage = 'en';
            config.uiColor = 'f2f1f0';
            config.resize_enabled = false;
            config.toolbarCanCollapse = true;
            config.removePlugins = 'about,maximize';
            config.height = 10000;
            config.allowedContent = true;
            config.image_prefillDimensions = false;
        };

    }

    /**
     * adjust editor size
     */
    let fitEditors = function () {
        let height = body.height();
        let width = body.width();
        for (let o in CKEDITOR.instances) {
            if (CKEDITOR.instances.hasOwnProperty(o)) {
                CKEDITOR.instances[o].resize(width, height);
            }
        }
    };
    
    /**
     * CKEditor size adjust
     */
    this.fitEditors = function () {
        fitEditors();
    };
    
    this.fitEditorsSlow = function () {
        for (let i = 0; i < 5; i++) {
            setTimeout(function () {
                fitEditors();
            }, (100 + i) * i);
        }
    };

    /**
     * Init CKEditors
     */
    if (typeof(CKEDITOR) != 'undefined') {
        CKEDITOR.on('instanceReady', function (ev) {
            let editor = ev.editor;
            let height = body.height();
            let width = body.width();
            editor.resize(width, height);
            editor.on('afterCommandExec', function () {
                let width = body.width();
                let height = body.height();
                editor.resize(width, height);
            });
            $(window).resize(function () {
                fitEditors();
            });


            tabs.find(prefix + 'tab').click(function () {
                fitEditors();
            });
        });
    }

    /**
     * Workaround for small devices
     *
     * @returns {boolean}
     */
    let is_small = function () {
        let width = $(window).width();
        let height = $(window).height();
        let threshold = 768;
        return width <= threshold && height <= threshold;
    };
    /**
     * Editor configuration
     *
     * @returns {{uiColor: string, removePlugins: string, resize_enabled: boolean, height: number, removeButtons: string}}
     */
    let editor_config = function () {
        let config = {
            uiColor: '#ffffff',
            // removePlugins: 'about,maximize',
            removePlugins: 'maximize',
            resize_enabled: false,
            height: 10000,
            removeButtons: 'Cut,Copy,Scayt',
        };
        // Define changes to default configuration here.
        // For complete reference see:
        // http://docs.ckeditor.com/#!/api/CKEDITOR.config
        // Set the most common block elements.
        config.format_tags = 'p;h1;h2;h3;pre';
        config.defaultLanguage = 'en';
        config.language = 'en';
        config.image_prefillDimensions = false;
        config.fillEmptyBlocks = false;
        config.allowedContent = true;
        // Simplify the dialog windows.
        // config.removeDialogTabs = 'image:advanced;link:advanced';
        if (is_small()) {
            console.log('is');
            // The toolbar groups arrangement, optimized for a single toolbar row.
            config.toolbar = [
                {name: 'document', items: ['Source']},
                {name: 'clipboard', items: ['Undo', 'Redo']},
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript']},
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {name: 'links', items: ['Link', 'Unlink']},
                {name: 'insert', items: ['Image', 'Table', 'Emojione', 'EmojiPanel', 'SpecialChar']},
                {name: 'colors', items: ['TextColor', 'BGColor']}
            ];
            // The default plugins included in the basic setup define some buttons that
            // are not needed in a basic editor. They are removed here.
            config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript';
            // Dialog windows are also simplified.
            config.removeDialogTabs = 'link:advanced';
            config.toolbarStartupExpanded = false;
            config.toolbarCanCollapse = true;
            config.fillEmptyBlocks = false;
            config.allowedContent = true;
        } else {
            config.toolbar = [
                {name: 'document', items: ['Source']},
                {name: 'clipboard', items: ['Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo']},
                {name: 'editing', items: ['Find', 'Replace', 'SelectAll']},
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'CopyFormatting', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['ShowBlocks']},
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule', 'Emojione', 'EmojiPanel', 'SpecialChar', 'PageBreak', 'Iframe']
                },
                {name: 'styles', items: ['Styles', 'Format', 'FontSize']},
                {name: 'about', items: ['About']}
            ];
            config.toolbarCanCollapse = false;
            config.toolbarStartupExpanded = true;
            config.fillEmptyBlocks = false;
            config.allowedContent = true;
        }
        return config;
    };

    this.dropItem = function () {
        let c = confirm('Do you really want to delete item: ' + JSON.stringify(primary_key) + '?');
        if (!c) {
            return false;
        }
        c = confirm('Are you sure?');
        if (!c) {
            return false;
        }
        let post_data = {};
        let pk = primary_key;
        for (let p in pk) {
            if (undefined === post_data[p]) {
                post_data[p] = [];
            }
            post_data[p].push(pk[p]);
        }
        let f = $('<form method="post">');
        f.prop({
            action: (base_url + '/del').replace(/\/{2,}/, '/')
        });
        for (let p in post_data) {
            let input = $('<input type="hidden" name="' + p + '">')
                .val(JSON.stringify(post_data[p]));
            f.append(input);
        }
        container.append(f);
        f.submit();
    }

    /**
     * Save handler
     */
    this.save = function () {
        let form = body.children('form').eq(0);
        let oform = form.get(0);
        let data = new FormData(oform);

        let entries = data.entries();
        let next;
        while ((next = entries.next()) && next.done === false) {
            let pair = next.value;
            //console.log(pair);
        }
        form.submit();
    };

    /**
     * Save and exit handler
     */
    this.saveAndExit = function () {
        let e = document.createElement('input');
        $(e).attr({
            'type': 'hidden',
            'name': 'saveAndExit',
            'value': 'Y'
        });
        body.children('form').eq(0).append(e);
        this.save();
    };

    /**
     * Save and add new handler
     */
    this.saveAndAdd = function () {
        let e = document.createElement('input');
        $(e).attr({
            'type': 'hidden',
            'name': 'saveAndAdd',
            'value': 'Y'
        });
        body.children('form').eq(0).append(e);
        this.save();
    };

    /**
     * Save as new handler
     */
    this.saveAsNew = function () {
        let e = document.createElement('input');
        $(e).attr({
            'type': 'hidden',
            'name': 'saveAsNew',
            'value': 'Y'
        });
        body.children('form').eq(0).append(e);
        this.save();
    };

    if (typeof(CKEDITOR) != 'undefined') {
        /**
         * Wrap textarea
         */
        $('textarea' + prefix + 'ckeditor').ckeditor(editor_config());
    }

    /**
     * Datetimepicker configuration
     */
    $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
        icons: {
            time: 'far fa-clock',
            date: 'far fa-calendar',
            up: 'fas fa-arrow-up',
            down: 'fas fa-arrow-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
            today: 'far fa-calendar-check',
            clear: 'fas fa-trash',
            close: 'fas fa-times'
        }
    });
    // $(prefix + 'datetime').datetimepicker({
    $('.aplab-admin-field-type-datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        ignoreReadonly: true,
        allowInputToggle: true,
        focusOnShow: true,
        buttons: {
            showToday: true,
            showClear: true,
            showClose: true
        }
        // inline: true,
    });console.log('test');

    /**
     * workaround function to clear autocomplete password
     */
    setTimeout(function () {
        body.find(':password').val('');
    }, 10);

    /**
     * Input image plugin
     */
    body.find('.apl-instance-editor-element-image').each(function (i, o) {
        o = $(o);
        let input = o.find('input').eq(0);
        let previewer = o.find('.preview');
        let btn_upload = o.find('.fa-upload').closest('button');
        btn_upload.click(function () {
            let uploader = AplAdminFileUploader.getInstance();
            uploader.setTitle('Upload images only');
            uploader.setUrl('/xhr/uploadImage/');
            uploader.done = function () {
                AplAdminFileUploader.getInstance().purgeWindow();
                AplAdminImageHistory.getInstance().showWindow();
            };
            uploader.showWindow();
            AplAdminImageHistory.getInstance().beforeDone = function () {
                let items = AplAdminImageHistory.getInstance().getSelectedItems();
                if (!items.length) {
                    return;
                }
                input.val(items[0].path);
                previewer.css({
                    backgroundImage: 'url("' + input.val() + '")'
                });
            };
        });
        let btn_history = o.find('.fa-history').closest('button');
        btn_history.click(function () {
            AplAdminImageHistory.getInstance().showWindow();
            AplAdminImageHistory.getInstance().beforeDone = function () {
                let items = AplAdminImageHistory.getInstance().getSelectedItems();
                if (!items.length) {
                    return;
                }
                input.val(items[0].path);
                previewer.css({
                    backgroundImage: 'url("' + input.val() + '")'
                });
            };
        });
        let btn_favorites = o.find('.fa-star').closest('button');
        btn_favorites.click(function () {
            AplAdminImageHistory.getInstance().showWindow({
                favorites: true
            });
            AplAdminImageHistory.getInstance().beforeDone = function () {
                let items = AplAdminImageHistory.getInstance().getSelectedItems();
                if (!items.length) {
                    return;
                }
                input.val(items[0].path);
                previewer.css({
                    backgroundImage: 'url("' + input.val() + '")'
                });
            };
        });
        let btn_broom = o.find('.fa-broom').closest('button');
        btn_broom.click(function () {
            input.val('');
            previewer.css({
                backgroundImage: 'none'
            });
        });

        previewer.css({
            backgroundImage: 'url("' + input.val() + '")'
        });
        let previewer_timeout;
        input.change(function () {
            if (previewer_timeout) {
                clearTimeout(previewer_timeout);
            }
            previewer_timeout = setTimeout(function () {
                previewer.css({
                    backgroundImage: 'url("' + input.val() + '")'
                });
            }, 400);
        });
    });

    $('select.selectizejs').selectize();
    $('select.selectizejs-iconselector').selectize({
        render:{
            option: function (item, escape) {
                return '<div class="option"><i class="' + item.value + '"></i>' + escape(item.text) + '</div>';
            },
            item: function (item, escape) {
                return '<div class="item"><i class="' + item.value + '"></i>' + escape(item.text) + '</div>';
            }
        }
    });
    $('select.selectizejs-routevariants').selectize({
        create: true,
        sortField: 'text',
        render: {
            option: function (item, escape) {
                return '<div class="option">' + escape(item.text) + '<small class="text-muted pl-2">' + escape(item.value) + '</small></div>';
            },
            item: function (item, escape) {
                return '<div class="item">' + escape(item.text) + '</div>';
            }
        },
        onChange: function () {
            let value = this.getValue();
            this.clear(true);
            let selector = this.$input;
            let text = selector.parent().parent().find('.selectizejs-routevariants-text');
            text.val(value);
            console.log(selector.parent());
            selector.parent().collapse('hide');
        }
    });
}
