<html>
	<head>
		<title>
			Wine Store Search Result
		</title>
		
		<script>
			function goBack()
			{
				window.history.back()
			}
		</script>
	</head>

	<body>
	<?php
	
		$wineName = $_GET ["wineName"];
		$regionName = $_GET ['region_name'];
		$wineryName = $_GET ["wineryName"];
		$minYear = $_GET ["minYear"];
		$maxYear = $_GET ["maxYear"];
		$inStock = $_GET ["inStock"];
		$numOfCustomer = $_GET ["numOfCustomer"];
		$minCost = $_GET ["minCost"];
		$maxCost = $_GET ["maxCost"];
		
		
		$connect = mysqli_connect ("localhost", "root", "", "winestore");
 
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		if ($regionName == "All")
			$regionName = "";
					
		if ($minYear == NULL)
			$minYear = "1970";
			
		if ($maxYear == NULL)
			$maxYear = "1999";
					
		if ($minCost == NULL)
			$minCost = "0";
			
		if ($maxCost == NULL)
			$maxCost = "35";
		
		//SQL Statement		
		$select = "SELECT wine.wine_id, wine.wine_name, wine.winery_id, grape_variety.variety,wine.wine_type, wine.year, winery.winery_name, region.region_name, inventory.on_hand, inventory.cost, count(wine.wine_id) AS cust
		
		FROM wine
			INNER JOIN wine_variety
				ON wine_variety.wine_id = wine.wine_id
			INNER JOIN grape_variety
				ON grape_variety.variety_id = wine_variety.variety_id
			INNER JOIN winery
				ON wine.winery_id = winery.winery_id
			INNER JOIN region
				ON winery.region_id = region.region_id
			INNER JOIN inventory
				ON inventory.wine_id = wine.wine_id
			INNER JOIN items
				ON items.wine_id = wine.wine_id
			INNER JOIN customer
				ON items.cust_id = customer.cust_id
				
		WHERE wine.wine_name like '%" . $wineName . "%'
			AND	  region.region_name like '%" . $regionName . "%'
			AND	  winery.winery_name like '%" . $wineryName . "%'
			AND   wine.year BETWEEN '". $minYear ."' AND '". $maxYear . "'
			#AND   inventory.on_hand >= '". $inStock ."' 
			AND   inventory.cost BETWEEN '". $minCost ."'AND '". $maxCost ."'
		
	
		
		GROUP BY wine.wine_id
		HAVING count(wine.wine_id) >= '".$numOfCustomer."'
		ORDER BY wine.wine_id, wine.wine_name, wine.year";

		
		//Results
		$result = mysqli_query($connect, $select);
		
		$rowCount = mysqli_num_rows($result);
		
		if ($rowCount == 0)
		{
			echo "Results not found!";
			echo "<br/>";
			echo "<button onclick = 'goBack()'>Go Back</button>";
		}
		else
		{
			echo"<table border='1'>
				<tr bgcolor=#cccccc>
					<td  align='center'>Wine ID</td>
					<td  align='center'>Wine Name</td>
					<td align='center'>Wine Variety</td>
					<td width=50 align='center'>Year</td>
					<td  align='center'>Winery Name</td>
					<td  align='center'>Region Name</td>
					<td  align='center'>Inventory</td>
					<td width=50 align='center'>Cost</td>
					<td  align='center'>Quantity Purchased</td>
												
				</tr>";
							
					while  ($row = mysqli_fetch_array($result))
					{
						echo "<tr>";	
						echo "<td >" . $row['wine_id'] . "</td>";					
						echo "<td >" . $row['wine_name'] . "</td>";
						echo "<td >" . $row['variety'] . "</td>";
						echo "<td align='center' >" . $row['year'] . "</td>";
						echo "<td >" . $row['winery_name'] . "</td>";
						echo "<td >" . $row['region_name'] . "</td>";
						echo "<td align='center' >" . $row['on_hand'] . "</td>";
						
				
						echo "<td align='center' >" . $row['cost'] . "</td>";
						echo "<td align='center' >" . $row['cust'] . "</td>";
						
						
						echo "</tr>";
					}
					
		}
			echo "</table>";
				
		mysqli_close($connect);
		
	?>
	</body>	
</html>