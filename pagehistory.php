<?php
include ("db_connect.inc");
session_start();
include ("header.inc");
include ("navbar.inc");

echo "<article id='main'>";
if ( isset($_SESSION['first_name']) AND isset($_SESSION['user_name']) AND $_SESSION['auth_lev']==3 ) {
	echo "<h3>Page History</h3>";

	if ($_GET["pageID"]) {
		$pageID=$_GET["pageID"];
		
		$query1 = "SELECT `Page_ID`, `Page_Iteration`, `Active` FROM `Cust_Pages_DATA` WHERE `Page_ID`=".$pageID;
		$result0 = mysqli_query($cxn,$query1) or die ("Couldn't execute query.");
		if ($row0 = mysqli_fetch_assoc($result0)) {
			//$row0['Page_Iteration'];
			
			//echo "<table class='news'>\r\n";
			//echo "<tr><th>Page Iteration</th><th>Parent Iteration</th><th>Page Title</th><th>Last Modified</th><th>Last Author</th><th>Active</th></tr>";
			
			$result1 = mysqli_query($cxn,"SELECT Cust_Pages.Page_Iteration, Cust_Pages.Parent_Iteration, Cust_Pages.Title, Cust_Pages.Last_Modified, Users.User_Name FROM Cust_Pages LEFT JOIN Users ON Cust_Pages.Last_Author=Users.ID WHERE Cust_Pages.Page_ID=$pageID ORDER BY Page_Iteration ASC");
			$test1 = [];
			//while ($row1 = $result1->fetch_assoc()) {
			while($row1 = mysqli_fetch_array($result1)) {
				$test1[]=$row1;
			}
			
			$result2 = mysqli_query($cxn,"SELECT Cust_Pages_DATA.Page_Iteration FROM Cust_Pages_DATA WHERE Cust_Pages_DATA.Page_ID=$pageID AND Cust_Pages_DATA.Active=1;");
			$test2 = [];
			//while ($row2 = $result2->fetch_assoc()) {
			while($row2 = mysqli_fetch_array($result2)) {
				$test2[]=$row2;
			}
			
			echo "<table class='news'>\r\n";
			echo "<tr><th>Page Iteration</th><th>Parent Iteration</th><th>Page Title</th><th>Last Modified</th><th>Last Author</th><th>Active</th></tr>";
	
	/*		
				if (isset($test2[$x][0])) {
			for ($x=0; $x<count($test1); $x++) {
					$test3 = $test2[$x][0];
					//echo $test3;
				} else {
					$test3 = NULL;		
				}
				//echo $test1[$x][0].",".$test1[$x][1].",".$test1[$x][2].",".$test1[$x][3].",".$test1[$x]."<br>\r\n";
				if ($test1[$x][0] == $test3) {
					$pageName = preg_replace('/\s/', "_", $test1[$x][2]);			
					echo "<tr><td>".$test1[$x][0]."</td><td>".$test1[$x][1]."</td><td><a href=\"index.php?pageID=".$pageID."\">".$test1[$x][2]."</a></td><td>".$test1[$x][3]."</td><td>".$test1[$x][4]."</td><td>TRUE</td></tr>";
				} else {
					echo "<tr><td>".$test1[$x][0]."</td><td>".$test1[$x][1]."</td><td><a href=\"index.php?pageID={$pageID}&iteration=".$test1[$x][0]."\">".$test1[$x][2]."</a></td><td>".$test1[$x][3]."</td><td>".$test1[$x][4]."</td><td>FALSE</td></tr>";
				}
			}
	*/
			if ($row0['Active'] == 0) {
				$active = FALSE;			
			} else {
				$active = TRUE;			
			}
			
			for ($x=0; $x<count($test1); $x++) {
				//$row0['Page_Iteration'];
				if ($x == $row0['Page_Iteration']-1) {
					echo "<tr><td>".$test1[$x][0]."</td><td>".$test1[$x][1]."</td><td><a href=\"index.php?pageID=".$pageID."\">".$test1[$x][2]."</a></td><td>".$test1[$x][3]."</td><td>".$test1[$x][4]."</td>";
					if ($active == TRUE) {
						echo "<td>TRUE</td></tr>\r\n";
					} else {
						echo "<td>FALSE</td></tr>\r\n";				
					}
				} else {
					echo "<tr><td>".$test1[$x][0]."</td><td>".$test1[$x][1]."</td><td><a href=\"index.php?pageID={$pageID}&iteration=".$test1[$x][0]."\">".$test1[$x][2]."</a></td><td>".$test1[$x][3]."</td><td>".$test1[$x][4]."</td>";
					echo "<td>FALSE</td></tr>\r\n";
				}

			}						
					
			echo  "</table>\r\n";
		}
	} else {
		echo "<div class='error'>Error: Thread not specified</div>";
	}
} else {
	echo "<div class=\"error\">Restricted Area. You need administrative priviledges to access this page.</div>";
}

echo "</article>\r\n";
include ("footer.inc");
?>