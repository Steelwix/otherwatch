$('.cnt').show();

jQuery(function () {
    jQuery('#showall').click(function () {
        jQuery('.targetDiv').show();
    });
    jQuery('.showSingle').click(function () {
        jQuery('.targetDiv').hide();

        jQuery('.cnt').show();
        jQuery('.role' + $(this).attr('target')).show();


    });
});