const surveys = document.getElementsByClassName('survey-stats')

for (let item of surveys) {
    let id = item.getAttribute('survey')
    let div = document.getElementById(`survey-${id}`)
    let btnStatus = div.firstElementChild.nextElementSibling;
    btnStatus.addEventListener('click', () => {
        let status = (btnStatus.className === 'survey-activate') ? 1 : 0;
        let data = `{"id": "${id}","status": "${status}"}`
        postData(data = data).then(() => { location.reload() })
    })

    item.addEventListener('mouseenter', (e) => {
        div.style.display = 'grid'
    })
    item.addEventListener('mouseleave', (e) => {
        div.style.display = 'none'
    })
}

async function postData(data = {}, url = 'http://localhost:8000/admin/survey_status') {
    const response = await fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: data}
        )
    }

// Update modal

const updateInput = document.getElementById('question')
const updateBtns = document.getElementsByClassName('survey-update')
const input = document.getElementById('question')
const validateBtn = document.getElementById('survey-update-submit')

for (let updateBtn of updateBtns){
    updateBtn.addEventListener('click', (e) => {
        let qst = e.target.getAttribute('data')
        input.value = qst
        validateBtn.setAttribute('data', e.target.getAttribute('data-id'))
    })
}

validateBtn.addEventListener('click', (e) => {
    let newQst = input.value
    let data = `{"question": "${newQst}"}`
    postData(data = data, url = `http://localhost:8000/admin/survey/update/${e.target.getAttribute('data')}`).then(() => location.reload())
})