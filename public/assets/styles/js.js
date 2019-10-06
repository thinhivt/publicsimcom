
function displaybutton() {
  var checkBox = document.getElementById("exampleCheck1");
  var text = document.getElementById("quenpass");
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
     text.style.display = "none";
  }
}