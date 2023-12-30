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