const textArea = document.querySelector(".post__form-textarea");
const postBtn = document.querySelector(".post__form-btn");

textArea.addEventListener("input", () => {
    postBtn.disabled = textArea.value.trim() === '';
})