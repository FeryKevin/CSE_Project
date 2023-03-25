const stats = document.getElementsByClassName('survey-stat-display')[0]
const survey = document.getElementsByClassName('survey-no-stat')[0]
const btn = document.getElementById('view-stats')

var isQuestionShow = true
stats.style.display = 'none'
btn.addEventListener('click', () => {
    if (isQuestionShow){
        survey.style.display = 'none'
        stats.style.display = 'block'
        btn.innerHTML = 'Voir la question'
        isQuestionShow = false
    } else {
        survey.style.display = 'block'
        stats.style.display = 'none'
        btn.innerHTML = 'Voir les réponses'
        isQuestionShow = true
    }
})
