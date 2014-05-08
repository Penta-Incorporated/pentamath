var pointSystem = function(elo, problemsRight){
    var questionValue = 3 + (elo/1200);//How much each question will be worth, based on elo.
    var points = questionValue * problemsRight;
    var game_rating = points*100;
    var temp = 0;
    temp = (game_rating - elo)/10;
    temp -= elo;
    console.log(temp);
};
