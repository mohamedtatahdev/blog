<?php
const ERROR_REQUIRED = 'Veuillez renseignez ce champ';
const ERROR_TITLE_TOO_SHORT = 'Le titre est trop court';
const ERROR_CONTENT_TOO_SHORT = 'L\'article est trop court';
const ERROR_IMAGE_URL = 'L\'image doit être une url valide';
$filename = __DIR__ . '/data/articles.json';
$errors = [
    'title' => '',
    'image' => '',
    'category' => '',
    'content' => '',
];

$category = '';

if (file_exists($filename)) {
    $articles = json_decode(file_get_contents($filename), true) ?? [];
}
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if ($id) {
    $articleIndex = array_search($id, array_column($articles, 'id'));
    $article = $articles[$articleIndex];
    $title = $article['title'];
    $image = $article['image'];
    $category = $article['category'];
    $content = $article['content'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = filter_input_array(INPUT_POST, [
        'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'image' => FILTER_SANITIZE_URL,
        'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
        ]
    ]);
    $title = $_POST['title'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';

    if (!$title) {
        $errors['title'] = ERROR_REQUIRED;
    } elseif (mb_strlen($title) < 5) {
        $errors['title'] = ERROR_TITLE_TOO_SHORT;
    }

    if (!$image) {
        $errors['image'] = ERROR_REQUIRED;
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = ERROR_IMAGE_URL;
    }

    if (!$category) {
        $errors['category'] = ERROR_REQUIRED;
    }

    if (!$content) {
        $errors['content'] = ERROR_REQUIRED;
    } elseif (mb_strlen($content) < 50) {
        $errors['content'] = ERROR_CONTENT_TOO_SHORT;
    }

    if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
        if ($id) {
          $articles[$articleIndex]['title'] = $title;
          $articles[$articleIndex]['image'] = $image;
          $articles[$articleIndex]['category'] = $category;
          $articles[$articleIndex]['content'] = $content;
        } else {
            $articles = [...$articles, [
                'title' => $title,
                'image' => $image,
                'category' => $category,
                'content' => $content,
                'id' => time()
              ]];
            }
            file_put_contents($filename, json_encode($articles));
            header('Location: /');
          }

}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="assets/css/form-article.css">
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
                                <h2><?= $id ? 'Modifier' : 'Rédiger' ?> un article</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-form section-padding">
            <div class="col-12">

                <form action="/form-article.php<?= $id ? "?id=$id" : '' ?>" method="post">

                    <div class="form-group">
                        <input type="text" name="title" id="title" placeholder="Sujet" class="form-control" value="<?= $title ?? '' ?>">
                        <?php if ($errors['title']) : ?>
                            <p class="text-danger"><?= $errors['title'] ?></p>
                        <?php endif; ?>
                    </div>



                    <div class="form-group">
                        <input type="text" name="image" id="image" placeholder="Image" class="form-control" value="<?= $image ?? '' ?>"">
                        <?php if ($errors['image²']) : ?>
                                <p class=" text-danger"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                    </div>



                    <select name="category" id="category" class="form-group" value=<?= $category ?? '' ?>>
                        <option value="" disabled selected>Sélectionnez une catégorie</option>
                        <option <?= !$category || $category === 'physiologique' ? 'selected' : '' ?> value="physiologique">Besoin physiologique</option>
                        <option <?= !$category || $category === 'securite' ? 'selected' : '' ?> value="securite">Besoin de sécurité</option>
                        <option <?= !$category || $category === 'appartenance' ? 'selected' : '' ?> value="appartenance">Besoin d'appartenance et d'amour </option>
                        <option <?= !$category || $category === 'estime' ? 'selected' : '' ?> value="estime">Besoin d'estime</option>
                        <option <?= !$category || $category === 'accomplissement' ? 'selected' : '' ?> value="accomplissement">Besoin d'accomplissement personnel </option>
                    </select>
                    <?php if ($errors['category']) : ?>
                        <p class="text-danger"><?= $errors['category'] ?></p>
                    <?php endif; ?>




                    <div class="form-group">
                        <textarea name="content" id="content" placeholder="Contenu" class="form-control w-100"><?= $content ?? '' ?></textarea>
                        <?php if ($errors['content']) : ?>
                            <p class="text-danger"><?= $errors['content'] ?></p>
                        <?php endif; ?>
                    </div>



                    <div class="form-group mt-3 d-flex justify-content-end ">
                        <button class="boxed-btn mr-4" type="button">Annuler</button>
                        <button class="btn " type="submit"><?= $id ? 'Modifier' : 'Sauvegarder' ?></button>
                    </div>


                </form>


            </div>



        </div>



    </main>

    <?php require_once 'includes/footer.php' ?>



    <!-- JS here -->

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