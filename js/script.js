function openOverlay() {
    var overlay = document.getElementById("loginOverlay");
    overlay.style.display = "block";
    loadLoginForm();
}

function closeOverlay() {
    document.getElementById("loginOverlay").style.display = "none";
}

function loadLoginForm() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("loginOverlay").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "login-form.html", true);
    xhr.send();
}

document.getElementById("loginButton").onclick = function() {
    openOverlay();
};

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('loginForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'login.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (this.status == 200) {
                if (this.responseText === 'success') {
                    window.location.href = 'storage.php'; // Redirect on success
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