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


async function postData(data = {}) {
    const response = await fetch('https://localhost:8000/admin/survey_status', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
          },
        body: data}
    )
}