<div class="container" style="margin-top: 30px;">
    <div class="row g-0 article-view-content">
        <?php foreach ($articles as $article) : ?>
            <?php if (empty($article['image'])) continue; ?>
            <div class="card mb-3 col-xl-12 col-md-6">
                <div class="row g-0 ">
                    <div class="col-xl-4 col-md-12">
                        <img src="<?= $article['image'] ?>" class="img-fluid rounded-start" alt="<?= $article['title'] ?>" style="width:100%;max-height:300px;" onerror="this.onerror=null; this.src='<?= base_url('assets/img/default.png') ?>';">
                    </div>
                    <div class="col-xl-8 co-md-12">
                        <div class="card-body">
                            <h5 class="card-title"><?= $article['title'] ?></h5>
                            <p class="card-text"><?= $article['description'] ?></p>
                            <p class="card-text"><small class="text-body-secondary">publishedAt
                                    :<?= $article['publishedAt'] ?></small></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="<?= base_url('assets/js/article.js?v=' . time()) ?>"></script>