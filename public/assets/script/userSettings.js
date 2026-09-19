const profilePictureForm = document.querySelector('.js-profile-picture-settings-form');
const profilePictureInput = document.querySelector('#profile-picture-input');
const profilePicture = document.querySelector('.picture-form__image');
const errorField = document.querySelector('.js-picture-form-error-container');

profilePictureInput.addEventListener('change', () => {
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
        error.textContent = 'Invalid file format.';
        errorField.appendChild(error);
        return;
      }
    if (file.size > 5 * 1024 * 1024) {
        profilePictureInput.value = '';
        const error = document.createElement('p');
        error.textContent = 'File too large, 5MB maximum.';
        errorField.appendChild(error);
        return;
      }
      const objectUrl = URL.createObjectURL(file);

      profilePicture.src = objectUrl;
})

profilePictureForm.addEventListener('submit', async(e) =>{
    e.preventDefault();

    

    try {

        const response = await fetch(profilePictureForm.ariaDescription, {
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
                errorContainer.textContent = error;
                errorField.appendChild(errorContainer);
            })
        } else {
            window.location.reload();
        }

    } catch (e) {
        console.log(e);
        const error = document.createElement('p');
        error.textContent = 'Something went wrong. Please try again.';
        errorField.appendChild(error);
    }
})

