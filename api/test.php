<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
		<script>
			$(document).ready(function(){
				$('#event').click(function(){
					$.ajax({
url: "customer/printer.php",
type: "get",
data: {'invoice':'{"invoice":{"custID":"C00001","restID":"R00001","address":"123 road","tableID":null,"totalCost":100,"charge":[{"chargeID":"999"}],"food":[{"foodID":"F00001","quantity":3,"specialOption":[{"optID":"OPT00001"}]}],"set":[{"setID":"S00001","quantity":1,"setOrderChoice":[{"foodNo":"F00001","quantity":2,"specialOption":[{"optID":"OPT00001"}]}]}]}}'},
datatype: 'json',
						success: function(data){
							$('#result').html(data);
							//var json=jQuery.parseJSON(data);
							//var image = 'http://localhost/api/'+json.data.Restaurant.restaurant.restPhoto;
							
							//$('#result').html('<img src="'+image+'"/>');
						},
						error:function(){
							$("#result").html('There was an error updating the settings');
						}
					}); 
				});
			});
			</script>
	</head>
	<body>
		<button id="event">Click</button>
		<div id="result"></div>
	</body>
	</html>