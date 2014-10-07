<html>
<head>
	<title>
		Search Wine Store
	</title>
</head>
<body>
	<h2>
		<b>Search Option</b>
	</h2>
	<form action = "winestore_query.php" method = "GET">
		<table>
			<tr>
				<td>
					Wine Name
				</td>
				<td>
					<input type = "text" name = "wineName" size = "20" maxlength = "30"/>
				</td>
			</tr>
			<tr>
				<td>
					Region
				</td>
				<td>
					<?php
						$connect = mysqli_connect ("localhost", "root", "", "winestore");
	
						if(mysqli_connect_errno()){
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}
					
						$regiondb = mysqli_query($connect, "SELECT * FROM region");
					
						echo "<select name = 'region_name'>";
							
						while ($region = mysqli_fetch_array($regiondb)){
							$region_query = $region["region_name"];
							
							echo "<option>";
							echo $region_query;
							echo "</option>";
						}
						
						echo "</select>";
					?>
				</td>
			</tr>	
			<tr>
				<td>
					Winery Name
				</td>
				<td>
					<input type = "text" name = "wineryName" size "20" maxlength = "30"/>
				</td>
			</tr>
			<tr>
				<td>
					Year
				</td>
				<td>
					<input type = "text" name = "minYear" size = "10" maxlength = "4"/>
					-
					<input type = "text" name = "maxYear" size = "10" maxlength = "4"/>
				</td>
			</tr>
			<tr>
				<td>
					Minimum number of wine in stock
				</td>
				<td>
					<input type = "text" name = "inStock" size = "10" maxlength = "4"/>
				</td>	
			</tr>
			<tr>
				<td>
					Minimum number of customers whom have purchased each wine
				</td>
				<td>
					<input type = "text" name = "numOfCustomer" size = "10" maxlength = "4"/>
				</td>	
			</tr>	
			<tr>
				<td>
					Cost Range
				</td>
				<td>
					<input type = "text" name = "minCost" size = "10" maxlength = "5"/>
					-
					<input type = "text" name = "maxCost" size = "10" maxlength = "5"/>
				</td>	
			</tr>
			<tr>
				<td colspan = "2">
					<input type = "submit" value = "Search"/>
				</td>
			</tr>
		</table>
	</form>	
</body>
</html>