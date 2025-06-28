function refreshTable() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "../getData.php", true);
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById("data22").innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}

setInterval(refreshTable, 10000); //
window.onload = refreshTable; //
