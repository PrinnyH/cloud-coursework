
//document.getElementById("login_button").onclick = doFunction;

function login(){
    window.location.href = "storage.php";
}

function logout(){
    window.location.href = "index.php";
}

function uploadFile(){
    window.location.href = "create_bucket.php";
    window.location.href = "storage.php";
    alert("Bucket created");
}
