addTagLink = document.createElement('a')
addTagLink.classList.add('btn', 'offer-button', 'collection-button')
addTagLink.innerText='Ajouter une image'
addTagLink.dataset.collectionHolderClass='title'
const newLinkLi = document.createElement('li').append(addTagLink)

let type = document.getElementById('form-section').getAttribute('type')
if (type == "permanent") {
    collectionHolder = document.getElementById('permanent_offer_images');
} else {
    collectionHolder = document.getElementById('limited_offer_images');
}
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
        removeFormButton.innerText = 'Annuler';
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

//Suppression image
const images = document.getElementsByClassName('offer-image')

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
        postData(data = data).then(() => { location.reload() })
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
    imagesNumber = document.getElementById('form-section').getAttribute('imagesNumber');
    collectionHolder.dataset.index = (collectionHolder.getElementsByTagName('li').length) + imagesNumber;
    index = collectionHolder.dataset.index;

    return index;
}