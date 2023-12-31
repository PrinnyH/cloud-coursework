document.addEventListener('DOMContentLoaded', function () {
    // Function to open the overlay
    function openOverlay() {
        document.getElementById('loginOverlay').style.display = 'block';
    }

    // Function to close the overlay
    function closeOverlay() {
        document.getElementById('loginOverlay').style.display = 'none';
    }

    // Attaching event listeners to the login and close buttons
    document.getElementById('loginButton').addEventListener('click', openOverlay);
    // Assuming there's a close button within your overlay
    document.getElementById('closeButton').addEventListener('click', closeOverlay);

    // Handling the form submission
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status == 200) {
                if (this.responseText === 'success') {
                    window.location.href = 'storage.php'; // Redirect on successful login
                } else {
                    document.getElementById('loginError').style.display = 'block';
                    document.getElementById('loginError').textContent = 'Login failed: Incorrect username or password.';
                }
            }
        };

        var formData = new FormData(document.getElementById('loginForm'));
        xhr.send(new URLSearchParams(formData).toString());
    });
});

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
    console.log('Name: ' + profile.getName());
    console.log('Image URL: ' + profile.getImageUrl());
    console.log('Email: ' + profile.getEmail());

    // The ID token you need to pass to your backend:
    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);
}