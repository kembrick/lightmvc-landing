<form method="post" enctype="multipart/form-data">
<?php
$table = $this->config[$this->section]['table'];
$imgRoot = '/public/pictures/main/';
$img_path = $imgRoot . $table . '/';
foreach ($this->data['configEdit']['fields'] as $key => $field) {
    $value = $this->data['dataRow'][$key];
    if ($field['default'] && !isset($value))
        $value = $field['default'];
    ?>
    <div class="mb-3">
        <?php if ($field['type'] != 'checkbox') { ?>
            <label for="<?= $key ?>" class="form-label"><?= $field['title'] ?></label>
        <?php
        }
        switch ($field['type']) {
            case 'tiny':
            case 'textarea': ?>
                <textarea id="<?= $key ?>" class="form-control <?= $field['type'] ?: '' ?>" rows="<?= $field['type'] == 'tiny' ? 15 : 5 ?>" name="<?= $key ?>"><?= $value ?></textarea>
                <?php
                break;
            case 'checkbox':
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="<?= $key ?>" name="<?= $key ?>" value="1" <?= $value ? 'checked' : '' ?>>
                    <label for="<?= $key ?>" class="form-check-label"><?= $field['title'] ?></label>
                </div>
                <?php
                break;
            case 'radio': ?>
                <div>
                <?php
                foreach ($field['radio'] as $rk => $rv) {
                ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="<?= $key ?>" id="inlineRadio<?= $rk ?>" value="<?= $rk ?>" <?= $value == $rv ? 'checked' : '' ?>>
                        <label class="form-check-label" for="inlineRadio<?= $rk ?>"><?= $rv ?></label>
                    </div>
                <?php
                }
                ?>
                </div>
                <?php
                break;
            case 'select':
            case 'multiselect':
                ?>
                <select class="form-select" id="<?= $key ?>" data-placeholder="Выберите из списка..." <?= $field['type'] == 'multiselect' ? 'name="'. $key .'[]" multiple' : 'name="' .$key . '"' ?>>
                    <option value="0">Не задано</option>
                    <?php foreach ($this->data['dataSelect'][$key] as $s) { ?>
                        <option value="<?= $s['id'] ?>"
                            <?php
                            if ($field['type'] == 'multiselect') {
                                if (in_array($s['id'], $value))
                                    echo 'selected';
                            } else {
                                if ($s['id'] == $value)
                                    echo 'selected';
                            }
                            ?>
                        ><?= $s['name'] ?></option>
                    <?php } ?>
                </select>
                <?php
                break;
            case 'image':
                ?>
                <?php
                if ($value) { ?>
                    <div class="row">
                        <div class="col-4">
                            <img src="<?= $img_path . $value ?>-1.webp" class="thumbnail border border-2 border-secondary mb-2" alt="Предпросмотр">
                            <input name="oldImages[<?= $key ?>]" value="<?= $value ?>" type="hidden">
                        </div>
                        <div class="col-8 text-start">
                            <div><div class="btn btn-outline-primary editImage" data-id="<?= $key ?>">Изменить</div></div>
                            <div class="form-check form-switch my-3">
                                <input class="form-check-input" type="checkbox" id="del<?= $key ?>" name="delete[<?= $key ?>]" value="<?= $key ?>">
                                <label for="del<?= $key ?>" class="form-check-label">Удалить</label>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <input class="form-control <?= $value ? 'd-none' : '' ?>" id="<?= $key ?>" name="<?= $key ?>" type="file" accept=".png, .jpg, .jpeg, .webp">
                <?php break;
            case 'multiImage': ?>
                <div class="row mb-3">
                <?php foreach ($this->data['multiImage'][$key] as $mk => $multiImage) { ?>
                    <div id="rec<?= $mk ?>" class="col-lg-2 text-center">
                        <img src="<?= $imgRoot . $this->data['configEdit']['fields'][$key]['targetTable'] . '/' . $multiImage ?>-1.webp" class="img-fluid mb-2 border border-2 border-info p-1" alt="Предпросмотр">
                        <div class="btn btn-outline-primary btn-sm w-100 btn-confirm" data-id="<?= $mk ?>" data-table="<?= $this->data['configEdit']['fields'][$key]['targetTable'] ?>" data-title="Подтвердите операцию" data-mode="1"><span class="icon-minus-circled"></span> Удалить</div>
                    </div>
                <?php }
                /* <div class="btn btn-outline-primary btn-sm mx-2 px-2"><span class="icon-pencil"></span></div><div class="btn btn-outline-primary btn-sm mx-2 px-2"><span class="icon-cancel"></span></div> */
                ?>
                </div>
                <input class="form-control" id="<?= $key ?>" name="<?= $key ?>[]" type="file" accept=".png, .jpg, .jpeg, .webp">
                <div class="btn btn-outline-primary btn-sm px-2 my-3 addMoreFiles" data-id="<?= $key ?>"><span class="icon-plus-circled"></span> Добавить еще</div>
                <?php
                break;
            default:
                if (!isset($field['type']))
                    $field['type'] = 'text';
                elseif ($field['type'] == 'date' && $value == '')
                    $value = date('Y-m-d');
                elseif ($field['type'] == 'datetime-local' && $value == '')
                    $value = date('Y-m-d H:i');
                ?>
                <input class="form-control <?= $field['translit'] && $this->data['dataRow'][$field['translit']] == '' ? 'doTranslit' : '' ?>" id="<?= $key ?>" name="<?= $key ?>" value="<?= $value ?>" type="<?= $field['type'] ?>" <?= $field['required'] ? 'required' : '' ?> <?= $field['pattern'] ? 'pattern="' . $field['pattern'] . '"' : '' ?> <?= $field['translit'] ? 'data-target="' . $field['translit'] . '"' : ''?> <?= $value && $field['disabled'] ? 'disabled' : '' ?>>
        <?php } ?>
    </div>
<?php } ?>
    <button class="btn btn-lg btn-primary mt-4" type="submit">Сохранить</button>
</form>
