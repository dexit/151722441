/*
 * MWS Admin v2.1 - Widgets Demo JS
 * This file is part of MWS Admin, an Admin template build for sale at ThemeForest.
 * All copyright to this file is hold by Mairel Theafila <maimairel@yahoo.com> a.k.a nagaemas on ThemeForest.
 * Last Updated:
 * December 08, 2012
 *
 */

;(function( $, window, document, undefined ) {

    $(document).ready(function() {

        // jQuery-UI Slider
        if( $.fn.slider ) {
            $(".dln-slider").slider({ range: "min", tooltip: false });

            $(".dln-tooltip-slider").slider({
                range: "min", 
                value: 33
            });

            $(".dln-range-slider").slider({
                range: true,
                min: 0,
                max: 500, 
                tooltip: false, 
                values: [75, 300]
            });

            $(".dln-ticks-slider").slider({
                range: "min", 
                min: 0,
                max: 100,
                value: 65, 
                ticks: [0, '|', 20, '|', 40, '|', 60, '|', 80, '|', 100]
            });

            $(".dln-slider-vertical").slider({
                orientation: "vertical",
                range: "min",
                min: 0,
                max: 100,
                value: 60
            });

            $("#eq > span").each(function () {
                // read initial values from markup and remove that
                var value = parseInt($(this).text(), 10);
                $(this).empty().slider({
                    value: value,
                    range: "min",
                    animate: true,
                    orientation: "vertical"
                });
            });
        }

        // jQuery-UI Progressbar
        if( $.fn.progressbar ) {
            $(".dln-progressbar").progressbar({ value: 37 });

            $(".dln-progressbar-val").progressbar({ value: 56, showValue: true });
        }

        if( $.fn.button ) {
            $(".dln-ui-button").button();

            $("#dln-ui-button-radio").buttonset();
            $("#dln-ui-button-cb").buttonset();

            $("#dln-ui-button-icon button:first").button({
                icons: {
                    primary: "ui-icon-locked"
                },
                text: false
            }).next().button({
                icons: {
                    primary: "ui-icon-locked"
                }
            }).next().button({
                icons: {
                    primary: "ui-icon-gear",
                    secondary: "ui-icon-triangle-1-s"
                }
            }).next().button({
                icons: {
                    primary: "ui-icon-gear",
                    secondary: "ui-icon-triangle-1-s"
                },
                text: false
            });
        }

        // jQuery-UI Accordion
        $.fn.accordion && $(".dln-accordion").accordion();

        // jQuery-UI Tabs
        $.fn.tabs && $(".dln-tabs").tabs();

        // jQuery-UI Datepicker
        if( $.fn.datepicker ) {
            $(".dln-datepicker").datepicker({
                showOtherMonths: true
            });

            $(".dln-datepicker-wk").datepicker({
                showOtherMonths: true,
                showWeek: true
            });

            $(".dln-datepicker-mm").datepicker({
                showOtherMonths: true,
                numberOfMonths: 3
            });

            $( "#dln-datepicker-from" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3,
                showOtherMonths: true,
                onSelect: function( selectedDate ) {
                    $( "#dln-datepicker-to" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( "#dln-datepicker-to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3,
                showOtherMonths: true,
                onSelect: function( selectedDate ) {
                    $( "#dln-datepicker-from" ).datepicker( "option", "maxDate", selectedDate );
                }
            });

            if( $.fn.timepicker ) {
                $(".dln-dtpicker").datetimepicker();

                $(".dln-tpicker").timepicker({});
            }
        }

        // imgAreaSelect
        if( $.fn.imgAreaSelect ) {
            $(".dln-crop-target").imgAreaSelect({
                handles: true,
                x1: 32,
                y1: 32,
                x2: 132,
                y2: 132,
                onSelectChange: function (img, selection) {
                    $("#crop_x1").val(selection.x1);
                    $("#crop_y1").val(selection.y1);
                    $("#crop_x2").val(selection.x2);
                    $("#crop_y2").val(selection.y2);
                }
            });
        }

        // jQuery-UI Dialog
        if( $.fn.dialog ) {
            $("#dln-jui-dialog").dialog({
                autoOpen: false,
                title: "jQuery-UI Dialog",
                modal: true,
                width: "640",
                buttons: [{
                    text: "Close Dialog",
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
            });
            $("#dln-form-dialog").dialog({
                autoOpen: false,
                title: "jQuery-UI Modal Form",
                modal: true,
                width: "640",
                buttons: [{
                    text: "Submit",
                    click: function () {
                        $(this).find('form#dln-validate').submit();
                    }
                }]
            });
            $("#dln-jui-dialog-btn").bind("click", function (event) {
                $("#dln-jui-dialog").dialog("option", {
                    modal: false
                }).dialog("open");
                event.preventDefault();
            });
            $("#dln-jui-dialog-mdl-btn").bind("click", function (event) {
                $("#dln-jui-dialog").dialog("option", {
                    modal: true
                }).dialog("open");
                event.preventDefault();
            });
            $("#dln-form-dialog-mdl-btn").bind("click", function (event) {
                $("#dln-form-dialog").dialog("option", {
                    modal: true
                }).dialog("open");
                event.preventDefault();
            });
        }

        // jGrowl Notifications
        if( $.fn.jGrowl ) {
            $("#dln-growl-btn").bind("click", function (event) {
                $.jGrowl("Hello World!", {
                    position: "bottom-right"
                });
            });

            $("#dln-growl-btn-1").bind("click", function (event) {
                $.jGrowl("A sticky message", {
                    sticky: true,
                    position: "bottom-right"
                });
            });

            $("#dln-growl-btn-2").bind("click", function (event) {
                $.jGrowl("Message with Header", {
                    header: "Important!",
                    position: "bottom-right"
                });
            });
        }

        if( $.fn.spinner ) {
            $('.dln-spinner').spinner({
                step: 0.01,
                numberFormat: "n"
            });
        }

        // Validation
        if( $.validator ) {
            $("#dln-validate").validate({
                rules: {
                    spinner: {
                        required: true,
                        max: 5
                    }
                },
                invalidHandler: function (form, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors == 1 ? 'You missed 1 field. It has been highlighted' : 'You missed ' + errors + ' fields. They have been highlighted';
                        $("#dln-validate-error").html(message).show();
                    } else {
                        $("#dln-validate-error").hide();
                    }
                }
            });
        }
    });

}) (jQuery, window, document);