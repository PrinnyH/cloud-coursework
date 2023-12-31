document.getElementById('loginButton').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'login-form.html', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('loginOverlay').innerHTML = xhr.responseText;
            document.getElementById('loginOverlay').style.display = 'block';

            // Set event listener for the close button
            document.getElementById('closeLoginButton').addEventListener('click', function() {
                document.getElementById('loginOverlay').style.display = 'none';
            });
        }
    };
    xhr.send();
});


// Function to close the overlay
function closeOverlay() {
    document.getElementById('loginOverlay').style.display = 'none';
}