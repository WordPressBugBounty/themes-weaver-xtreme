/**
 *	Version 3.0
 */

(function($) {

    var customControls;
    //$('#save').before('Get Weaver Xtreme Plus');
    /**
     *
     */
    customControls = {
        cache: {},

        init: function() {
            // Populate cache
            this.cache.$buttonset = $('.weaverx-control-buttonset, .weaverx-control-image');
            this.cache.$bgposition = $('.weaverx-control-background-position');
            this.cache.$range = $('.weaverx-control-range');

            // Initialize Button sets
            if (this.cache.$buttonset.length > 0) {
                this.buttonset();
            }

            // Initialize Background Position
            if (this.cache.$bgposition.length > 0) {
                this.bgposition();
            }

            // Initialize ranges
            if (this.cache.$range.length > 0) {
                this.range();
            }
        },

        //
        buttonset: function() {
            this.cache.$buttonset.buttonset();
        },

        //
        bgposition: function() {
            // Initialize button sets
            this.cache.$bgposition.buttonset({
                create: function(event) {
                    var $control = $(event.target),
                        $positionButton = $control.find('label'),
                        $caption = $control.parent().find('.background-position-caption');

                    $positionButton.on('click', function() {
                        var label = $(this).data('label');
                        $caption.text(label);
                    });
                }
            });
        },

        //
        range: function() {
            this.cache.$range.each(function() {
                var $input = $(this),
                    $slider = $input.parent().find('.weaverx-range-slider'),
                    value = parseFloat($input.val()),
                    min = parseFloat($input.attr('min')),
                    max = parseFloat($input.attr('max')),
                    step = parseFloat($input.attr('step'));

                $slider.slider({
                    value: value,
                    min: min,
                    max: max,
                    step: step,
                    slide: function(e, ui) {
                        $input.val(ui.value).keyup().trigger('change');
                    }
                });
                $input.val($slider.slider('value'));
            });
        }
    };

    // Load font choices after Customizer initialization is complete.
    $(document).ready(function() {
        customControls.init();

    });
    /*wp.customize.previewer.bind( 'refresh', function() {
    	wp.customize.previewer.refresh();
    } ); */

})(jQuery);
