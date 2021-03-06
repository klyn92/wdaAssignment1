<html>
	<head>
		<title>
			Wine Store Search Result
		</title>
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
		
		
		$connection = mysqli_connect ("localhost", "root", "", "winestore");
		
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		if ($regionName == "All")
			$regionName = "";
					
		if ($minYear == NULL)
			$minYear = "1970";
			
		if ($maxYear == NULL)
			$maxYear == "1999";
			
		if ($minCost == NULL)
			$minCost = "0";
			
		if ($maxCost == NULL)
			$maxCost = "35";
			
		
		//Results
		$result = mysqli_query($connection,
		
		//SQL Statement
		
		
		"SELECT wine.wine_id, wine.wine_name, wine.wine_type, wine.year, wine.winery_id, wine.description, winery.winery_name, region.region_name, grape_variety.variety, inventory.on_hand, inventory.cost, count (wine.wine_id) AS cust,
		
		#ADDED TEST
		
		items.qty, customer.firstname, customer.cust_id
		
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
				ON wine.wine_id = inventory.wine_id
				
		#ADDED TEST

			INNER JOIN items
				ON items.wine_id = wine.wine_id
			INNER JOIN customer
				ON items.cust_id = customer.cust_id
				
		WHERE wine.wine_name like '%$wineName%'
		and region.region_name like '%$regionName%'
		and winery.winery_name like '%$wineryName%'
		and wine.year BETWEEN '$minYear' AND '$maxYear'
		and inventory.on_hand >= '$inStock'
		#and items.qty >= '$numOfCustomer'
		and inventory.cost BETWEEN '$minCost' AND '$maxCost'
		
		#ADDED TEST
		
		GROUP BY wine.wine_id
		HAVING count(wine.wine_id) >= '$numOfCustomer'
		ORDER BY wine.wine_id, wine.wine_name, wine.year");
		
		$num_rows = mysql_num_rows($result);
		
		if ($num_rows > 0)
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
						
						#ADDED TEST
						
						echo "<td align='center' >" . $row['cost'] . "</td>";
						echo "<td align='center' >" . $row['cust'] . "</td>";
						
						#ADDED TEST
						
						#echo "<td align='center' >" . $row['firstname'] . "</td>";
						echo "</tr>";
					}
			
			echo "</table>";
				 
		}
			else
			{
				echo "No Record Found";
				echo "<br />";echo "<br />";
				echo "<button onclick='goBack()'>Go Back</button>";
			}
			
		mysqli_close($connection);
		
	?>
	</body>	
</html>