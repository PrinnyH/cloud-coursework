document.getElementById('loginButton').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'login-form.html', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById('loginOverlay').innerHTML = xhr.responseText;
            document.getElementById('loginOverlay').style.display = 'block';
        }
    };
    xhr.send();
});

