window.onload = function() {
    document.getElementById('navMyFiles').addEventListener('click', function() {
        loadContent('myFiles.php');
        loadDirectoryListing();
    });

    document.getElementById('navMySharedFiles').addEventListener('click', function() {
        loadContent('sharedFiles.php');
        populateFolderDropDown();
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
    document.getElementById("sharedFolderSelector").classList.toggle("show");
}

//unclicks the dropdown
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  } 


