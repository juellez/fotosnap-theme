// DOM Ready
jQuery(document).ready(function ($) {

    // GOOGLE ANALYTICS TRACKING
    // track nav + footer
    $('body').delegate('#primary-menu a', 'click', function(e) {
        // e.preventDefault();
        // e.stopPropagation();
        var eventLabel = $(this).text();
        var eventCategory = "nav";
        var eventAction = "clicks top nav item";
        ga('send', 'event', eventCategory, eventAction, eventLabel);
        return true;
    });
    $('body').delegate('#authica-social a', 'click', function(e) {
        var eventLabel = $(this).attr('class');
        var eventCategory = "nav";
        var eventAction = "clicks footer social icon";
        ga('send', 'event', eventCategory, eventAction, eventLabel);
        return true;
    });
    $('body').delegate('#footer-menu a', 'click', function(e) {
        var eventLabel = $(this).text();
        var eventCategory = "nav";
        var eventAction = "clicks footer nav item";
        ga('send', 'event', eventCategory, eventAction, eventLabel);
        return true;
    });

    // track clicks on elements with GA tracking intent
    $('body').delegate('.ga-track', 'click', function() {
        var targetEventElement = $(this);
        gatherGoogleAnalyticsTrackingData(targetEventElement);
    });
    $('body').delegate('.ga-track a', 'click', function() {
        var targetEventElement = $(this);
        gatherGoogleAnalyticsTrackingData(targetEventElement);
    });
    function gatherGoogleAnalyticsTrackingData(targetEventElement) {
        // eventCategory should be high level organizational terms e.g. (perks, listings, cities, main navigation, list item, etc) - best practice is to look for existing usage as reference.
        var eventCategory = targetEventElement.attr('data-track-event-category');

        // eventCategory should be the action that results from the event e.g. (shown listing, signs out, shown password modal, etc) - best practice is to look for existing usage as reference.
        var eventAction = targetEventElement.attr('data-track-event-action');

        // eventLabel should be the important/unique identifier e.g. (perk ID, url, partner ID, etc) - best practice is to look for existing usage as reference. Not every trackable event will have a eventLabel.
        var eventLabel = targetEventElement.attr('data-track-event-label');

        // eventValue should must be a number and is typically used for conversion value.
        var eventValue = targetEventElement.attr('data-track-event-value');

        // we check to see what we have and then set eventLabel based on what we find. if we have no valid eventLabel, we define it as n/a.
        if (eventLabel === undefined){
            if (targetEventElement.attr('href') !== '' && targetEventElement.attr('href') !== '#'){
                eventLabel = targetEventElement.attr('href');
            } else {
                eventLabel = 'n/a';
            }
        }
        // we check to make sure our required data-track-event-category is present before sending to google land.
        if (targetEventElement.is("[data-track-event-category]")){
            // we want to check to see if there is an event value. if not we don't send one. if there is - we do. simple.
            if (eventValue !== undefined) {
                eventValue = targetEventElement.attr('data-track-event-value');
                ga('send', 'event', eventCategory, eventAction, eventLabel, eventValue);
            } else {
                ga('send', 'event', eventCategory, eventAction, eventLabel);
            }
        }
    }

});