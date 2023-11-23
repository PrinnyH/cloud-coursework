
//document.getElementById("login_button").onclick = doFunction;

function login(){
    window.location.href = "/storage.php";
}

function logout(){
    window.location.href = "/index.php";
}

function uploadFile(){
    let file = document.getElementById("file").files[0];
    //let formData = new FormData();
    //formData.append("file", file);

    if (file == null){
        alert("no file uploaded")
        return
    }
    alert(file.name);
}