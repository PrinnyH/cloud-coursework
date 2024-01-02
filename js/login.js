function createTestBucket(){
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure it: POST-request for the URL /process.php
    xhr.open('POST', 'process.php', true);

    // This function will be called when the request is complete
    xhr.onload = function() {
        if (xhr.status == 200) {
            // The request was successful, update the output element with the response
            document.getElementById('output').innerHTML = xhr.responseText;
        } else {
            // There was an error with the request
            console.error('Request failed. Status: ' + xhr.status);
            document.getElementById('output').innerHTML = 'Request failed. Status: ' + xhr.status;
        }
    };

    // This function will be called if an error occurs
    xhr.onerror = function() {
        console.error('Network error occurred');
        document.getElementById('output').innerHTML = 'Network error occurred'
    };

    // Send the request
    xhr.send();

    alert("Bucket created");
}


function readTestBucket(){
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Configure it: POST-request for the URL /process.php
    xhr.open('POST', 'readProcess.php', true);

    // This function will be called when the request is complete
    xhr.onload = function() {
        if (xhr.status == 200) {
            // The request was successful, update the output element with the response
            document.getElementById('output2').innerHTML = xhr.responseText;
        } else {
            // There was an error with the request
            console.error('Request failed. Status: ' + xhr.status);
            document.getElementById('output2').innerHTML = 'Request failed. Status: ' + xhr.status;
        }
    };

    // This function will be called if an error occurs
    xhr.onerror = function() {
        console.error('Network error occurred');
        document.getElementById('output2').innerHTML = 'Network error occurred'
    };

    // Send the request
    xhr.send();
}
