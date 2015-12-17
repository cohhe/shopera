jQuery(document).ready(function() {
    var shopera_aboutpage = shoperaWelcomeScreenCustomizerObject.aboutpage;
    var shopera_nr_actions_required = shoperaWelcomeScreenCustomizerObject.nr_actions_required;

    /* Number of required actions */
    if ((typeof shopera_aboutpage !== 'undefined') && (typeof shopera_nr_actions_required !== 'undefined') && (shopera_nr_actions_required != '0')) {
        jQuery('#accordion-section-themes .accordion-section-title').append('<a href="' + shopera_aboutpage + '"><span class="welcome-screen-actions-count">' + shopera_nr_actions_required + '</span></a>');
    }

    /* Upsell in Customizer (Link to Welcome page) */
    if ( !jQuery( ".shopera-upsells" ).length ) {
        jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section shopera-upsells">');
    }
    if (typeof shopera_aboutpage !== 'undefined') {
        jQuery('.shopera-upsells').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="' + shopera_aboutpage + '" class="button" target="_blank">{themeinfo}</a>'.replace('{themeinfo}', shoperaWelcomeScreenCustomizerObject.themeinfo));
    }
    if ( !jQuery( ".shopera-upsells" ).length ) {
        jQuery('#customize-theme-controls > ul').prepend('</li>');
    }
});