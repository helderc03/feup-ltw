const openModalButtons = document.querySelectorAll("[data-modal-target]");
const closeModalButtons = document.querySelectorAll("[data-close-button]");
const overlay = document.getElementById("overlay");

openModalButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const modal = document.querySelector(button.dataset.modalTarget);
    openModal(modal);
  });
});

overlay.addEventListener("click", () => {
  const modals = document.querySelectorAll(".modal.active");
  modals.forEach((modal) => {
    closeModal(modal);
  });
});

closeModalButtons.forEach((button) => {
  button.addEventListener("click", () => {
    const modal = button.closest(".modal");
    closeModal(modal);
  });
});

function openModal(modal) {
  if (modal == null) return;
  modal.classList.add("active");
  overlay.classList.add("active");
}

function closeModal(modal) {
  if (modal == null) return;
  modal.classList.remove("active");
  overlay.classList.remove("active");
}

async function saveFile() {
  let searchParams = new URLSearchParams(window.location.search);
  let idTicket = searchParams.get("idTicket");

  var formData = new FormData();

  var fileInput = document.getElementById("fileupload");
  var file = fileInput.files[0];

  formData.append("file", file);
  formData.append("idTicket", idTicket);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../../../actions/others/upload_file.php");
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

  alert("The file has been uploaded");
}

async function addTicket() {
  var formData = new FormData();
  let searchParams = new URLSearchParams(window.location.search);

  var ticketTitle = document.getElementById("ftitle").value;
  var ticketDescription = document.getElementById("description").value;
  let idCreator = searchParams.get("id");
  var ticketDepartment = document.getElementById("ticketDepartment").value;

  formData.append("title", ticketTitle);
  formData.append("description", ticketDescription);
  formData.append("creatorId", idCreator);
  formData.append("ticketDepartment", ticketDepartment);
  formData.append("csrfToken", csrfToken);

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/../../../actions/ticket/add_ticket.php");
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

  alert("The ticket has been added");
}
