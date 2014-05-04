var operators = ['+','/','*','-'];

function rand_int(a,b){
	return Math.round((Math.random() * (b - a)) + a);
}

function lengthOfLast(problem){
	var len = 0;
	for(var i=problem.length-1;i>=0;i--){
		if (! operators.contains(problem[i])
			len++;
		else break;
	}

	return len;
}

function easyDiv(){
	result = new Array();
	//divisor
	result[0] = rand_int(2,14);
	//dividend
	result[1] = result[0] * rand_int(2,8);

	return result;
}


function generateProblem(rating){
	
	var problem = '';
	var numOps = (rating + 600)/1000;
	var current_ops = new Array();

	for(var i=0; i<numOps; i++){
		current_ops[i] = operators[rand_int(0,3)];
	}

	for (var op in current_ops){
		
	}
	

}
