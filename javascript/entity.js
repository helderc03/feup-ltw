function showAddionalOptions() {
  var typeEntity = document.getElementById("typeEntity").value;
  var departmentOptions = document.getElementById("departmentOptions");
  var hashtagOptions = document.getElementById("hashtagOptions");
  var faqOptions = document.getElementById("faqOptions");

  if (typeEntity === "Department") {
    departmentOptions.style.display = "block";
    hashtagOptions.style.display = "none";
    faqOptions.style.display = "none";
  } else if (typeEntity === "Hashtag") {
    departmentOptions.style.display = "none";
    hashtagOptions.style.display = "block";
    faqOptions.style.display = "none";
  } else if (typeEntity === "Faq") {
    departmentOptions.style.display = "none";
    hashtagOptions.style.display = "none";
    faqOptions.style.display = "block";
  } else {
    departmentOptions.style.display = "none";
    hashtagOptions.style.display = "none";
    faqOptions.style.display = "none";
  }
}

async function addEntity() {
  const form = document.querySelector(".addEntityForms");
  const formData = new FormData(form);
  formData.append("csrfToken", csrfToken);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../actions/entity/addEntity.php");
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
  alert("The entity has been added");
}
