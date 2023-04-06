addTagLink = document.createElement('a')
addTagLink.classList.add('btn', 'offer-button', 'collection-button')
addTagLink.innerText='Ajouter une image'
addTagLink.dataset.collectionHolderClass='title'
const newLinkLi = document.createElement('li').append(addTagLink)

collectionHolder = document.getElementById('permanent_offer_images');
collectionHolder.innerHTML = "";
collectionHolder.dataset.index = 0;
collectionHolder.appendChild(addTagLink)

const addFormToCollection = (e) => {
    index = countLi();

    if (index < 4){
        const item = document.createElement('li');

        item.innerHTML = collectionHolder
        .dataset
        .prototype
        .replace(
            /__name__/g,
            collectionHolder.dataset.index
        );
        
        collectionHolder.appendChild(item);

        // Ajout d'un bouton pour chaque image
        removeFormButton = document.createElement('button');
        removeFormButton.classList.add('offer-button', 'collection-button');
        removeFormButton.innerText = 'Supprimer';
        item.append(removeFormButton);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
            index = countLi();
        });

        collectionHolder.dataset.index++;
    }
}

addTagLink.addEventListener('click', addFormToCollection)