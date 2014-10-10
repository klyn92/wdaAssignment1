<?php

	echo "<script>
			function goBack()
			{
				window.history.back()
			}
		</script>";
	

set_include_path('C:/wamp/bin/php/php5.5.12/pear');
require_once "HTML/Template/IT.php";
require "db2.inc";


if (!($connection =  @mysql_connect('localhost','root','')))
     die("Could not connect");
	 

 if (!(mysql_select_db("winestore", $connection)))
     showerror();
 
	$wineName = $_GET ["wineName"];
	$regionName = $_GET ['region_name'];
	$wineryName = $_GET ["wineryName"];
	$minYear = $_GET ["minYear"];
	$maxYear = $_GET ["maxYear"];
	$inStock = $_GET ["inStock"];
	$numOfCustomer = $_GET ["numOfCustomer"];
	$minCost = $_GET ["minCost"];
	$maxCost = $_GET ["maxCost"];
		
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
	 
	 
	$query= "SELECT wine.wine_id, wine.wine_name, wine.winery_id, grape_variety.variety,wine.wine_type, wine.year, winery.winery_name, region.region_name, inventory.on_hand, inventory.cost, count(wine.wine_id) AS cust
		
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
		
		if (!($result = @mysql_query ($query, $connection)))
			showerror();
		
	$template=new HTML_Template_IT(".");
	$template->loadTemplatefile("pear_template.tpl",true,true);	
  
     $rowsFound = @mysql_num_rows($result);
		
  
	 if ($rowsFound == 0)
    {
		echo "Results not found!";
		echo "<br/>";
		echo "<button onclick='goBack'>Go Back</button>";
	}
	else
	{
 
		while ($row = mysql_fetch_array($result))
		{
		 
			$template->setCurrentBlock("WINESTORE");
			$template->setVariable("WINEID", $row['wine_id']);
			$template->setVariable("WINENAME", $row['wine_name']);
			$template->setVariable("VARIETY", $row['variety']);
			$template->setVariable("YEAR", $row['year']);
			$template->setVariable("WINERYNAME", $row['winery_name']);
			$template->setVariable("REGIONNAME", $row['region_name']);
			$template->setVariable("INVENTORY", $row['on_hand']);
			$template->setVariable("PRICE", $row['cost']);
			$template->setVariable("NUMBEROFCUSTOMERS", $row['cust']);
			$template->parseCurrentBlock();
		}
		$template->show();
    } 		

?>
