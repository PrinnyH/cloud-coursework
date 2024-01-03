
function handleAddDirectory(button){
    var dirName = button.getAttribute('data-dir');
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'addDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
                loadDirectoryListing();
            } else {
                alert('There was a problem');
            } 
        }
    };
    
    var params = new URLSearchParams();
    params.append('dirName', dirName);
    
    xhr.send(params);
};

function handleDelete(button){
    var dirName = button.getAttribute('data-dir');
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'deleteDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText === 'true') {
                loadDirectoryListing();
            } else {
                alert('There was a problem');
            } 
        }
    };
    
    var params = new URLSearchParams();
    params.append('dirName', dirName);
    
    xhr.send(params);
};

function handleNameChange(element, fullPath) {
    var newName = element.value;
    // fullPath contains the original full path of the file/directory
    // newName contains the new name as edited by the user

    console.log("New name for " + fullPath + " is " + newName);
    // Add your logic to handle the name change
}


function handleUploadFile(button){
    var dirName = button.getAttribute('data-dir');
    console.log("Button clicked for directory: " + dirName);
};


function loadDirectoryListing() {
    var xhr = new XMLHttpRequest();
    
    xhr.open('POST', 'loadDirectoryListing.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('directoryListing').innerHTML = this.responseText;
        } else {
            console.error('Error loading directory listing');
        }
    };
    
    xhr.send();
};

document.addEventListener('DOMContentLoaded', function() {
    loadDirectoryListing();
});