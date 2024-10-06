function editProfile() {
  const form = document.querySelector(".editProfileForms");
  let searchParams = new URLSearchParams(window.location.search);
  let id = searchParams.get("id");

  const formData = new FormData(form);
  formData.append("id", id);
  formData.append("csrfToken", csrfToken);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../../../actions/user/editProfile.php");
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
    } else {
      console.error(xhr.statusText);
    }
  };
  xhr.onerror = function () {
    console.error("Request failed");
  };
  xhr.send(formData);
  alert("Your profile has been updated");
}
