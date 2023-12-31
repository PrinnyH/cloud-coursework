document.addEventListener('DOMContentLoaded', function() {
    // Function to open the overlay and set up form submission logic
    function openOverlay() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'login-form.html', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('loginOverlay').innerHTML = xhr.responseText;
                document.getElementById('loginOverlay').style.display = 'block';

                // Set event listener for the close button inside the overlay
                document.getElementById('close-login').addEventListener('click', function() {
                    document.getElementById('loginOverlay').style.display = 'none';
                });

                // Set up login form submission logic
                document.getElementById('loginForm').addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevent the default form submission
                    submitLoginForm();
                });
            }
        };
        xhr.send();
    }

    // Function to handle login form submission
    function submitLoginForm() {
        var xhr = new XMLHttpRequest();
        var formData = new FormData(document.getElementById('loginForm'));
        
        xhr.open('POST', 'login.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.status == 200) {
                if (this.responseText === 'true') {
                    window.location.href = 'storage.php'; // Redirect on success
                } else {
                    alert('Incorrect username or password.'); // Show error message
                }
            }
        };

        xhr.send(new URLSearchParams(formData).toString());
    }

    // Attach event listener to all login buttons
    var loginButtons = document.querySelectorAll('.login-button');
    loginButtons.forEach(function(button) {
        button.addEventListener('click', openOverlay);
    });

    // Set event listener for the logout button
    document.getElementById('logout').addEventListener('click', function() {
        window.location.href = 'index.php'; // Redirect
    });

});



