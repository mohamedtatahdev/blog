<?php
$filename = __DIR__ . '/data/articles.json';
$articles = [];
$categories = [];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedCat = $_GET['cat'] ?? '';

if (file_exists($filename)) {
  $articles = json_decode(file_get_contents($filename), true) ?? [];
  $cattmp = array_map(fn ($a) => $a['category'],  $articles);
  $categories = array_reduce($cattmp, function ($acc, $cat) {
    if (isset($acc[$cat])) {
      $acc[$cat]++;
    } else {
      $acc[$cat] = 1;
    }
    return $acc;
  }, []);
  $articlePerCategories = array_reduce($articles, function ($acc, $article) {
    if (isset($acc[$article['category']])) {
      $acc[$article['category']] = [...$acc[$article['category']], $article];
    } else {
      $acc[$article['category']] = [$article];
    }
    return $acc;
  }, []);
}

?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
<?php require_once 'includes/head.php' ?>
<title>Blog Du Dev</title>
</head>
<body>
    
<?php require_once 'includes/header.php' ?>

<main>
<?php require_once 'includes/main_header.php' ?>

    <section class="blog_area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-5 mb-lg-0">
                    <div class="blog_left_sidebar">
                    <?php if(!$selectedCat) : ?>
                                <?php foreach ($articles as $a) : ?>
                                    <article class="blog_item">
                                        <div class="blog_item_img">
                                            <img class="card-img rounded-0" src="<?= $a['image'] ?>" alt="">
                                        </div>
                                        <div class="blog_details">
                                            <a class="d-inline-block" href="/show-article.php?id=<?= $a['id'] ?>">
                                                <h2 class="blog-head" style="color: #2d2d2d;"><?= $a['title'] ?></h2>
                                            </a>
                                            <p><?= implode(' ', array_slice(str_word_count($a['content'], 1), 0, 30)) ?>...</p>
                                            <ul class="blog-info-link">
                                                <li><a href="#"><i class="fa fa-user"></i> Travel, Lifestyle</a></li>
                                            </ul>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?php foreach ($articlePerCategories[$selectedCat] as $a) : ?>

                            <article class="blog_item">
                            <div class="blog_item_img">
                                <img class="card-img rounded-0" src="<?= $a['image'] ?>" alt="">
                            </div>
                            <div class="blog_details">
                                <a class="d-inline-block" href="/show-article.php?id=<?= $a['id'] ?>">
                                    <h2 class="blog-head" style="color: #2d2d2d;"><?= $a['title'] ?></h2>
                                </a>
                                <p><?= implode(' ', array_slice(str_word_count($a['content'], 1), 0, 30)) ?>...</p>
                                <ul class="blog-info-link">
                                    <li><a href="#"><i class="fa fa-user"></i> Travel, Lifestyle</a></li>
                                </ul>
                            </div>
                        </article>
                        <?php endforeach; ?>

                        <?php endif; ?>
                        <!-- <nav class="blog-pagination justify-content-center d-flex">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a href="#" class="page-link" aria-label="Previous">
                                        <i class="ti-angle-left"></i>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link">1</a>
                                </li>
                                <li class="page-item active">
                                    <a href="#" class="page-link">2</a>
                                </li>
                                <li class="page-item">
                                    <a href="#" class="page-link" aria-label="Next">
                                        <i class="ti-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav> -->
                    </div>
                </div>
                <?php require_once 'includes/categories.php' ?>
            </div>
        </div>
    </section>
   
</main>

<?php require_once 'includes/footer.php' ?>

  <div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>


<script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="./assets/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="./assets/js/owl.carousel.min.js"></script>
<script src="./assets/js/slick.min.js"></script>
<!-- One Page, Animated-HeadLin -->
<script src="./assets/js/wow.min.js"></script>
<script src="./assets/js/animated.headline.js"></script>

<!-- Nice-select, sticky -->
<script src="./assets/js/jquery.nice-select.min.js"></script>
<script src="./assets/js/jquery.sticky.js"></script>
<script src="./assets/js/jquery.magnific-popup.js"></script>

<!-- contact js -->
<script src="./assets/js/contact.js"></script>
<script src="./assets/js/jquery.form.js"></script>
<script src="./assets/js/jquery.validate.min.js"></script>
<script src="./assets/js/mail-script.js"></script>
<script src="./assets/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->	
<script src="./assets/js/plugins.js"></script>
<script src="./assets/js/main.js"></script>

</body>
</html>