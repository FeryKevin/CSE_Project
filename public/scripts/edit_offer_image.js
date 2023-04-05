addTagLink = document.createElement('a')
addTagLink.classList.add('btn', 'offer-button', 'collection-button')
addTagLink.innerText='Ajouter une image'
addTagLink.dataset.collectionHolderClass='title'
const newLinkLi = document.createElement('li').append(addTagLink)

// const deleteTagLink = document.createElement('a')
// deleteTagLink.classList.add('btn', 'offer-button', 'collection-button')
// deleteTagLink.innerText='Supprimer une image'
// deleteTagLink.dataset.collectionHolderClass='title'
// const removeLinkLi = document.createElement('li').append(deleteTagLink)

removeFormButton = document.createElement('button');
removeFormButton.classList.add('offer-button', 'collection-button');
removeFormButton.innerText = 'Supprimer image';

collectionHolder = document.getElementById('permanent_offer_images');
collectionHolder.innerHTML = "";
collectionHolder.dataset.index = 0;
collectionHolder.appendChild(addTagLink)
// collectionHolder.appendChild(deleteTagLink)

//Fonction pour ajouter une section
const addFormToCollection = (e) => {
    collectionHolder = document.getElementById('permanent_offer_images');

    const item = document.createElement('li');

    item.innerHTML = collectionHolder
    .dataset
    .prototype
    .replace(
        /__name__/g,
        collectionHolder.dataset.index
    );

    collectionHolder.appendChild(item);
    item.append(removeFormButton);
    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the li for the tag form
        item.remove();
    });

    if (collectionHolder.dataset.index >=3){
        e.target.removeEventListener('click', addFormToCollection)
    }
    collectionHolder.dataset.index++;
}

addTagLink.addEventListener('click', addFormToCollection)
