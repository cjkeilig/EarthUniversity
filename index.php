<!DOCTYPE HTML>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/project.css">
</style>
</head>
<body>
<script src="/js/d3.v4.min.js"></script>
<script src="/js/topojson.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<h1>Click on a city to find a university or college!</h1>
<script>

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
	.defer(d3.json, "world-110m2.json")
	.defer(d3.json, "cities.php")
	.defer(d3.json,"colleges.php")
	.await(ready);
	
var g = svg.append("g")
	.attr("transform", "translate("+ margin.left + "," + margin.right + ")");
	
function clicked(d) {
  var x, y, k;
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

function ready(error, topology, cities, colleges) {
	var data = colleges.colleges;
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
	  .data(cities.cities)
	  .enter()
	    .append("circle")
		.attr("r",1)
		.style("fill","red")
		.attr("transform", function(d) {return "translate(" + projection([d.lng,d.lat]) + ")";})
		.on("click", function(d) {
		var arr = [];
		for(var i = 0;i<data.length;i++){
			if(data[i].city==d.city) {
				arr.push(data[i].name);
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
</script>
</body>
<footer><i><h3>Sources</h3><br>Cities: http://simplemaps.com/data/world-cities<br>Universities: https://ope.ed.gov/accreditation/GetDownLoadFile.aspx</i></footer>
</html>