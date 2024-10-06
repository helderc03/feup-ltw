async function addInquiry() {
  const form = document.querySelector(".addInquiryForms");
  let searchParams = new URLSearchParams(window.location.search);
  let idTicket = searchParams.get("idTicket");
  let idCreator = searchParams.get("id");

  console.log(inquiryDescription);
  const formData = new FormData(form);
  formData.append("idTicket", idTicket);
  formData.append("idCreator", idCreator);
  formData.append("csrfToken", csrfToken);

  try {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/../../../actions/inquiry/addInquiry.php");
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
  alert("The inquiry has been added");
}
