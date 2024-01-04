<h1>SHARED FOLDERS <?php echo htmlspecialchars($name);?></h1>
<div class="dropdown">
  <button onclick="dropDownChange()" class="dropbtn">Folder</button>
  <div id="myDropdown" class="dropdown-content">
    <a href="#">Link 1</a>
    <a href="#">Link 2</a>
    <a href="#">Create</a>
  </div>
</div>
<button onclick="addUser()" class="dropbtn">+ User</button>
<button onclick="removeUser()" class="dropbtn">- User</button>
<div id="directoryListing">
</div>

