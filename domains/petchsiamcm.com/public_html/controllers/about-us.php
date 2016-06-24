<div class="col-md-3">
    <?php include "inc/side_category.php"; ?>
</div>

<div class="col-md-9">
    <div class="product-name">
        <h1 class="title-bar">เกี่ยวกับเรา
            <div class="title-border"></div>
        </h1>
    </div>
    <p>&nbsp;</p>
    <article>

        <?php
        echo $html_detail = str_replace("../files", "files", $about->getDataDesc("about_detail", "id= 1"));
        ?>
    </article>
</div>



