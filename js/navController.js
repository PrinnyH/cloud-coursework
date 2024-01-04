window.onload = function() {
    document.getElementById('navMyFiles').addEventListener('click', function() {
        loadContent('myFiles.php');
        loadDirectoryListing();
    });

    document.getElementById('navMySharedFiles').addEventListener('click', function() {
        loadContent('sharedFiles.php');
        //loadDirectoryListing();
        //use alt for shared bucket id selected or smth
    });

    document.getElementById('navMyFiles').click();
};

function loadContent(page) {
    fetch(page)
        .then(response => response.text())
        .then(data => {
            document.getElementById('contentArea').innerHTML = data;
        })
        .catch(error => console.error('Error loading content:', error));
}

function dropDownChange(){
    document.getElementById("myDropdown").classList.toggle("show");
    var x = document.getElementById("sharedFolderSelector").value;
    console.log("You selected: " + x);
}

function adUser(){
    var x = document.getElementById("sharedFolderSelector").value;
    console.log("Add to: " + x);
}

function removeUser(){
    var x = document.getElementById("sharedFolderSelector").value;
    console.log("Add to: " + x);
}


