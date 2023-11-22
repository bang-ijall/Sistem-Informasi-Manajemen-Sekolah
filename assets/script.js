document.getElementById("loginForm").addEventListener("submit", function (event) {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;

  if (!username || !password) {
    alert("Isi kedua bidang sebelum mengirim formulir!");
    event.preventDefault();
  }
});