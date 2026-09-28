// Update profile picture

const profilePictureForm = document.querySelector('.js-profile-picture-settings-form');
const profilePictureInput = document.querySelector('#profile-picture-input');
const profilePicture = document.querySelector('.picture-form__image');



// to have validation message that persist after refresh
const pictureMessage = sessionStorage.getItem('profilePictureSaved');
if (pictureMessage) {
    const container = document.querySelector('.js-picture-form-error-container');

    const validationMessage = document.createElement('p');
    validationMessage.classList.add('form__success');
    validationMessage.textContent = 'Photo saved successfully';

    container.appendChild(validationMessage);

    sessionStorage.removeItem('profilePictureSaved');
}

//upload profile picture
profilePictureInput.addEventListener('change', () => {
    const errorField = document.querySelector('.js-picture-form-error-container');
    const file = profilePictureInput.files[0];

    errorField.innerHTML = '';

    const allowedTypes = [
          'image/jpeg',
          'image/png',
          'image/webp'
      ];

    if(!allowedTypes.includes(file.type)) {
        profilePictureInput.value = '';
        const error = document.createElement('p');
        error.classList.add('form__errors');
        error.textContent = 'Invalid file format.';
        errorField.appendChild(error);
        return;
      }
    if (file.size > 5 * 1024 * 1024) {
        profilePictureInput.value = '';
        const error = document.createElement('p');
        error.classList.add('form__errors');
        error.textContent = 'File too large, 5MB maximum.';
        errorField.appendChild(error);
        return;
      }
      const objectUrl = URL.createObjectURL(file);

      profilePicture.src = objectUrl;
})

profilePictureForm.addEventListener('submit', async(e) =>{
    e.preventDefault();

    if (profilePictureInput.files.length === 0) {
        const error = document.createElement('p');
        error.classList.add('form__errors');
        error.textContent = 'Please select an image first.';
        errorField.innerHTML = '';
        errorField.appendChild(error);

        return;

    }

    try {

        const response = await fetch(profilePictureForm.action, {
            method: profilePictureForm.method,
            body: new FormData(profilePictureForm)
        })

        if(!response.ok){
            throw new Error('Server error');
        }
        const data = await response.json();

        if(!data.success){
            console.log(data.errors);
            errorField.innerHTML = '';
            data.errors.forEach((error) => {
                const errorContainer = document.createElement('p');
                errorContainer.classList.add('form__errors');
                errorContainer.textContent = error;
                errorField.appendChild(errorContainer);
            })
        } else {
            sessionStorage.setItem('profilePictureSaved', 'true');
            window.location.reload();
        }

    } catch (e) {
        console.log(e);
        const error = document.createElement('p');
        error.classList.add('form__errors');
        error.textContent = 'Something went wrong. Please try again.';
        errorField.appendChild(error);
    }
})

// update personal details

const personalDetailsForm = document.querySelector('.js-personal-details-form');

personalDetailsForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {

        const response = await fetch(personalDetailsForm.action, {
            method: personalDetailsForm.method,
            body: new FormData(personalDetailsForm)
        })

        if(!response.ok){
            throw new Error('Server error');
        }
        const data = await response.json();

        if(!data.success){
            const errorField = document.querySelector('.js-details-message-container');
            console.log(data.errors);
            errorField.innerHTML = '';
            data.errors.forEach((error) => {
                const errorContainer = document.createElement('p');
                errorContainer.classList.add('form__errors');
                errorContainer.textContent = error;
                errorField.appendChild(errorContainer);
            })
        } else {
            const messageContainer = document.querySelector('.js-details-message-container');
            messageContainer.innerHTML = '';
            const message = document.createElement('p');
            message.classList.add('form__success');
            message.textContent = 'Changes saved successfully.'
            messageContainer.appendChild(message);
        }

    } catch (e) {
        console.log(e);
        const errorField = document.querySelector('.js-details-message-container');
        const error = document.createElement('p');
        error.classList.add('form__errors');
        error.textContent = 'Something went wrong. Please try again.';
        errorField.appendChild(error);
    }
})


// update password

const updatePasswordForm = document.querySelector('.js-update-password-form');

updatePasswordForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {

        const response = await fetch(updatePasswordForm.action, {
            method: updatePasswordForm.method,
            body: new FormData(updatePasswordForm)
        })

        if(!response.ok){
            throw new Error('Server error');
        }
        const data = await response.json();

        if(!data.success){
            const errorField = document.querySelector('.js-update-password-message-container');
            console.log(data.errors);
            errorField.innerHTML = '';
            data.errors.forEach((error) => {
                const errorContainer = document.createElement('p');
                errorContainer.classList.add('form__errors');
                errorContainer.textContent = error;
                errorField.appendChild(errorContainer);
            })
        } else {
            const messageContainer = document.querySelector('.js-update-password-message-container');
            messageContainer.innerHTML = '';
            const message = document.createElement('p');
            message.classList.add('form__success');
            message.textContent = 'New password saved successfully.'
            messageContainer.appendChild(message);
        }

    } catch (e) {
        console.log(e);
        const errorField = document.querySelector('.js-update-password-message-container');
        errorField.innerHTML = '';
        const error = document.createElement('p');
        error.classList.add('form__errors');
        error.textContent = 'Something went wrong. Please try again.';
        errorField.appendChild(error);
    }
})


const dialogBtn = document.getElementById('deleteAccountModalBtn');
const dialog = document.getElementById('deleteAccountModal');
const closeDialogBtn = document.getElementById('formCancel');

dialogBtn.addEventListener('click', ()=>{
    dialog.showModal();
})

dialog.addEventListener("click", (e) => {
    if (e.target === dialog) {
      dialog.close();
  }}
);

closeDialogBtn.addEventListener("click", (e) => {
      dialog.close();
}
);

// delete account

const deleteForm = document.querySelector('.js-delete-aac');

deleteForm.addEventListener('submit', async(e) =>{
    e.preventDefault();

    const errorField = document.querySelector('.js-delete-error-field');
    errorField.textContent = '';

    try {

        const response = await fetch(deleteForm.action, {
            method: deleteForm.method,
            body: new FormData(deleteForm)
        })

        if(!response.ok){
            throw new Error('Server error');
        }
        const data = await response.json();

        if(!data.success){
            console.log(data.errors);
            errorField.textContent = data.errors;
        }  else {
        window.location.href = '/yap/public/';
        }

    } catch (e) {
        console.log(e);
        errorField.textContent = 'Something went wrong. Please try again.';
    }
})
