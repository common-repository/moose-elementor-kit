(function ($) {
    'use strict';

    function initColorPicker() {
        $('.mek-color-field').wpColorPicker({
            change: function (event, ui) {
                var element = event.target;
                $(element).parents('[data-mek-change-monitor]').find('input[type="submit"]').prop('disabled', false);
            }
        });
    }

    function initThemeEntry() {
        // Delete Theme
        $('.mek-delete-theme').on('click', function () {
            handleFormInputChange($(this));
            var $wrapper = $(this).parents('[data-mek-theme-index]');

            $('#mek-default-theme').find('option[value="' + $wrapper.data('mek-theme-index') + '"]').remove();
            $wrapper.remove();
        });

        // Toggle Theme
        $('.mek-toggle-theme-palette').on('click', function () {
            $(this).find('span')
                .toggleClass('dashicons-arrow-left-alt2')
                .toggleClass('dashicons-arrow-down-alt2');

            $(this).parents('[data-mek-theme-index]').find('.mek-theme-palette').toggle();
        });
    }

    function handleFormInputChange($input, changed = true) {
        $input.parents('[data-mek-change-monitor]').find('input[type="submit"]').prop('disabled', !changed);
    }


    function initFormChangeMonitor() {
        var $submit = $('[data-mek-change-monitor] input[type="submit"]');
        $submit.prop('disabled', true);
        $submit.on('click', function () {
            var $this = $(this);
            var $form = $(this).parents('[data-mek-change-monitor]');
            $form.ajaxSubmit({
                success: function () {
                    $.toast({
                        text: "Settings Saved!",
                        position: 'bottom-right',
                        bgColor: '#10b981',
                        textColor: '#ffffff',
                        loaderBg: '#34d399',
                    });

                    handleFormInputChange($this, false);
                },
                error: function () {
                    $.toast({
                        text: "Something went wrong!",
                        position: 'bottom-right',
                        bgColor: '#dc2626',
                        textColor: '#ffffff',
                        loaderBg: '#ef4444',
                    });
                }
            });

            return false;
        });

        $('[data-mek-change-monitor]').find('input, select').on('change', function () {
            handleFormInputChange($(this));
        });

        $(window).on('beforeunload', function () {
            if ($submit.length > 0 && !$submit.prop('disabled')) {
                return 'You have unsaved settings, are you sure you want to leave?';
            }
        });
    }

    function initThemes() {
        var template = wp.template('mek-theme-template');
        var $container = $('.mek-themes-container');
        var $defaultTheme = $('#mek-default-theme');

        Object.keys(MEKThemes.themes).forEach(function (index) {
            var theme = MEKThemes.themes[index];
            $container.append(template({
                index,
                label: theme.label,
                palette: Object.assign({}, MEKThemes.palette, theme.palette),
            }));
        });

        initColorPicker();
        initThemeEntry();

        // Create New Theme
        $('#mek-create-new-theme').on('click', function () {
            var label = $('#mek-new-theme-label').val();
            var index = 0;

            $container.find('[data-mek-theme-index]').each(function () {
                if ($(this).data('mek-theme-index') > index) {
                    index = $(this).data('mek-theme-index');
                }
            });

            $container.append(template({
                index: index + 1,
                label,
                palette: MEKThemes.palette,
            }));

            $defaultTheme.append('<option value="' + (index + 1) + '">' + label + '</option>');

            handleFormInputChange($(this));
            initColorPicker();
            initThemeEntry();
        });
    }

    $(document).ready(function ($) {
        // Add Color Picker to all inputs that have 'mek-color-field' class
        initColorPicker();

        // Toggle All Elements
        $('#mek-element-toggle-all').on('change', function () {
            if ($(this).is(':checked')) {
                $('.mek-elements').find('input[type="checkbox"]').prop('checked', true);
            } else {
                $('.mek-elements').find('input[type="checkbox"]').prop('checked', false);
            }
        });

        // Load all themes
        if (undefined !== window.MEKThemes) {
            initThemes();
        }

        // Form input change monitor
        initFormChangeMonitor();
    });

})(jQuery);