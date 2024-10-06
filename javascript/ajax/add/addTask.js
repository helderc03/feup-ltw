async function addTask() {
  const form = document.querySelector(".addTaskForms");
  let searchParams = new URLSearchParams(window.location.search);
  let idTicket = searchParams.get("idTicket");

  const formData = new FormData(form);
  formData.append("idTicket", idTicket);
  formData.append("csrfToken", csrfToken);
  try {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/../../../actions/task/addTask.php");
    xhr.onload = function () {
      if (xhr.status === 200) {
        console.log(xhr.responseText);
      } else {
        console.error("Request failed with status:", xhr.status);
      }
    };
    xhr.onerror = function () {
      console.error("Request failed");
    };
    xhr.send(formData);
  } catch (error) {
    console.error(error);
  }
  alert("The task has been added");
}
