const btnDelete = document.getElementsByClassName('member-delete')

for (let button of btnDelete) {
    button.addEventListener('click', (e) => {
        let id = e.target.getAttribute('data')
        
        let data = `{"id": "${id}"}`
        postData(data, "http://localhost:8000/admin/members/delete").then(window.location.reload())
    })
}

const btnUpdate = document.getElementsByClassName('member-update')

for (let button of btnUpdate) {
    button.addEventListener('click', (e) => {
        let id = e.target.getAttribute('data')
        let inputs = document.getElementsByClassName(`member-${id}`)
        let data = `{"id" : ${id}, `

        for (let input of inputs){
            data += `"${input.name}" : "${input.value}", `
        }

        data = data.slice(0, -2) + "}";
        postData(data, "http://localhost:8000/admin/members/update").then(window.location.reload())
    })
}

const forms = document.getElementsByClassName('form-member-image')

for (let form of forms){

    form.addEventListener('change', (e) => {
        let id = e.target.getAttribute('data')

        let body = new FormData()

        body.append('id', id)
        body.append('image', e.target.files[0])
        
        postImgData(body, "http://localhost:8000/admin/members/img")
    })
}

const handleImgChange = () => {
    console.log('change')
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

async function postImgData(data) {
    const response = await fetch("http://localhost:8000/admin/members/img", {
        method: "POST",
        headers: {
            "Content-Type": "multipart/form-data",
        },
        body: data
    })
}