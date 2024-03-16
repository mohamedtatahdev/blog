<div class="col-lg-4">
                    <div class="blog_right_sidebar">
                        <aside class="single_sidebar_widget post_category_widget">
                            <h4 class="widget_title" style="color: #2d2d2d;">Category</h4>
                            <ul class="list cat-list">
                                <li><a href="/" class="d-flex">
                                <p class="mr-2">Tous les articles</p>    
                                <p>(<?= count($articles) ?>)</p> </a></li>
                                <?php foreach ($categories as $catName => $catNum) : ?>
                                <li>
                                    <a href="/?cat=<?= $catName ?>" class="d-flex">
                                        <p class="mr-2"><?= $catName ?></p>
                                        <p>(<?= $catNum ?>)</p>
                                    
                                    </a>
                                </li>
                                <?php endforeach ?>
                            </ul>
                        </aside>
                    </div>
                </div>