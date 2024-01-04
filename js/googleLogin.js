function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/googleAuthenticateLogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                checkUserExists();
            } else {
                alert('There was a problem');
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

function getAssosiatedBucket(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/getPersonalBucketID.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                window.location.href = 'storage.php';
            } else {
                alert("There was a getting Vault");
            } 
        }
    };
    
    xhr.send();
}