(function ($) {
    'use strict';

    jQuery.extend(jQuery.expr[':'], {
        focusable: function (el) {
            return jQuery(el).is('a, button, :input, [tabindex]');
        }
    });

    var MEK = {
        init: function () {

            var widgets = {
                'mek_navbar.default': MEK.navbarWidget,
                'mek_post_grid.default': MEK.postGridWidget,
                'mek_advanced_slider.default': MEK.sliderWidget,
                'global': MEK.sectionWidget,
            };

            $.each(widgets, function (widget, callback) {
                window.elementorFrontend.hooks.addAction('frontend/element_ready/' + widget, callback);
            });
        },

        navbarWidget: function ($scope) {
            MEK.initToggle($scope);
            MEK.initFocusRedirect($scope);
        },

        postGridWidget: function ($scope) {
            var $grid = $scope.find('.mek-post-grid');
            var settings = $grid.attr('data-settings');

            if (typeof settings === typeof undefined || settings === false || MEK.isEditor()) {
                return;
            }

            console.log(settings);
            settings = JSON.parse(settings);

            // infinite-scroll/load-more
            if ('load-more' === settings.pagination_type || 'infinite-scroll' === settings.pagination_type) {

                var pagination = $scope.find('.mek-post-grid-pagination');
                var navClass = false;
                var threshold = false;
                var scopeClass = '.elementor-element-' + $scope.attr('data-id');

                if ('infinite-scroll' === settings.pagination_type) {
                    threshold = 300;
                    navClass = scopeClass + ' .mek-load-more-btn';
                }

                $grid.infiniteScroll({
                    path: scopeClass + ' .mek-post-grid-pagination a',
                    hideNav: navClass,
                    append: false,
                    history: false,
                    scrollThreshold: threshold,
                    status: scopeClass + ' .page-load-status'
                });

                // Request
                $grid.on('request.infiniteScroll', function (event, path) {
                    pagination.find('.mek-load-more-btn').hide();
                    pagination.find('.mek-pagination-loading').css('display', 'inline-block');
                });

                // Load
                var pagesLoaded = 0;
                $grid.on('load.infiniteScroll', function (event, response) {
                    pagesLoaded++;
                    // get posts from response
                    var items = $(response).find(scopeClass).find('.mek-card-wrap');
                    $grid.infiniteScroll('appendItems', items);

                    // Loading
                    pagination.find('.mek-pagination-loading').hide();

                    if (settings.pagination_max_pages - 1 !== pagesLoaded) {
                        if ('load-more' === settings.pagination_type) {
                            pagination.find('.mek-load-more-btn').fadeIn();
                        }
                    } else {
                        pagination.find('.mek-pagination-finish').fadeIn(1000);
                        pagination.delay(2000).fadeOut(1000);
                        setTimeout(function () {
                            pagination.find('.mek-pagination-loading').hide();
                        }, 500);
                    }
                });

                pagination.find('.mek-load-more-btn').on('click', function () {
                    $grid.infiniteScroll('loadNextPage');
                    return false;
                });
            }
        },

        sliderWidget: function ($scope) {

            // Slider Columns
            var sliderClass = $scope.attr('class'),
                sliderColumnsDesktop = Number(sliderClass.match(/mek-slider-columns-\d/) ? sliderClass.match(/mek-slider-columns-\d/).join().slice(-1) : 2),
                sliderColumnsWideScreen = Number(sliderClass.match(/columns--widescreen\d/) ? sliderClass.match(/columns--widescreen\d/).join().slice(-1) : sliderColumnsDesktop),
                sliderColumnsLaptop = Number(sliderClass.match(/columns--laptop\d/) ? sliderClass.match(/columns--laptop\d/).join().slice(-1) : sliderColumnsDesktop),
                sliderColumnsTabletExtra = Number(sliderClass.match(/columns--tablet_extra\d/) ? sliderClass.match(/columns--tablet_extra\d/).join().slice(-1) : sliderColumnsLaptop),
                sliderColumnsTablet = Number(sliderClass.match(/columns--tablet\d/) ? sliderClass.match(/columns--tablet\d/).join().slice(-1) : 2),
                sliderColumnsMobileExtra = Number(sliderClass.match(/columns--mobile_extra\d/) ? sliderClass.match(/columns--mobile_extra\d/).join().slice(-1) : sliderColumnsTablet),
                sliderColumnsMobile = Number(sliderClass.match(/columns--mobile\d/) ? sliderClass.match(/columns--mobile\d/).join().slice(-1) : 1),
                sliderSlidesToScroll = Number((sliderClass.match(/mek-slides-to-scroll-\d/).join().slice(-1)));

            $scope.find('[data-mek-slick]').each(function (_, el) {

                var dataSlideEffect = $(el).attr('data-slide-effect')

                if ($(el).hasClass('slick-initialized')) {
                    return;
                }

                $(el).slick({
                    appendArrows: $scope.find('.mek-slider-controls'),
                    appendDots: $scope.find('.mek-slider-dots'),
                    customPaging: function (slider, i) {
                        return '<span class="mek-slider-dot"></span>';
                    },
                    slidesToShow: sliderColumnsDesktop,
                    slidesToScroll: sliderSlidesToScroll > sliderColumnsDesktop ? 1 : sliderSlidesToScroll,
                    fade: (1 == sliderColumnsDesktop && 'fade' === dataSlideEffect) ? true : false,
                    responsive: [
                        {
                            breakpoint: 10000,
                            settings: {
                                slidesToShow: sliderColumnsWideScreen,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsWideScreen ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsWideScreen && 'fade' === dataSlideEffect) ? true : false
                            }
                        },
                        {
                            breakpoint: 2399,
                            settings: {
                                slidesToShow: sliderColumnsDesktop,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsDesktop ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsDesktop && 'fade' === dataSlideEffect) ? true : false
                            }
                        },
                        {
                            breakpoint: 1221,
                            settings: {
                                slidesToShow: sliderColumnsLaptop,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsLaptop ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsLaptop && 'fade' === dataSlideEffect) ? true : false
                            }
                        },
                        {
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: sliderColumnsTabletExtra,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsTabletExtra ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsTabletExtra && 'fade' === dataSlideEffect) ? true : false
                            }
                        },
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: sliderColumnsTablet,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsTablet ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsTablet && 'fade' === dataSlideEffect) ? true : false
                            }
                        },
                        {
                            breakpoint: 880,
                            settings: {
                                slidesToShow: sliderColumnsMobileExtra,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsMobileExtra ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsMobileExtra && 'fade' === dataSlideEffect) ? true : false
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: sliderColumnsMobile,
                                slidesToScroll: sliderSlidesToScroll > sliderColumnsMobile ? 1 : sliderSlidesToScroll,
                                fade: (1 == sliderColumnsMobile && 'fade' === dataSlideEffect) ? true : false
                            }
                        }
                    ],
                });
            });
        },

        sectionWidget: function ($scope) {

            // Particles
            if ($scope.attr('data-mek-particles') || $scope.find('.mek-particle-wrapper').attr('data-mek-particles-editor')) {
                var elementType = $scope.data('element_type');
                var sectionID = $scope.data('id');
                var isEditor = MEK.isEditor();
                var particles = overrideConfig(JSON.parse(!MEK.isEditor() ? $scope.attr('data-mek-particles') : $scope.find('.mek-particle-wrapper').attr('data-mek-particles-editor')));

                function overrideConfig(config) {
                    
                    return config;
                }

                if ('section' === elementType && undefined !== particles) {
                    // Editor
                    if (isEditor) {
                        // Particles is enable
                        if ($scope.hasClass('mek-particles-yes')) {
                            particlesJS('mek-particle-' + sectionID, particles);
                            $scope.find('.elementor-column').css('z-index', 9);
                            $(window).trigger('resize');
                        } else {
                            $scope.find('.mek-particle-wrapper').remove();
                        }
                    } else { // Frontend
                        $scope.prepend('<div class="mek-particle-wrapper" id="mek-particle-' + sectionID + '"></div>');
                        particlesJS('mek-particle-' + sectionID, particles);
                    }
                }
            }
        },

        initFocusRedirect: function ($scope) {
            $scope.find('[data-mek-redirect-focus]').each(function () {
                var $this = $(this);
                var $focusable = $this.find(':focusable');
                var $last = $focusable.last();
                var $first = $focusable.first();
                var $target = $($this.data('mek-redirect-focus'));

                $target.on('keydown', function (ev) {
                    if ($this.is(':visible')) {

                        // tab
                        if (ev.which === 9 && !ev.shiftKey) {
                            ev.preventDefault();
                            $first.focus();
                        }

                        // shift + tab
                        if (ev.which === 9 && ev.shiftKey) {
                            ev.preventDefault();
                            $last.focus();
                        }
                    }
                });

                $last.on('keydown', function (ev) {
                    // tab and target is visible
                    if (ev.which === 9 && !ev.shiftKey && $target.is(':visible')) {
                        if ($target.is(':visible')) {
                            ev.preventDefault();
                            $target.focus();
                        }
                    }
                });

                $first.on('keydown', function (ev) {
                    // shift + tab and target is visible
                    if (ev.which === 9 && ev.shiftKey && $target.is(':visible')) {
                        ev.preventDefault();
                        $target.focus();
                    }
                });
            });
        },

        initToggle: function ($scope) {
            function _toggle(el) {
                var _expanded = el.attr('aria-expanded');
                var _target = $(el.data('mek-toggle-target'));
                _expanded = _expanded !== 'false' ? 'false' : 'true';

                _target.attr('aria-expanded', _expanded);
                el.attr('aria-expanded', _expanded);
                _target.toggle(300);
            }

            $scope.find('[data-mek-toggle="collapse"]').each(function () {
                $(this).on('click', function () {
                    _toggle($(this));
                });
            });
        },

        // Is Elementor Editor
        isEditor: function () {
            return !!$('body').hasClass('elementor-editor-active');
        },
    };

    $(window).on('elementor/frontend/init', MEK.init);

})(jQuery);
