
<option value="">เลือกรายการ</option>
<?php
include_once ($_SERVER ["DOCUMENT_ROOT"] . '/lib/application.php');

$sql = "SELECT * FROM " . $category->getTbl() . " WHERE status = 'ใช้งาน'";

$query = $db->Query($sql);

while ($row = $db->FetchArray($query)) {

    if ($arr_link_to [0] == 'category') {
        ?>
    
        <option
        <?php echo $row['id'] == $arr_link_to[1] ? ' selected="selected"' : ''; ?>
            value="<?php echo "category" . "-" . $row['id'] ?>"><?php echo $row['category_name'] ?></option>
        <?php } else { ?>
        
        <option value="<?php echo "category" . "-" . $row['id'] ?>"><?php echo $row['category_name'] ?></option>
        <?php
    }
    ?>
    <?php
    $sql2 = "SELECT * FROM " . $products->getTbl() . " WHERE status = 'ใช้งาน' AND category_id = " . $row ['id'] . "";
    $query2 = $db->Query($sql2);
    while ($row2 = $db->FetchArray($query2)) {
    	
        if ($arr_link_to [0] == 'product') {
            ?>
        
            <option
            <?php echo $row2['id'] == $arr_link_to[1] ? ' selected="selected"' : ''; ?>
                value="<?php echo "product" . "-" . $row2['id'] ?>"> ---- <?php echo $row2['product_name'] ?></option>
                <?php } else { ?>


		
            <option value="<?php echo "product" . "-" . $row2['id'] ?>"> ---- <?php echo $row2['product_name'] ?></option>
            <?php } ?>



        
    <?php } ?>
<?php } ?>


?>
