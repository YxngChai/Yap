const textArea = document.querySelector(".post__form-textarea");
document.querySelectorAll(".post__form").forEach((form) => {
  const textArea = form.querySelector(".post__form-textarea");
  const postBtn = form.querySelector(".post__form-btn");

  if (!textArea || !postBtn) return;

  const updateButtonState = () => {
    postBtn.disabled = textArea.value.trim() === "";
  };

  updateButtonState();
  textArea.addEventListener("input", updateButtonState);
});

document.querySelectorAll(".post__action").forEach((button) => {
  button.addEventListener("click", () => {
    const dialog = document.getElementById(button.dataset.dialog);
    dialog.showModal();
  });
});

document.querySelectorAll("dialog").forEach((dialog) => {
  dialog.addEventListener("click", (e) => {
    if (e.target === dialog) {
      dialog.close();
    }
  });
});
