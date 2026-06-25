// write a script to switch between login and register form
const signInBtn = document.querySelector(".header__auth-btn--in");
const signUpBtn = document.querySelector(".header__auth-btn--up");
const signInForm = document.querySelector(".auth-signin");
const signUpForm = document.querySelector(".auth-signout");

signInBtn.addEventListener("click", () => {
  console.log("works");
  signInForm.classList.remove("hidden");
  signUpForm.classList.add("hidden");
});
signUpBtn.addEventListener("click", () => {
  console.log("works");
  signUpForm.classList.remove("hidden");
  signInForm.classList.add("hidden");
});
