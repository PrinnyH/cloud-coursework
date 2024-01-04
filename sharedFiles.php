<h1>SHARED FOLDERS <?php echo htmlspecialchars($name);?></h1>
<div class="dropdown">
  <button onclick="dropDownChange()" class="dropbtn">▼ Folder</button>
  <div id="sharedFolderSelector" class="dropdown-content">
    <a href="#" onclick='loadSharedDirectoryListing(this)' data-id='test'>Link 1</a>
    <a href="#" onclick='loadSharedDirectoryListing(this)' data-id='test2'>Link 2</a>
    <a href="#" onclick='loadSharedDirectoryListing(this)' data-id='test3'>Create</a>
  </div>
</div>
<button onclick="addUser()" class="dropbtn">+👤</button>
<button onclick="removeUser()" class="dropbtn">-👤</button>
<div id="directoryListing">
</div>

