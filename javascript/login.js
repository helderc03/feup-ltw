document.addEventListener("DOMContentLoaded", (event) => {
  const rotateCard = () => {
    const cardContainer = document.querySelector(".card-container");
    cardContainer.classList.toggle("rotate");
  };

  const btnSignup = document.querySelector("#btn-signup");

  const text1 = document.querySelector(".image-container-title");
  const text2 = document.querySelector(".image-container-text");

  let isLogin = false;

  btnSignup.addEventListener("click", () => {
    rotateCard();
    if (isLogin) {
      btnSignup.textContent = "Sign up";
      isLogin = false;
      text1.textContent = "New Here ?";
      text2.textContent = "Create an account !";
    } else {
      btnSignup.textContent = "Login";
      isLogin = true;
      text1.textContent = "Already have an account ?";
      text2.textContent = "Log in now !";
    }
  });
});
