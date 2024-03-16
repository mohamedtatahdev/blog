<?php
$filename = __DIR__ . '/data/articles.json';
$articles = [];
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';
$categories = [];
$selectedCat = $_GET['cat'] ?? '';



if (!$id) {
  header('Location: /');
} else {
  if (file_exists($filename)) {
    $articles = json_decode(file_get_contents($filename), true) ?? [];
    $articleIndex = array_search($id, array_column($articles, 'id'));
    $article = $articles[$articleIndex];
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
}






?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <?php require_once 'includes/head.php' ?>
  <title>Article</title>
</head>

<body>

  <?php require_once 'includes/header.php' ?>

  <main>
    <!--? Hero Start -->
    <div class="slider-area2">
      <div class="slider-height2 d-flex align-items-center">
        <div class="container">
          <div class="row">
            <div class="col-xl-12">
              <div class="hero-cap hero-cap2 pt-70">
                <h2>Blog Details</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="blog_area single-post-area section-padding">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 posts-list">
            <div class="single-post">
              <div class="feature-img">
                <img class="img-fluid" src="<?= $article['image'] ?>" alt="">
              </div>
              <div class="blog_details">
                <h2 style="color: #2d2d2d;"><?= $article['title'] ?>
                </h2>
                <ul class="blog-info-link mt-3 mb-4">
                  <li><a href="#"><i class="fa fa-user"></i> Travel, Lifestyle</a></li>
                  <li><a href="#"><i class="fa fa-comments"></i> 03 Comments</a></li>
                </ul>
                <p class="excert">
                <?= $article['content'] ?>
                </p>

                <div class="form-group mt-3 d-flex justify-content-end ">
                        <a href="/delete-article.php?id=<?= $article['id'] ?>" class="boxed-btn mr-4" type="submit">Supprimer</a>
                        <a href="/form-article.php?id=<?= $article['id'] ?>" class="btn" type="submit">Modifier</a>
                    </div>
              </div>
            </div>
          </div>
            
            
              
          <?php require_once 'includes/categories.php' ?>

        </div>
      </div>
    </section>
    <!-- Blog Area End -->
    <!-- ? services-area -->
    
  </main>
  <?php require_once 'includes/footer.php' ?>

 
  <div id="back-top">
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
  <script src="./assets/js/jquery.magnific-popup.js"></script>

  <!-- Nice-select, sticky -->
  <script src="./assets/js/jquery.nice-select.min.js"></script>
  <script src="./assets/js/jquery.sticky.js"></script>

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