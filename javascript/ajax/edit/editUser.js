async function editUser() {
  const form = document.querySelector(".userEditForms");
  let searchParams = new URLSearchParams(window.location.search);
  let idUser = searchParams.get("idUser");
  let idCreator = searchParams.get("id");
  let type = searchParams.get("type");

  const formData = new FormData(form);
  formData.append("idUser", idUser);
  formData.append("id", idCreator);
  formData.append("type", type);
  formData.append("csrfToken", csrfToken);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../../../actions/user/editUser.php");
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
      window.location.href =
        "/../../../pages/adminPages/adminHomePage.php?id=" +
        idCreator +
        "&type=" +
        type;
    } else {
      console.error(xhr.statusText);
    }
  };
  xhr.onerror = function () {
    console.error("Request failed");
  };
  xhr.send(formData);
  alert("The user has been updated");
}

function togglePasswordVisibility() {
  var passwordInput = document.getElementById("password");
  var passwordToggle = document.getElementById("password-toggle");

  if (passwordInput.getAttribute("type") === "password") {
    passwordInput.setAttribute("type", "text");
    passwordToggle.classList.remove("fa-eye");
    passwordToggle.classList.add("fa-eye-slash");
  } else {
    passwordInput.setAttribute("type", "password");
    passwordToggle.classList.remove("fa-eye-slash");
    passwordToggle.classList.add("fa-eye");
  }
}
