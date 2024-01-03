document.addEventListener('DOMContentLoaded', function() {
    // Function to open the overlay and set up form submission logic
    function openOverlay() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login-form.html', true);
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

    function handleCredentialResponse(googleUser) {
        var id_token = googleUser.getAuthResponse().id_token;
    
        fetch('/auth/google-auth.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ token: id_token })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = 'storage.php'; 
                console.log('User email: ' + data.email);
                // Redirect or update UI
            } else {
                console.error('Error:', data.message);
            }
        });
    }
    



    function logout(){
        window.location.href = 'index.html'; // Redirect
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut();
        
        //close session here
    }

    // Attach event listener to all login buttons
    var logoutButtons = document.querySelectorAll('.logout-button');
    logoutButtons.forEach(function(button) {
        button.addEventListener('click', logout);
    });

    function hideNav(){
        $('.sideNav').animate({width:"50"});
        document.getElementById('sideNavExpanded').style.display = 'none';
        document.getElementById('sideNavMin').style.display = 'block';
    }

    // Attach event listener to all login buttons
    var hideNaveButtons = document.querySelectorAll('.hide-nav-button');
    hideNaveButtons.forEach(function(button) {
        button.addEventListener('click', hideNav);
    });

    function showNav(){
        $('.sideNav').animate({width:"250"});
        document.getElementById('sideNavExpanded').style.display = 'block';
        document.getElementById('sideNavMin').style.display = 'none';
    }
    // Attach event listener to all login buttons
    var hideNaveButtons = document.querySelectorAll('.show-nav-button');
    hideNaveButtons.forEach(function(button) {
        button.addEventListener('click', showNav);
    });

});



