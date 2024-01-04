function setCookie(name, value, days, sameSite = '/') {
    var expires = '';
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = '; expires=' + date.toUTCString();
    }
    
    var cookieString = name + '=' + value + expires + '; path=/; SameSite=' + sameSite;

    // For secure cookies, include 'Secure' attribute
    if (window.location.protocol === 'https:') {
        cookieString += '; Secure';
    }

    document.cookie = cookieString;
}

function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/googleAuthenticateLogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            // Assuming the server response is a JSON object
            var responseData = JSON.parse(this.responseText);

            if (responseData.success) {
                // Save the token to a cookie
                setCookie('auth_token', responseData.token, 365); // Adjust the expiry days as needed

                // Now you can proceed with further actions
                checkUserExists();
            } else {
                alert('There was a problem: ' + responseData.message);
            }
        }
    };

    var params = new URLSearchParams();
    params.append('idtoken', response.credential);

    xhr.send(params);
}

function checkUserExists(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/checkUserExists.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                getAssosiatedBucket();
            } else {
                createUserAndAssignBucket();
            } 
        }
    };
    
    xhr.send();
}

function createUserAndAssignBucket(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/addUserAndCreateBucket.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                getAssosiatedBucket();
            } else {
                alert("There was a problem creating Vault");
            } 
        }
    };

    xhr.send();
}

function getAssosiatedBucket() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/getPersonalBucketID.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var response = JSON.parse(this.responseText);

                if (response.success) {
                    // Store the new cookie values in your preferred way
                    document.cookie = 'auth_token=' + response.updatedToken + '; expires=' + new Date(response.expiry).toUTCString() + '; path=/';

                    // Redirect to 'storage.php' or perform other actions
                    window.location.href = 'storage.php';
                } else {
                    alert("There was an issue getting Vault: " + response.message);
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        }
    };

    xhr.send();
}