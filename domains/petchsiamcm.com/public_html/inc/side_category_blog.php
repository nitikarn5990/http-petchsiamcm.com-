
            <div class="row">
                <div class="col-md-12">
                    <div class="product-name">
                        <h2 class="title-bar" style="float:left;">Blog Category 
                            <div class="title-border"></div>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="well" style="">
                <div style="">
                    <ul class="nav nav-list">
                   
                        <?php
                        
							$sql = "SELECT * FROM " . $blog_category->getTbl() . " WHERE status = 'ใช้งาน'";
							
							//$result_list = array();
							$query = $db->Query($sql);
							while($row = $db->FetchArray($query)){  ?>
                        <li>
                            <label class="tree-toggler nav-header"><a href="<?php echo ADDRESS ."blog/" .$row['category_name_ref']?>.html" style="  color: #898989;
  text-decoration: none;"><?php echo $row['category_name'];?> </a></label>
                            <ul class="nav nav-list tree">
                                <?php
                        
							$sql2 = "SELECT * FROM " . $blog->getTbl() . " WHERE status = 'ใช้งาน' AND blog_category_id = ". $row['id'] ."";
							
							//$result_list = array();
							$query2 = $db->Query($sql2);
							while($row2 = $db->FetchArray($query2)){  ?>
                                <li><a href="<?php echo ADDRESS ."blog/" .$row['category_name_ref'] . "/" . $row2['blog_name_ref'] ?>.html"><?php echo $row2['blog_name'];?></a></li>
                                <?php }?>
                                
                                <!--       <li>
                                    <label class="tree-toggler nav-header">Header 1.1</label>
                                    <ul class="nav nav-list tree">
                                        <li><a href="#">Link</a></li>
                                        <li><a href="#">Link</a></li>
                                        <li>
                                            <label class="tree-toggler nav-header">Header 1.1.1</label>
                                            <ul class="nav nav-list tree">
                                                <li><a href="#">Link</a></li>
                                                <li><a href="#">Link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>-->
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <?php	}?>
                    </ul>
                </div>
            </div>
            
            
                   
        
        
        
        
        <style>
		ul.nav.nav-list.tree li a{ padding:5px 10px !important; }
		</style>