function hideNav(){
    $('.sideNav').animate({width:"50"});
    document.getElementById('sideNavExpanded').style.display = 'none';
    document.getElementById('sideNavMin').style.display = 'block';
}

function showNav(){
    $('.sideNav').animate({width:"250"});
    document.getElementById('sideNavExpanded').style.display = 'block';
    document.getElementById('sideNavMin').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Attach event listener to all login buttons
    var hideNaveButtons = document.querySelectorAll('.hide-nav-button');
    hideNaveButtons.forEach(function(button) {
        button.addEventListener('click', hideNav);
    });

    // Attach event listener to all login buttons
    var hideNaveButtons = document.querySelectorAll('.show-nav-button');
    hideNaveButtons.forEach(function(button) {
        button.addEventListener('click', showNav);
    });
});







