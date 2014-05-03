var rating = function(var points, var rating){
	var new_rating;
	var game_rating=(points*1000);
	
	if(game_rating>rating){
		new_rating=rating+(game_rating/10);
	}
	if(game_rating<rating){
		new_rating=rating-(game_rating/10);
	}
	if(game_rating===rating){
		new_rating=rating
	}
	rating=new_rating

}
