const surveys = document.getElementsByClassName('survey-stats')

for (let item of surveys) {
    let id = item.getAttribute('survey')
    let div = document.getElementById(`survey-${id}`)

    item.addEventListener('mouseenter', (e) => {
        div.style.display = 'block'
    })
    item.addEventListener('mouseleave', (e) => {
        div.style.display = 'none'
    })
}
