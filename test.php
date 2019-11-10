<script type="text/javascript">
var fileToRead = document.getElementById("yourFile");

fileToRead.addEventListener("change", function(event) {
    var files = fileToRead.files;
    if (files.length) {
        console.log("Filename: " + files[0].name);
        console.log("Type: " + files[0].type);
        console.log("Size: " + files[0].size + " bytes");
    }

}, false);
</script>

<img id="output" src="img/1784010102.jpg" width="70" height="70">

<input id="yourFile" name="photo" type="file" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
