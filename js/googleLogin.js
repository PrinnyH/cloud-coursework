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

window.onload = function () {
    google.accounts.id.initialize({
        client_id: '23146911805-tuefejed4hddunmos49sph1jgvub608o.apps.googleusercontent.com',
        callback: handleCredentialResponse
    });
    google.accounts.id.initialize(
        document.getElementById('googleSignIn')
    );
    
    google.accounts.id.renderButton(
        document.getElementById('googleSignIn'),
        { theme: 'outline', size: 'large' }  // customization attributes
    );
    //google.accounts.id.prompt(); // Display the One Tap sign-in prompt
};