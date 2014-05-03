/*Takes the persons elo
start at 1000 elo
10 problem mode 50 problem mode and so on
so percentage of problems solved would have 50 subtracted from it 
and anything below a 50 would make you lose elo anything above would make you gain elo
we would have a 50 multiplier on it*/

//Code:
    
    var createProblem = function(elo){
    
        var problem;
        var operationArray = new Array();
        operationArray[0] = "+";
        operationArray[1] = "-";
        operationArray[2] = "*";
        operationArray[3] = "/";
        var count = new Array();
        var operation = new Array();
        var modifier = Math.floor(elo/400);
        
        if(modifier > 3 ){
            modifier = 3;
        }
        for(var q = 0; q < modifier; q++){
            
            count[q] = Math.floor(Math.random()*(elo/10));
            
        }
        modifier = Math.floor(elo/600);
        if(modifier > 2 ){
            modifier = 2;
        }
        for(var q = 0; q < modifier; q++){
            var y = 0;
            if(count[q]%10 === 0){
                y = 4;
            }
            else{
                y = 2;
            }
             operation[q] = operationArray[Math.floor(Math.random()*y)];
             
        }
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
            
        }
        return problem;
        
    };
