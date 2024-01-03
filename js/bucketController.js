
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

const replaceLast = (str, pattern, replacement) => {
    const match =
      typeof pattern === 'string'
        ? pattern
        : (str.match(new RegExp(pattern.source, 'g')) || []).slice(-1)[0];
    if (!match) return str;
    const last = str.lastIndexOf(match);
    return last !== -1
      ? `${str.slice(0, last)}${replacement}${str.slice(last + match.length)}`
      : str;
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
    var names = fullPath.split("/");
    var oldName = names[names.length - 1] === "" ? names[names.length - 2] + "/" : names[names.length - 1];
    var basePath = replaceLast(fullPath, oldName, "");
    var newFullPath = basePath + newName + (endsWithSlash ? '/' : fileExtension);

    console.log(fullPath);
    console.log(basePath);
    console.log(newFullPath);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'renameDirectory.php', true);
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
    return validName;
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