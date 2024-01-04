
function handleAddDirectory(button){
    var dirName = button.getAttribute('data-dir');
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/addDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
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

function handleDelete(button) {
    var dirName = button.getAttribute('data-dir');
    var confirmation = prompt("Type 'DELETE' to confirm.");

    if (confirmation !== "DELETE") {
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/deleteDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status === 200) {
            if (this.responseText.trim() === 'true') {
                loadDirectoryListing();
            } else {
                alert('There was a problem');
            }
        }
    };

    var params = new URLSearchParams();
    params.append('dirName', dirName);

    xhr.send(params);
    
}


const replaceLast = (fullString, toReplace, toReplaceWith) => {
    const match = typeof toReplace === 'string' ? toReplace : (fullString.match(new RegExp(toReplace.source, 'g')) || []).slice(-1)[0];
    if (!match) 
        return fullString;
    
    const last = fullString.lastIndexOf(match);
    return last !== -1 ? `${fullString.slice(0, last)}${toReplaceWith}${fullString.slice(last + match.length)}` : fullString;
  };

function handleNameChange(element, fullPath, fileExtension) {
    var newName = element.value;
    var isValidName = validateName(newName);
    element.style.borderColor = '';
    
    if (!isValidName) {
        // If the name is invalid, highlight the input and exit the function
        element.style.borderColor = 'red';
        alert('Invalid name. \nPlease ensure name: \nDoes not contain spaces or special characters (/,?*:"<>|) \nName is below 25 chracters');
        return;
    }

    var endsWithSlash = fullPath.endsWith('/');
    var names = fullPath.split("/");
    var oldName = names[names.length - 1] === "" ? names[names.length - 2] + "/" : names[names.length - 1];
    var basePath = replaceLast(fullPath, oldName, "");
    var newFullPath = basePath + newName + (endsWithSlash ? '/' : fileExtension);

    // console.log(fullPath);
    // console.log(basePath);
    // console.log(newFullPath);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/renameDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
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
    validName &= name.length <= 25;
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



function handleUploadFile(button) {
    var dirSelected = button.getAttribute('data-dir');
    var input = document.getElementById('fileInput');

    // Configure the input for file or folder selection
    input.onchange = function() {
        if (this.files.length > 0) {
            var formData = new FormData();
            formData.append('dirSelected', dirSelected);

            // Append each file to the FormData object
            for (var i = 0; i < this.files.length; i++) {
                formData.append('uploadedFiles[]', this.files[i]);
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'runnable/uploadFile.php', true);

            xhr.onload = function() {
                if (this.status === 200) {
                    if (this.responseText.trim() === 'true') {
                        loadDirectoryListing();
                    } else {
                        alert('There was a problem');
                    }
                }
            };

            xhr.send(formData);
        }
    };

    // Reset the input and trigger the file/folder input dialog
    input.value = '';
    input.click();
}

function handleUploadFolder(button) {
    var dirSelected = button.getAttribute('data-dir');
    var input = document.getElementById('folderInput');

    // Configure the input for file or folder selection
    input.onchange = function() {
        if (this.files.length > 0) {
            var formData = new FormData();
            formData.append('dirSelected', dirSelected);

            // Append each file and its relative path to the FormData object
            for (var i = 0; i < this.files.length; i++) {
                formData.append('uploadedFiles[]', this.files[i]);
                formData.append('filePaths[]', this.files[i].webkitRelativePath);
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'runnable/uploadFolder.php', true);

            xhr.onload = function() {
                if (this.status === 200) {
                    if (this.responseText.trim() === 'true') {
                        loadDirectoryListing();
                    } else {
                        alert('There was a problem');
                    }
                }
            };

            xhr.send(formData);
        }
    };

    // Reset the input and trigger the file/folder input dialog
    input.value = '';
    input.click();
}

function dragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.dataset.dir);
}

function dragOver(event) {
    event.preventDefault(); // Necessary to allow dropping
}

function drop(event) {
    event.preventDefault();
    var targetDir = event.currentTarget.dataset.dir; // The directory you dropped onto
    var draggedDir = event.dataTransfer.getData('text/plain'); // The directory being dragged

    // Trigger the method for rearranging
    handleMoveDirectory(draggedDir, targetDir);
}

function handleMoveDirectory(draggedDir, targetDir) {
    if (draggedDir == "undefined" ){
        return; //no possible root moving
    }

    var names = draggedDir.split("/");
    var name = names[names.length - 1] === "" ? names[names.length - 2] + "/" : names[names.length - 1];
    var newFullPath = targetDir + name 
    
    // console.log(draggedDir);
    // console.log(targetDir);
    // console.log(name);
    // console.log(newFullPath);

    if (newFullPath.startsWith(draggedDir) || newFullPath == draggedDir){
        // console.log("DENIED");
        return; //no possible self childing
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/renameDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                loadDirectoryListing();
            } else {
                alert('There was a problem');
            } 
        }
    };
    
    var params = new URLSearchParams();
    params.append('oldDir', draggedDir);
    params.append('newDir', newFullPath);
    
    xhr.send(params);
}


function loadDirectoryListing() {
    var xhr = new XMLHttpRequest();
    
    xhr.open('POST', 'runnable/loadDirectoryListing.php', true);
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

function createSharedDirectoryListing(){
    var folderName = window.prompt("Please enter the folder name:", "");
    if (!validateName(folderName)) {
        alert('Invalid name. \nPlease ensure name: \nDoes not contain spaces or special characters (/,?*:"<>|) \nName is below 25 chracters');
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/createSharedDirectory.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                populateFolderDropDown();
            } else {
                alert("There was a problem creating folder")
            } 
        }
    };

    var params = new URLSearchParams();
    params.append('folderName', folderName);
    
    xhr.send(params);
}


function populateFolderDropDown(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/loadSharedDirectories.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('sharedFolderSelector').innerHTML = this.responseText;
        } else {
            console.error('Error loading directory listing');
        }
    };
    
    xhr.send();
}

function loadSharedDirectoryListing(button) {
    var bucketSelected = button.getAttribute('data-id');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/loadDirectoryListing.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('directoryListing').innerHTML = this.responseText;
        } else {
            console.error('Error loading directory listing');
        }
    };
    
    var params = new URLSearchParams();
    params.append('BucketID', bucketSelected);
    
    xhr.send(params);
};