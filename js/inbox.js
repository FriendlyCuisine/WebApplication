let modal = document.getElementById("myModal");

// Get the button that opens the modal
let btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
let span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
};

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};

function verifyUsername(thi) {
    // Form fields, see IDs above
    const username= document.querySelector('#username').value;
    const message= document.querySelector('#message').value;

    if(username==='' || message ===''){
        alert("Fill required fields.");
    }

    const http = new XMLHttpRequest()
    http.open('POST', 'verifyUsername.php');
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.send('username='+username); // Make sure to stringify
    http.onload = function() {
        // Do whatever with response
        if(http.responseText==='false'){
            document.getElementById("username").style.border="1px solid red";
            document.getElementById("usernameError").style.color="red";
            document.getElementById("usernameError").innerHTML="Username not found";
        }else{
            document.getElementById("username").style.border="1px solid rgb(169,169,169)";
            document.getElementById("usernameError").style.color="white";
            document.getElementById("usernameError").innerHTML="";
            const form_compose = document.getElementById("form-compose");
            form_compose.submit();
        }
    }
}
