
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

function handleNameChange(element, fullPath, fileExtension) {
    var newName = element.value;
    var isValidName = validateName(newName);
    element.style.borderColor = '';
    
    if (!isValidName) {
        // If the name is invalid, highlight the input and exit the function
        element.style.borderColor = 'red';
        alert('Invalid name. Please ensure the name does not contain spaces or special characters (/,?*:"<>|)');
        return;
    }

    var endsWithSlash = fullPath.endsWith('/');
    var basePath = fullPath.substring(0, fullPath.lastIndexOf('/') + 1);
    var newFullPath = basePath + newName + (endsWithSlash ? '/' : fileExtension);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'moveDirectory.php', true);
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
    params.append('oldDir', fullPath);
    params.append('newDir', newFullPath);
    
    xhr.send(params);
}

function validateName(name) {
    var validName = true;
    validName &= name.trim() !== '';
    validName &= !name.includes(' ');
    validName &= !name.includes('/');
    validName &= !name.includes(',');
    validName &= !name.includes('?');
    validName &= !name.includes('*');
    validName &= !name.includes(':');
    validName &= !name.includes('"');
    validName &= !name.includes('<');
    validName &= !name.includes('>');
    validName &= !name.includes('|');
    return  validName;
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