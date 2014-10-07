<html>
<head>
	<title>
		Wine Store Search Result
	</title>
</head>

<body>
	<?php
		$connect = mysqli_connect ("localhost", "root", "", "winestore");
		
		if (mysqli_connect_errno()_
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$wineName = $_GET ['wineName'];
		$regionName = $_GET ['regionName'];
		$wineryName = $_GET ['wineryName'];
		$minYear = $_GET ['minYear'];
		$maxYear = $_GET ['maxYear'];
		$inStock = $_GET ['inStock'];
		$numOfCustomer = $_GET ['numOfCustomer'];
		$minCost = $_GET ['minCost'];
		$maxCost = $_GET ['maxCost'];
		
		if ($minYear == NULL)
			$minYear = "1970";
			
		if ($maxYear == NULL)
			$maxYear == "1999";
			
		if ($minCost == NULL)
			$minCost = "0";
			
		if ($maxCost == NULL)
			$maxCost = "30";
	?>
</body>	
</html>