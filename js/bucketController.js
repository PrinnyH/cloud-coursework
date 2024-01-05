
/**
 * Handles the addition of a new directory.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
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

/**
 * Handles the deletion of a directory.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
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

/**
 * Replaces the last occurrence of a substring in a string.
 * @param {string} fullString - The full string to modify.
 * @param {(string|RegExp)} toReplace - The substring or regex to replace.
 * @param {string} toReplaceWith - The string to replace with.
 * @returns {string} - The modified string.
 */
const replaceLast = (fullString, toReplace, toReplaceWith) => {
    const match = typeof toReplace === 'string' ? toReplace : (fullString.match(new RegExp(toReplace.source, 'g')) || []).slice(-1)[0];
    if (!match) 
        return fullString;

    const last = fullString.lastIndexOf(match);
    return last !== -1 ? `${fullString.slice(0, last)}${toReplaceWith}${fullString.slice(last + match.length)}` : fullString;
};

/**
 * Handles the change of a directory or file name.
 * @param {HTMLInputElement} element - The input element containing the new name.
 * @param {string} fullPath - The full path of the item being renamed.
 * @param {string} fileExtension - The file extension (if applicable).
 */
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

/**
 * Validates the provided name for a directory or file.
 * @param {string} name - The name to validate.
 * @returns {boolean} - True if the name is valid, false otherwise.
 */
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

/**
 * Handles the download of a file.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
function handleDownloadFile(button) {
    var dirSelected = button.getAttribute('data-dir');

    // Create a temporary hidden link element
    var tempLink = document.createElement('a');
    tempLink.style.display = 'none';
    tempLink.href = 'runnable/downloadFile.php?fileDir=' + encodeURIComponent(dirSelected);

    // Append link to the body and trigger the download
    document.body.appendChild(tempLink);
    tempLink.click();

    // Clean up by removing the temporary link
    document.body.removeChild(tempLink);
}

/**
 * Handles the download of a folder.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
function handleDownloadFolder(button) {
    var dirSelected = button.getAttribute('data-dir');

    // Create a temporary hidden link element
    var tempLink = document.createElement('a');
    tempLink.style.display = 'none';
    tempLink.href = 'runnable/downloadFolder.php?folderPath=' + encodeURIComponent(dirSelected);

    // Append link to the body and trigger the download
    document.body.appendChild(tempLink);
    tempLink.click();

    // Clean up by removing the temporary link
    document.body.removeChild(tempLink);
}

/**
 * Handles the uploading of a file.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
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

/**
 * Handles the uploading of a folder.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
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

/**
 * Handles the start of a drag operation.
 * @param {DragEvent} event - The drag event.
 */
function dragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.dataset.dir);
}

/**
 * Handles the drag over event, allowing for drop.
 * @param {DragEvent} event - The drag event.
 */
function dragOver(event) {
    event.preventDefault(); // Necessary to allow dropping
}

/**
 * Handles the drop event for moving directories.
 * @param {DragEvent} event - The drag event.
 */
function drop(event) {
    event.preventDefault();
    var targetDir = event.currentTarget.dataset.dir; // The directory you dropped onto
    var draggedDir = event.dataTransfer.getData('text/plain'); // The directory being dragged

    // Trigger the method for rearranging
    handleMoveDirectory(draggedDir, targetDir);
}

/**
 * Handles moving a directory to a new location.
 * @param {string} draggedDir - The directory being moved.
 * @param {string} targetDir - The target directory where the dragged directory will be moved.
 */
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

/**
 * Loads the directory listing.
 */
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

/**
 * Creates a shared directory listing.
 */
function createSharedDirectoryListing(){
    var folderName = window.prompt("Please enter the folder name:", "");
    //cancelled
    if (folderName === null)
        return;

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

/**
 * Populates the dropdown menu with available shared folders.
 */
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

/**
 * Loads the listing of a selected shared directory.
 * @param {HTMLElement} button - The button element that triggered this function.
 */
function loadSharedDirectoryListing(button) {
    var bucketSelected = button.getAttribute('data-id');
    document.getElementById("selectedBucket").setAttribute('selected-bucket', bucketSelected);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/loadSelectedSharedDirectory.php', true);
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

/**
 * Adds a user to a shared directory.
 */
function addUser(){
    var selectedBucket = document.getElementById("selectedBucket").getAttribute('selected-bucket');
    
    var email = window.prompt("Please enter the email to add:", "");

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/addSharedUserToBucket.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                return;
            } else {
                alert("There was a problem adding email")
            }
        }
    };

    var params = new URLSearchParams();
    params.append('given-email', email);
    params.append('given-bucketID', selectedBucket);
    
    xhr.send(params);
}

/**
 * Removes a user from a shared directory.
 */
function removeUser(){
    var selectedBucket = document.getElementById("selectedBucket").getAttribute('selected-bucket');
    
    var email = window.prompt("Please enter the email to remove:", "");

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'runnable/removeSharedUserToBucket.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.trim() === 'true') {
                return;
            } else {
                alert("There was a problem removing email")
            }
        }
    };

    var params = new URLSearchParams();
    params.append('given-email', email);
    params.append('given-bucketID', selectedBucket);
    
    xhr.send(params);
}