function handleCredentialResponse(response) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/googleAuthenticateLogin.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
                // check have registered
                if (!checkUserExists()){
                    // if no register and create bucket for them
                    return;
                    createUserAndAssignBucket();
                }
                // if yes skip
                // get bucketID with email
                getAssosiatedBucket();
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

function checkUserExists(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/checkUserExists.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
                return true;
            } else {
                return false;
            } 
        }
    };
    
    xhr.send();
}


function createUserAndAssignBucket(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/assuserAndCreateBucket.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
               return;
            } else {
                alert("There was a problem.");
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
                return;
            } else {
                alert("There was a problem.");
            } 
        }
    };
    
    xhr.send();
}