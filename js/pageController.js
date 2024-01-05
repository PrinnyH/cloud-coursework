/**
 * Hides the navigation side panel.
 */
function hideNav(){
    $('.sideNav').animate({width:"50"});
    document.getElementById('sideNavExpanded').style.display = 'none';
    document.getElementById('sideNavMin').style.display = 'block';
}

/**
 * Shows the navigation side panel.
 */
function showNav(){
    $('.sideNav').animate({width:"250"});
    document.getElementById('sideNavExpanded').style.display = 'block';
    document.getElementById('sideNavMin').style.display = 'none';
}

/**
 * Sets up event listeners once the DOM content is fully loaded.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Attach event listener to all login buttons
    var hideNavButtons = document.querySelectorAll('.hide-nav-button');
    hideNavButtons.forEach(function(button) {
        button.addEventListener('click', hideNav);
    });

    // Attach event listener to all login buttons
    var showNavButtons = document.querySelectorAll('.show-nav-button');
    showNavButtons.forEach(function(button) {
        button.addEventListener('click', showNav);
    });
});