
//document.getElementById("login_button").onclick = doFunction;

function login(){
    window.location.href = "storage.php";
}

function logout(){
    window.location.href = "index.php";
}

function uploadFile(){
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure it: GET-request for the URL /process.php
    xhr.open('GET', 'process.php', true);

    // This function will be called when the request is complete
    xhr.onload = function() {
        if (xhr.status == 200) {
            // The request was successful, update the output element with the response
            document.getElementById('output').innerHTML = xhr.responseText;
        } else {
            // There was an error with the request
            console.error('Request failed. Status: ' + xhr.status);
        }
    };

    // This function will be called if an error occurs
    xhr.onerror = function() {
        console.error('Network error occurred');
    };

    // Send the request
    xhr.send();



    alert("Bucket created");
}
