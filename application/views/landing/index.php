<div class="container px-lg-5">
    <div class="row my-4">
        <div class="col-12 text-center py-2 py-lg-3">
            <a href="/">
                <img src="/public/pictures/main/front_infoblocks/<?= $this->infoblocks['header_logo']['img'] ?>-1.webp" class="img-fluid mt-2 mt-lg-3 align-self-center logo" alt="">
            </a>
        </div>
    </div>
    <?php
    $slides = '';
    $buttons = '';
    $counter = 0;
    foreach ($this->banners as $banner) {
        $buttons .= '<button type="button" data-bs-target="#carousel" data-bs-slide-to="' . $counter . '" class="' . ($counter == 0 ? 'active' : '') . '" aria-current="true"></button>';
        $slides .= '<div class="carousel-item active"><img src="/public/pictures/main/front_slider/' . $banner['img_lnd'] . '-1.webp" class="d-block w-100" alt=""></div>';
        $counter++;
    } ?>
    <div id="carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?= $buttons ?>
        </div>
        <div class="carousel-inner">
            <?= $slides ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="row my-5">
        <div class="col">
            <?php foreach ($this->buttons as $button) { ?>
                <a href="<?= $button['url'] ?>" class="btn btn-lg btn-primary w-100 py-3 mb-3 shadow"><?= $button['title'] ?></a>
            <?php } ?>
        </div>
    </div>
</div>