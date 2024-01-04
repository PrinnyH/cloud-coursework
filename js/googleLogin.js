function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/googleAuthenticateLogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
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
            if (this.responseText === 'true') {
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
            if (this.responseText === 'true') {
                getAssosiatedBucket();
            } else {
                alert("shouldnt be here yet");
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
            if (this.responseText === 'true') {
                window.location.href = 'storage.php';
            } else {
                alert("There was a problem.");
            } 
        }
    };
    
    xhr.send();
}