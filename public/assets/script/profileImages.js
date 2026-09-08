const input = document.querySelector('#profile-picture-input');
const dropZone = document.querySelector('.user-photo-dialog__drop-zone');

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('is-dragging');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('is-dragging');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();

    dropZone.classList.remove('is-dragging');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        input.files = files;
        const text = document.querySelector('.user-photo-dialog__drop-text');
        text.textContent = files[0].name;
    }
});

input.addEventListener('change', () => {
    if (input.files.length > 0) {
        document.querySelector('.user-photo-dialog__drop-text').textContent = input.files[0].name;
    }
});

document.addEventListener('submit', async (e) => {
    const form = e.target.closest('.js-profile-picture-form');

    if(!form) return;

    e.preventDefault();
    const errorField = document.querySelector('.user-photo-dialog__erros');

    try {

        const response = await fetch(form.action, {
            method: form.method,
            body: new FormData(form),
        });

        if(!response.ok){
            throw new Error('server error');
        }

        const data = await response.json();

        if(!data.success){
            errorField.innerHTML = '';
            data.errors.forEach((error) => {
                console.log(error);
                const errorContainer = document.createElement('p');
                errorContainer.textContent = error;
                errorField.appendChild(errorContainer);
            })
            
        } else {
            window.location.reload();
        }
    } catch (e) {
        const error = document.createElement('p');
        error.textContent = 'Something went wrong. Please try again.'
        errorField.appendChild(error);
    }

    
})