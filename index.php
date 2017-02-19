<!DOCTYPE HTML>
<head>
<meta charset="UTF-8">
</style>
</head>
<body>
<?php
    $connectstr_dbhost = '';
	$connectstr_dbname = '';
	$connectstr_dbusername = '';
	$connectstr_dbpassword = '';

	foreach ($_SERVER as $key => $value) {
    if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
        continue;
    }
    echo $value;
    $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
    $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", "worker");
    $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
    $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}

	$link = mysqli_connect($connectstr_dbhost, $connectstr_dbusername, $connectstr_dbpassword,$connectstr_dbname);

	if (!$link) {
		echo "Error: Unable to connect to MySQL." . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
    /*$connection = mysqli_select_db("worker", $link);

    $myquery = "SELECT  `Institution_Name`, `Institution_city` FROM  `worker.colleges`";
    $query = mysqli_query($myquery);
    
    if ( ! $query ) {
        echo mysqli_error();
        die;
    }
    
    $data = array();
    
    for ($x = 0; $x < mysqli_num_rows($query); $x++) {
        $data[] = mysqli_fetch_assoc($query);
		echo mysqli_fetch_assoc($query);
    }
    
    echo json_encode($data);   */  
     
	echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
	echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

mysqli_close($link);
?>
<!--<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="https://d3js.org/topojson.v2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
<h1>Click on a city to find a university or college!</h1>
<!--<script>
var margin = {top: -5, right: -5, bottom: -5, left: -5};
var width = 1000,
	height = 600,
	centered;
	
var div = d3.select("body")
		    .append("div")   
    		.attr("class", "tooltip")               
    		.style("opacity", 0);
			
var projection = d3.geoMercator();
	

var svg = d3.select("body").append("svg")
	.attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom);
	


var path = d3.geoPath()
	.projection(projection);

d3.queue()
	.defer(d3.json, "json/world-110m2.json")
	.defer(d3.csv,"world_cities.csv")
	.await(ready);
	
var g = svg.append("g")
	.attr("transform", "translate("+ margin.left + "," + margin.right + ")");

//$.ajax({
//    url: "/usauni.csv",
//    async: true,
//    success: function (csvd) {
//        data = $.csv.toArrays(csvd);
//		
//    },
//   dataType: "text"
//});

d3.json("univ.php", function(error, data) {
    data.forEach(function(d) {
        d.date = parseDate(d.date);
        d.close = +d.close;
    });
	
function clicked(d) {
  var x, y, k;
;
  if (d && centered !== d) {
    var centroid = path.centroid(d);
    x = centroid[0];
    y = centroid[1];
    k = 4;
    centered = d;
  } else {
    x = width / 2;
    y = height / 2;
    k = 1;
    centered = null;
  }

  g.selectAll("path")
      .classed("active", centered && function(d) { return d === centered; });

  g.transition()
      .duration(750)
      .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")")
      .style("stroke-width", 1.5 / k + "px");

}

function ready(error, topology, cities) {
	if(error) throw error;
	svg.select("g")
	    .attr("class","countries")
	  .selectAll("path")
	  .data(topojson.feature(topology, topology.objects.countries)
			.features)
	  .enter().append("path")
		.attr("d", path)
		.on("click",clicked);
	
	svg.select("g")
	  .selectAll("circle")
	  .data(cities)
	  .enter()
	    .append("circle")
		.attr("r",1)
		.style("fill","red")
		.attr("transform", function(d) {return "translate(" + projection([d.lng,d.lat]) + ")";})
		.on("click", function(d) {
		var arr = [];
		for(var i = 0;i<data.length;i++){
			if(data[i][2]==d.city) {
				arr.push(data[i][1]);
			}
		}
		
    	$("div").css({
			"display": "block",
			"opacity": .9,
			"left": (d3.event.pageX) + "px",
			"top": (d3.event.pageY - 28) + "px",
			"height": (15*arr.length + 50) + "px"});
      	   
                
        $("div").text(d.city+"\n\n"+arr.toString().split(",").join("\n"));
   
		$("div").focus();
		$("div").on("mouseout",function() {
			$(this).css("display","none");
			
		});
		})
			
	  
}



</script> -->
</body>
</html>