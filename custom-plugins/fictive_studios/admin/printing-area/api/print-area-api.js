document
  .getElementById("getPrintArea")
  .addEventListener("click", getPrintAreas);

function getPrintAreas() {
  var xhr = new XMLHttpRequest();
  var params = new URLSearchParams();
  params.append("action", "get_print_areas");
  var url = ajaxurl + "?" + params.toString();
  xhr.open("GET", url, true);
  xhr.onload = function () {};
  xhr.send();
}
