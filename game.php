<?php

$db_host = "localhost";
$db_username = "root";
$db_pass = "";
$db_name = "pentamath";

$con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die("Could not connect to MySQL");

$query = "SELECT MAX(id) FROM scoreboard";
$result = mysqli_query($con, $query);
$id = $result->fetch_row()[0] + 1;

echo "<script type='text/javascript'>user_id = $id; </script>";

mysqli_close($con);
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <title>PentaMath</title>
	<link rel='stylesheet' href='style/main.css'>
	<link rel='stylesheet' href='style/game.css'>
	<link rel="shortcut icon" type="image/png" href="images/favicon.png"/>
    	<link rel='stylesheet' href='style/TimeCircles.css' />
	<script src='js/jquery.js'></script>
	<script src='js/jquery.cookie.js'></script>
    	<script src="http://use.edgefonts.net/nunito.js"></script>
    	<script type='text/javascript' src='js/TimeCircles.js'></script>
	<script type="text/javascript" src="js/mathjax/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
</head>

<body>
	<div id='page'>
		<div id='header'></div>
		<hr />

		<div id='content'>
			<div id='question'></div>

			<input id='ans' type='textfield' class='textfield' placeholder=' Your Answer'><br />
			<a id='submit' onclick='testAnswer()' class='rbs-button rbs-modern-detail rbs-modern-blue'>Submit</a>
			<div id='time' data-timer='11'></div>
		</div>
	</div>

<script src='js/problemGen.js'></script>
<script type='text/javascript'>

    var problem;
    var user_name;
    window.hack = 0;
    var user_rating;
    var problemsRight = 0;
    var problemsDone = 0;
    var user_id;


	 function getUserData(){
		user_id_temp = $.cookie('id');
		if (user_id_temp != undefined){
			user_id = parseInt(user_id_temp);	
		}
		user_name = $.cookie('name');
		user_rating = $.cookie('rating');


		if(user_rating == undefined){
			user_rating = 1000;
		}else user_rating = parseInt(user_rating);
	 }

	 function updateUserData(){
		var modifier = problemsRight - 5;
		user_rating += modifier * 5;
		$.cookie('rating', user_rating);
		$.cookie('id', user_id);
		$.cookie('name', user_name);
	 }	 



	 function update_scoreboard(){
		 if(user_name == undefined){
		 getUserName();
		 }
		$.ajax({
			url: 'update_scoreboard.php',
			type: 'POST',
			data:
			{
				name: user_name,
				rating: user_rating,
				id: user_id
			},
			success: function(){console.log("It worked");}
		});
	}


	 function getUserName(){
			var tempname = window.prompt("Enter your name", "Anonymous");
			while (tempname.length > 21){
				window.alert("Maximum 20 characters"); 
				tempname = window.prompt("Enter your name", "Anonymous");
			}

			user_name = tempname;
	 }


    function nextQuestion()
    {
        if(problemsDone == 10)
        {
            gameOver();
        }else{
        nextTimer();
        $('#question').fadeOut('300', function()
        {
            problem = createProblem(user_rating);
            displayProblem();
            $('#ans').val('');
               
        });
        $('#question').fadeIn('300');
        }

    }
    
    function gameOver()
    {
        showIncorrect('Game Over');
        window.setTimeout(function()
        {
            $('#question').fadeToggle('300', function(){$('#question').css('color', 'green').html('Correct Problems: ' + problemsRight + ' / 10').fadeToggle('300');});
            $('#submit').html('Play Again');
            document.getElementById('submit').setAttribute('onclick', 'initGame();');
            $('#time').TimeCircles().stop();
            $('#time').fadeTo(300, 0);
            $('#ans').fadeTo(300, 0);
	    update_scoreboard();
	    updateUserData();
        }, 3000);

    }


    function nextTimer()
    {
        $('#time').fadeTo(300, 0, function()
        {
            $('#time').TimeCircles().restart();
            $('#time').TimeCircles().stop();
            $('#time').delay(1000).fadeTo(300, 1).delay('400');
        });

        window.setTimeout(function() 
        {
            $('#time').TimeCircles().start();
        }, 1400);
    }


    function initGame()
    {
        problemsDone = 0;
        problemsRight = 0;
        problem = '';
        document.getElementById('submit').setAttribute('onclick', 'testAnswer()');
        $('#submit').html('Submit');
        $('#time').fadeTo(300, 1);
        $('#ans').fadeTo(300, 1);
        nextQuestion();

    }


   //functions to display correct or incorrect

    function showCorrect()
    {
        $('#question').fadeTo(350, 0, function()
        {
            document.getElementById('question').style.color = 'green';
            document.getElementById('question').innerHTML = 'Correct!';
        }).fadeTo(350, 1).delay('250');
    }

    function showIncorrect(str)
    {
        $('#question').fadeTo(350, 0, function()
        {
            document.getElementById('question').style.color = 'red';
            document.getElementById('question').innerHTML = str;
        }).fadeTo(350, 1).delay('250');
    }
    
    function setTime()
    {
        timeLeft--;
        console.log(timeLeft);
        if (timeLeft == 0)
            clearInterval(timer);
    }

	function toTeX(str){
		return '\\(' + str.replace(/\//, '\\div').replace(/\*/, '\\times') + '\\)';
	}


	function testAnswer(){
        if (window.hack == 0){
            var correct = eval(problem);
            var guess = $('#ans').val();

            if (guess == correct)
            {
                problemsRight++;
                showCorrect();

            }else showIncorrect('Incorrect!');

            problemsDone++;

            nextQuestion();
        }

	}


    function displayProblem()
    {
        $('#question').html(toTeX(problem)).css('color', 'black');
        MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
    }

    //callback function for timer event listener
    function zeroTime(unit, value, total)
    {
        if (total == 0)
        {
            window.hack = 1;
            problemsDone++;
            showIncorrect('Out of time!');
            nextQuestion();
        }else window.hack = 0;

    }


	$(function() {

	getUserData();

        $('#ans').keyup(function(e) {
            if (e.keyCode == 13) {
                testAnswer();
            }
        });

	$("#time").TimeCircles({
    "animation": "smooth",
    "count_past_zero": false,
    "use_background": false,
    "fg_width": 0.04,
    "circle_bg_color": "#EEEEEE",
    "time": {
        "Days": {
            "text": "Days",
            "color": "#CCCCCC",
            "show": false
        },
        "Hours": {
            "text": "Hours",
            "color": "#CCCCCC",
            "show": false
        },
        "Minutes": {
            "text": "Minutes",
            "color": "#CCCCCC",
            "show": false
        },
        "Seconds": {
            "text": "Seconds",
            "color": "#2CCF17",
            "show": true
        }
    },
    "total_duration": 11});
	
    $('#time').css('visibility', 'visible');
    $('#time').TimeCircles().addListener(zeroTime);
    nextQuestion();
        
  	});

</script>
</body>

</html>

