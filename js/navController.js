/**
 * Sets up event listeners on window load.
 */
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

/**
 * Loads a specific content page into a designated area of the web page.
 * @param {string} page - The URL of the page to load.
 */
function loadContent(page) {
    fetch(page)
      .then(response => response.text())
      .then(data => {
          document.getElementById('contentArea').innerHTML = data;
      })
      .catch(error => console.error('Error loading content:', error));
}

/**
 * Toggles the display of the dropdown menu.
 */
function dropDownChange(){
    document.getElementById("sharedFolderSelector").classList.toggle("show");
}

/**
 * Closes dropdown menus when clicking outside of them.
 * @param {Event} event - The click event.
 */
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


