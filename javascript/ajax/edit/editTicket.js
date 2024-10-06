const form = document.querySelector(".editTicketForms");
let searchParams = new URLSearchParams(window.location.search);
let idTicket = searchParams.get("idTicket");
let type = searchParams.get("type");
let idUser = searchParams.get("id");

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  const formData = new FormData(form);
  formData.append("idTicket", idTicket);
  formData.append("type", type);
  formData.append("id", idUser);
  const csrfToken = form.getAttribute("data-csrf");
  formData.append("csrfToken", csrfToken);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../../../actions/ticket/updateTicket.php");
  xhr.onload = function () {
    if (xhr.status === 200) {
      console.log(xhr.responseText);
      window.location.href =
        "/../../../pages/ticket/ticket.php?id=" +
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
    console.error("Request failed");
  };
  xhr.send(formData);
  alert("The ticket has been updated");
});
