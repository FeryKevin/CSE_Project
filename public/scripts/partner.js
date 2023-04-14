const btnDelete = document.getElementsByClassName('partner-delete')

for (let button of btnDelete) {
    button.addEventListener('click', (e) => {
        let id = e.target.getAttribute('data')
        
        let data = `{"id": "${id}"}`
        if(confirm('Voulez vous vraiment supprimer ce partenaire ?')){
            postData(data, "http://localhost:8000/admin/partners/delete").then(window.location.reload())
        }
    })
}

const btnUpdate = document.getElementsByClassName('partner-update')

for (let button of btnUpdate) {
    button.addEventListener('click', (e) => {
        let id = e.target.getAttribute('data')
        let inputs = document.getElementsByClassName(`partner-${id}`)
        let data = `{"id" : ${id}, `

        for (let input of inputs){
            data += `"${input.name}" : "${input.value}", `
        }

        data = data.slice(0, -2) + "}";
        postData(data, "http://localhost:8000/admin/partners/update").then(window.location.reload())
    })
}

const forms = document.getElementsByClassName('form-partner-image')

for (let form of forms){

    form.addEventListener('change', (e) => {

        let id = e.target.getAttribute('data')

        let body = new FormData()

        if (['png', 'webp', 'jpg'].includes(e.target.value.split('.').pop())){
            body.append('image', e.target.files[0])
            postImgData(body, id).then(window.location.reload())
        }
        
    })
}

async function postData(data, url) {
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: data
    })
}

async function postImgData(data, id) {
    const response = await fetch(`http://localhost:8000/admin/partners/img/${id}`, {
        method: "POST",
        body: data
    })
}
