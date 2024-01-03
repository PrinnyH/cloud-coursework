function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/googleAuthenticateLogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
                window.location.href = 'storage.php';
            } else {
                alert('There was a problem');
            } 
        }
    };
    
    var params = new URLSearchParams();
    params.append('idtoken', response.credential);
    
    xhr.send(params);
}