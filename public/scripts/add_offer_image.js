addTagLink = document.createElement('a');
addTagLink.classList.add('btn', 'offer-button', 'collection-button');
addTagLink.innerText='Ajouter une image';
addTagLink.dataset.collectionHolderClass='title';
const newLinkLi = document.createElement('li').append(addTagLink);

const select = document.getElementById('select-type-offer');
type = select.value;

const validFileTypes = ['png', 'jpg', 'jpeg', 'webp'];
const imagesInput = document.getElementsByClassName('li-image');
imageErrors = document.getElementsByClassName('image-error');

if (type == "permanent") {
    collectionHolder = document.getElementById('permanent_offer_images');
} else {
    collectionHolder = document.getElementById('limited_offer_images');
}

collectionHolder.innerHTML = "";
collectionHolder.dataset.index = 0;
collectionHolder.appendChild(addTagLink);

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
        });

        collectionHolder.dataset.index++;
    }
}

addTagLink.addEventListener('click', addFormToCollection)

function countLi() {
    imagesNumber = parseInt(document.getElementById('form-section').getAttribute('imagesNumber'));
    collectionHolder.dataset.index = (collectionHolder.getElementsByTagName('li').length) + imagesNumber;
    index = collectionHolder.dataset.index;

    return index;
}

function switchForm() {
    if (select.value == "permanent") {
        collectionHolder = document.getElementById('permanent_offer_images');
        type = "permanent";
    } else {
        collectionHolder = document.getElementById('limited_offer_images');
        type = "limited";
    }
    collectionHolder.innerHTML = "";
    collectionHolder.dataset.index = 0;
    collectionHolder.appendChild(addTagLink);
}