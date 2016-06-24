<?php 
	$sql = "SELECT * FROM " . $slides->getTbl() . " WHERE status = 'ใช้งาน'";
				$query = $db->Query($sql);
				$numRow = $db->NumRows($query);
				if($numRow > 0){
				echo "<div>";
                echo " <ul class='bxslider'>";
				
					while ($row = $db->FetchArray($query)){
?>
						 <li><img src="<?php echo ADDRESS_SLIDES . $slides_file->getDataDescLastID("file_name", "slides_id = ".$row['id']) ?>" class="img-responsive"></li>
						
<?php			
					}
					echo "</ul>";
					echo "</div>";
						  
				}







?>

