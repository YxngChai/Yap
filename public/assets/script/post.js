const textArea = document.querySelector(".post__form-textarea");
const postBtn = document.querySelector(".post__form-btn");

textArea.addEventListener("input", () => {
    postBtn.disabled = textArea.value.trim() === '';
})

document.querySelectorAll('.post__action-delete').forEach(button => {
    button.addEventListener('click', () => {
        const dialog = document.getElementById(button.dataset.dialog);
        dialog.showModal();
    });
});