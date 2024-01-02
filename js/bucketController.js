document.addEventListener('DOMContentLoaded', function() {
    
    function handleAddDirectory(){
        var dirName = button.getAttribute('data-dir');
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addDirectory.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.status == 200) {
                if (this.responseText === 'true') {
                    //reload page here
                } else {
                    alert('There was a problem');
                } 
            }
        };
        
        var params = new URLSearchParams();
        params.append('dirName', dirName);
        
        xhr.send(params);
    }
    
    function handleDeleteDirectory(){
        var dirName = button.getAttribute('data-dir');
        console.log("Button clicked for directory: " + dirName);
    }
    function handleUploadFile(){
        var dirName = button.getAttribute('data-dir');
        console.log("Button clicked for directory: " + dirName);
    }
    function handleDeleteFile(){
        var dirName = button.getAttribute('data-dir');
        console.log("Button clicked for directory: " + dirName);
    }
    
    
    function loadDirectoryListing() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'loadDirectories.php', true);
        
        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('directoryListing').innerHTML = this.responseText;
            } else {
                console.error('Error loading directory listing');
            }
        };
        
    xhr.send();
}

// Call this function to initially load the directory listing
loadDirectoryListing();
});