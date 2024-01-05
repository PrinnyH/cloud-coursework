/**
 * Sets a cookie in the browser.
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value of the cookie.
 * @param {number} days - The number of days until the cookie expires.
 * @param {string} [sameSite='/'] - The SameSite attribute of the cookie.
 */
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

/**
 * Handles the response received from the credential service Google Sign-In.
 * @param {Object} response - The response object received from the authentication service.
 */
function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/googleAuthenticateLogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            var responseData = JSON.parse(this.responseText);

            if (responseData.success) {
                // Save the token to a cookie and continue logging in/ sign up
                setCookie('auth_token', responseData.token, 365);
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

/**
 * Checks if a user exists in the database.
 */
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

/**
 * Creates a new user and assigns a bucket to them.
 */
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

/**
 * Retrieves the associated bucket for the current user.
 */
function getAssosiatedBucket() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/getPersonalBucketID.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status == 200) {
            try {
                var response = JSON.parse(this.responseText);

                if (response.success) {
                    // Store the new cookie values
                    document.cookie = 'auth_token=' + response.updatedToken + '; expires=' + new Date(response.expiry).toUTCString() + '; path=/';
                    // proceed to vaults page
                    window.location.href = 'storage.html';
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

