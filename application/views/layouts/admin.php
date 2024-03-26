<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->title ?></title>
    <meta property="og:image" content="/public/img/logo/logo.png">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/public/css/chosen.css">
    <link rel="stylesheet" href="<?= $this->adminDir ?>css/datatables.min.css">
    <link rel="stylesheet" href="<?= $this->adminDir ?>css/main.css">
    <link rel="shortcut icon" href="/public/img/ico/shortcut.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/public/img/ico/shortcut.png">
    <link rel="shortcut icon" href="/public/img/ico/favicon.svg" type="image/svg">
</head>
<body>
    <div class="container-fluid h-100" id="main">
        <div class="row h-100">
            <?php if ($this->messageOnly) { ?>
            <div class="text-center">
                <?= $this->content ?>
            </div>
            <?php } else { ?>
            <div class="col-6 col-md-4 col-lg-2 admnavigation">
                <div class="sticky-top pt-3 px-2">
                    <div class="d-grid gap-2 nav">
                        <?php
                        foreach ($this->config as $key => $value) { ?>
                            <a class="btn btn-primary shadow text-start mb-<?= $value['nav_break'] ? 4 : 1 ?> <?= $key == $this->section ? 'active' : '' ?>" href="/<?= $this->baseUrl . '/view/' . $key ?>">
                                <?= $value['icon'] ? '<span class="icon-' . $value['icon'] . ' pe-2"></span>' : '' ?>
                                <?= $value['navigation'] ?>
                            </a>
                        <?php } ?>
                        <a class="btn btn-secondary shadow mt-4 text-start" href="/<?= $this->baseUrl ?>/logout"><span class="icon-logout pr-1"></span>Выйти</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-8 col-lg-10 admcontent" id="<?= $this->section ?>">
                <div class="row">
                    <div class="col-10">
                        <h1 class="mb-4"><?= $this->h1 ?></h1>
                    </div>
                    <div class="col-2 text-end">
                        <?php if ($this->mode == 'view') { ?><a class="btn btn-primary" href="/<?=  $this->baseUrl . '/edit/' . $this->section ?>"><span class="icon-plus-circled"></span> Новая запись</a><?php } ?>
                    </div>
                    <div class="<?= $this->cssMainBlockClass ?>">
                        <?= $this->content ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirmModal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Удаление</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="modal-btn-yes">Да</button>
                    <button type="button" class="btn btn-secondary" id="modal-btn-no">Отмена</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let admFilesDir = "<?= $this->adminDir ?>";
        let admDir = "<?= $this->baseUrl ?>";
    </script>
    <script src="/public/js/bootstrap.min.js"></script>
    <script src="/public/js/jquery.min.js"></script>
    <script src="/public/js/jquery-ui.min.js"></script>
    <script src="/public/js/chosen.jquery.min.js"></script>
    <script src="<?= $this->adminDir ?>js/datatables.min.js"></script>
    <script src="<?= $this->adminDir ?>tinymce/tinymce.min.js"></script>
    <script src="<?= $this->adminDir ?>js/app.min.js"></script>
    <script>
        $(function() {
            tinymce.init({
                selector: "textarea.tiny",
                extended_valid_elements: 'span',
                width: '100%',
                convert_urls : false,
                menubar: "edit insert view",
                style_formats: [
                    {title: 'Заголовок 1', format: 'h1'},
                    {title: 'Заголовок 2', format: 'h2'},
                    {title: 'Заголовок 3', format: 'h3'},
                    {title: 'Заголовок 4', format: 'h4'},
                    {title: 'Параграф', format: 'p'},
                ],
                plugins: [
                    "responsivefilemanager advlist autolink link image lists charmap hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
                    "save table contextmenu directionality template paste textcolor"
                ],
                toolbar1: "styleselect fontsizeselect | table | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify superscript subscript",
                toolbar2: "undo redo | bullist numlist outdent indent | code pastetext charmap | link image responsivefilemanager",
                filemanager_title: "Менеджер файлов",
                external_filemanager_path: admFilesDir + "filemanager/",
                external_plugins: { "filemanager" : admFilesDir + "filemanager/plugin.min.js" },
                filemanager_access_key: "cq4CvJc29e8YOWRlT8l9guLM",
                language : 'ru',
            });
        });
    </script>
</body>
</html>