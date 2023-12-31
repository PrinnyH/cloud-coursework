document.addEventListener('DOMContentLoaded', function() {
    // Function to open the overlay
    function openOverlay() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'login-form.html', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('loginOverlay').innerHTML = xhr.responseText;
                document.getElementById('loginOverlay').style.display = 'block';

                // Set event listener for the close button inside the overlay
                document.getElementById('closeLoginButton').addEventListener('click', function() {
                    document.getElementById('loginOverlay').style.display = 'none';
                });
            }
        };
        xhr.send();
    }

    // Attach event listener to all login buttons
    var loginButtons = document.querySelectorAll('.login-button');
    loginButtons.forEach(function(button) {
        button.addEventListener('click', openOverlay);
    });
});


// Function to close the overlay
function closeOverlay() {
    document.getElementById('loginOverlay').style.display = 'none';
}