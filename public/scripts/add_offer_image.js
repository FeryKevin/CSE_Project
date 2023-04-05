const addTagLink = document.createElement('a')
addTagLink.classList.add('btn', 'offer-button', 'collection-button')
addTagLink.innerText='Ajouter une image'
addTagLink.dataset.collectionHolderClass='title'

const newLinkLi = document.createElement('li').append(addTagLink)

const select = document.getElementById('select-type-offer')

function switchForm() {
    if (select.value == "permanent") {
        collectionHolder = document.getElementById('permanent_offer_images');
    } else {
        collectionHolder = document.getElementById('limited_offer_images');
    }
    collectionHolder.innerHTML = "";
    collectionHolder.dataset.index = 0;
    collectionHolder.appendChild(addTagLink)
}

//Fonction pour ajouter une section
const addFormToCollection = (e) => {
    if (select.value == "permanent") {
        collectionHolder = document.getElementById('permanent_offer_images');
    } else {
        collectionHolder = document.getElementById('limited_offer_images');
    }

    const item = document.createElement('li');

    item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
        /__name__/g,
        collectionHolder.dataset.index
    );

    collectionHolder.appendChild(item);

    if (collectionHolder.dataset.index >=3){
        e.target.removeEventListener('click', addFormToCollection)
    }
    collectionHolder.dataset.index++;
}

addTagLink.addEventListener('click', addFormToCollection)