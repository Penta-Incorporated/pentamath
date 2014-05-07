function rand_int(a,b){
	return Math.round((Math.random() * (b - a)) + a);
};
function check(operation){
	for(var q = 0; q < operation.length; q++){
			if(operation[q] === "*" || operation[q] === "/"){
				return true;
			}
	}

	return false;
};

var createProblem = function(elo){

	var problem;
	var operationArray = ['+','-','*','/'];
	var count = new Array();
	var operation = new Array();
	var modifier = Math.floor(elo/1200);
	if (modifier < 1)
		modifier = 1;

	if((modifier+1) > 1 ){
	    modifier = rand_int(1,modifier);
	}
	for(var q = 0; q < (modifier + 1); q++){

	    count[q] = rand_int(2,(elo/10));

	}//Create the numbers
	for(var q = 0; q < modifier; q++){
			 if(check(operation)){
				operation[q] = operationArray[rand_int(0,1)];
			 }
			 else{
				operation[q] = operationArray[rand_int(0,3)];
			 }
	     if(operation[q] === "*"){
	         count[q+1] = Math.ceil(count[q] / (elo/100)) + 1;
	     }
	     if(operation[q] === "/"){
            count[q+1] = Math.ceil(count[q+1]/8) + 1;
            count[q] = count[q+1] * rand_int(2,10);
	     }

	}//Create the operation
	for(var q = 0; q < operation.length+1; q++){
	    if(q === 0){
	       problem = count[q];
	    }
	    else{
	        problem += count[q];
	    }
	    if(q > operation.length-1){
	    }
	    else{
	        problem += operation[q];
	    }

	}//Add the operation and the number together
	return problem;

};
