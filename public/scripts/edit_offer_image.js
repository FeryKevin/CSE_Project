addTagLink = document.createElement('a');
addTagLink.classList.add('btn', 'offer-button', 'collection-button');
addTagLink.innerText='Ajouter une image';
addTagLink.dataset.collectionHolderClass='title';
const newLinkLi = document.createElement('li').append(addTagLink);

const type = document.getElementById('form-section').getAttribute('type');
if (type == "permanent") {
    collectionHolder = document.getElementById('permanent_offer_images');
} else {
    collectionHolder = document.getElementById('limited_offer_images');
}
collectionHolder.innerHTML = "";
collectionHolder.dataset.index = 0;
collectionHolder.appendChild(addTagLink);

const imagesInput = document.getElementsByClassName('li-image');
imageError = document.getElementsByClassName('image-error');
imageError = imageError[0];
imageError.style.display = "none";
const validFileTypes = ['png', 'jpg', 'jpeg', 'webp'];

const addFormToCollection = (e) => {
    index = countLi();

    if (index < 4){
        const item = document.createElement('li');
        
        item.classList.add('li-image');
        
        item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );

        collectionHolder.appendChild(item);
        checkImagesInputs();

        // Ajout d'un bouton pour annuler l'ajout d'une image
        removeFormButton = document.createElement('button');
        removeFormButton.classList.add('offer-button', 'collection-button');
        removeFormButton.innerText = 'Annuler';
        item.append(removeFormButton);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
            index = countLi();
            checkImagesInputs();
        });

        collectionHolder.dataset.index++;
    }
}

addTagLink.addEventListener('click', addFormToCollection);

//Suppression image
const images = document.getElementsByClassName('offer-image');

for (let item of images) {
    let id = item.getAttribute('image')
    let div = document.getElementById(`offer-image-${id}`)
    let btnStatus = div.firstElementChild;
    let imagesNumber = countLi();
    if (imagesNumber == 1) {
        btnStatus.style.display = "none";
    }
    btnStatus.addEventListener('click', () => {
        let data = `{"id": "${id}"}`
        postData(data = data)
        .then(() => { location.reload() })
    })
}

async function postData(data = {}, url = 'http://localhost:8000/admin/offers/delete_image')
{
    const response = await fetch(url, {
        method: "POST",
        body: data
    })
}

function countLi() {
    imagesNumber = parseInt(document.getElementById('form-section').getAttribute('imagesNumber'));
    collectionHolder.dataset.index = (collectionHolder.getElementsByTagName('li').length) + imagesNumber;
    index = collectionHolder.dataset.index;

    return index;
}

// Contrôle de saisie pour les input d'images
function checkImagesInputs() {
    
    submit = document.getElementsByClassName('submit-offer');
    submit = submit[0];
    showSubmit = true;

    index = countLi();
    if (index > 1) {
        for (i = 1; i < index; i++) {
            input = document.getElementById(`${type}_offer_images_${i}_file`);
            if (input !== null) {
                if (input.files) {
                    if (input.files.length > 0) {
                        fileName = input.files[0].name;
                        fileExtension = fileName.split('.').pop();
                        resultExtension = validFileTypes.includes(fileExtension);
                        if (resultExtension == false) {
                            imageError.innerText = "Format de fichier invalide";
                            showSubmit = false;
                        }
                    } else {
                        imageError.innerText = "Champ(s) de fichier vide(s)";
                        showSubmit = false;
                    }
                }
            }
        
        }
    }
    if (showSubmit == true) {
        submit.style.display = "inline-block";
        imageError.style.display = "none";
    } else {
        submit.style.display = "none";
        imageError.style.display = "inline";
    }
}