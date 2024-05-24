document.getElementById('createQuestion').onsubmit = function(){
    let question = document.getElementById('question').value;
    let goodAnswer = document.getElementById('goodAnswer').value;
    let falseAnswer1 = document.getElementById('badAnswer1').value;
    return !(question === '' || goodAnswer === '' || falseAnswer1 === '');
}

