async function editTask() {
  const form = document.querySelector(".editTaskForms");
  let searchParams = new URLSearchParams(window.location.search);
  let idTicket = searchParams.get("idTicket");
  let idTask = searchParams.get("idTask");
  let type = searchParams.get("type");
  let idUser = searchParams.get("id");

  const formData = new FormData(form);
  formData.append("idTask", idTask);
  formData.append("csrfToken", csrfToken);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../../../actions/task/updateTask.php");
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
      window.location.href =
        "/../pages/task/tasks.php?id=" +
        idUser +
        "&type=" +
        type +
        "&idTicket=" +
        idTicket;
    } else {
      console.error(xhr.statusText);
    }
  };
  xhr.onerror = function () {
    console.error("An error occurred during the request.");
  };
  xhr.send(formData);
  alert("The task has been edited");
}
