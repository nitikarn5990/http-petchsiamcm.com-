<?php
//meta url
$url = ADDRESS;
if ($_GET['controllers'] != '') {

    $url .= $_GET['controllers'];
}
if ($_GET['catID'] != '') {

    $url .= '/' . $_GET['catID'];
}
if ($_GET['productID'] != '') {

    $url .= '/' . $_GET['productID'];
}
$url .= ".html";

//meta des key

if ($_GET['controllers'] != '' && $_GET['controllers'] == 'product') {
    if ($_GET['catID'] != '' && $_GET['productID'] == '') {

        $meta_title = $category->getDataDesc("meta_title", "category_name_ref = '" . $_GET['catID'] . "'");
        $meta_keywords = $category->getDataDesc("meta_keywords", "category_name_ref = '" . $_GET['catID'] . "'");
        $meta_descriptions = $category->getDataDesc("meta_descriptions", "category_name_ref = '" . $_GET['catID'] . "'");
    }
    if ($_GET['productID'] != '' && $_GET['catID'] != '') {

        $meta_title = $products->getDataDesc("meta_title", "product_name_ref = '" . $_GET['productID'] . "'");
        $meta_keywords = $products->getDataDesc("meta_keywords", "product_name_ref = '" . $_GET['productID'] . "'");
        $meta_descriptions = $products->getDataDesc("meta_descriptions", "product_name_ref = '" . $_GET['productID'] . "'");
    }
}
if ($_GET['controllers'] != '' && $_GET['controllers'] == 'blog') {
    if ($_GET['productID'] != '' && $_GET['catID'] != '') {

        $meta_title = $blog->getDataDesc("meta_title", "blog_name_ref = '" . $_GET['productID'] . "'");
        $meta_keywords = $blog->getDataDesc("meta_keywords", "blog_name_ref = '" . $_GET['productID'] . "'");
        $meta_descriptions = $blog->getDataDesc("meta_descriptions", "blog_name_ref = '" . $_GET['productID'] . "'");
    }
}

//meta type
if ($_GET['controllers'] != '') {
    if ($_GET['controllers'] == 'product') {

        $type = "product";
    } else if ($_GET['controllers'] == 'blog') {

        $type = "website";
    }
} else {

    $type = "website";
}
?>

<title><?php echo $meta_title ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="<?php echo $meta_descriptions ?>">
<meta name="keywords" content="<?php echo $meta_keywords ?>">


<meta http-equiv="content-language" content="th">
<meta property="og:title" content="<?php echo $meta_title ?>">
<meta property="og:description" content="<?php echo $meta_descriptions ?>">
<meta property="og:type" content="<?php echo $type ?>">
<meta property="og:url" content="<?php echo $url ?>">


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="stylesheet" href="<?php echo ADDRESS ?>css/style.css">

<script src="<?php echo ADDRESS ?>js/jquery1.11.2.min.js"></script>

<script src="<?php echo ADDRESS ?>js/bootstrap.min.js"></script>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<script src="<?php echo ADDRESS ?>js/jquery.bxslider.min.js"></script>

<!-- bxSlider CSS file -->
<link href="<?php echo ADDRESS ?>css/jquery.bxslider.css" rel="stylesheet" />

<!-- date picker-->
<link href="<?php echo ADDRESS ?>css/jquery_ui.css" rel="stylesheet" />
<script src="<?php echo ADDRESS ?>js/jquery_ui.js"></script>



<script type="text/javascript">

    $(document).ready(function () {

        $('.bxslider').bxSlider({
            mode: 'fade',
            auto: true,
            infiniteLoop: true

        });

    });

</script>


<style>

    .bxslider, .no-padding {

        padding: 0px;

    }

</style>