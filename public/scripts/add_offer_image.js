addTagLink = document.createElement('a');
addTagLink.classList.add('btn', 'offer-button', 'collection-button');
addTagLink.innerText='Ajouter une image';
addTagLink.dataset.collectionHolderClass='title';
const newLinkLi = document.createElement('li').append(addTagLink);

type = document.getElementsByClassName('form')[0];
type = type.getAttribute('type');
if (type == "permanente") {
    collectionHolder = document.getElementById('permanent_offer_images');
    type = "permanent";
} else {
    collectionHolder = document.getElementById('limited_offer_images');
    type = "limited";
}
collectionHolder.innerHTML = "";
collectionHolder.dataset.index = 0;
collectionHolder.appendChild(addTagLink);

const validFileTypes = ['png', 'jpg', 'jpeg', 'webp'];
const imagesInput = document.getElementsByClassName('li-image');
imageError = document.getElementsByClassName('image-error')[0];

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
        if (collectionHolder.getElementsByTagName('li').length > 1) {
            item.append(removeFormButton);
        }

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

function countLi() {
    imagesNumber = parseInt(document.getElementById('form-section').getAttribute('imagesNumber'));
    collectionHolder.dataset.index = (collectionHolder.getElementsByTagName('li').length) + imagesNumber;
    index = collectionHolder.dataset.index;

    return index;
}

// Contrôle de saisie pour les input d'images
function checkImagesInputs() {
    
    submit = document.getElementsByClassName('submit-offer')[0];
    imageError.style.display = "none";
    showSubmit = true;

    index = countLi();
    if (index > 0) {
        for (i = 0; i < index; i++) {
            input = document.getElementById(`${type}_offer_images_${i}_file`);
            console.log(input);
            if (input.files !== undefined) {
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