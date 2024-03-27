<?php if ($_SESSION['msg']) {
    if ($_SESSION['msg']['success']) {
        $msg = '<div class="row"><div class="col-8 align-self-center"><span class="icon-info-circled"></span> Изменения успешно внесены. ';
        $msg .= $_SESSION['msg']['images'] ?: '';
        $msg .= '</div><div class="col-4 text-end"><a class="btn btn-success" href="/' . $this->baseUrl . '/edit/' . $this->section . '/' . $_SESSION['msg']['id'] . '"><span class="icon-pencil"></span> Редактировать</a></div></div>';
    } else  {
        $msg = '<span class="icon-attention"></span> Произошла ошибка. Изменения не внесены.';
    }
    ?>
    <div class="alert alert-<?= $_SESSION['msg']['success'] ? 'success' : 'danger' ?> align-items-center" role="alert">
        <?= $msg ?>
    </div>
<?php
unset($_SESSION['msg']);
} ?>
<table id="datable" class="table table-striped mt-2 mb-5">
    <thead>
        <tr>
            <?php
            foreach ($this->data['config']['view']['fields'] as $fld) {
                echo '<th class="searchable">' . $fld['title'] . '</th>';
            }
            ?>
            <th class="text-end">Действия</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $img_path = '/public/pictures/main/' . $this->data['config']['table'] . '/';
    foreach ($this->data['dataTable'] as $row) { ?>
        <tr id="rec<?= $row['id'] ?>" class="">
            <?php
            $countFld = 0;
            $linkEdit = $rowTitle = '';
            foreach ($this->data['config']['view']['fields'] as $key => $field) {
                if (!$countFld++) {
                    $rowTitle = htmlentities($row[$key]);
                    $linkEdit = '/' . $this->baseUrl . '/edit/' . $this->section . '/' . $row['id'];
                    $row[$key] = '<a href="' . $linkEdit . '">' . $row[$key] . '</a>';
                } ?>
                <td class="<?= $field['type'] == 'number' ? 'text-right' : '' ?>">
                    <?php
                    switch ($field['type']) {
                        case 'checkbox':
                            echo $row[$key] ? '<b>√</b>' : '';
                            break;
                        case 'date':
                            echo date('d.m.Y', strtotime($row[$key]));
                            break;
                        case 'datetime-local':
                            echo date('d.m.Y H:i', strtotime($row[$key]));
                            break;
                        case 'image':
                            if ($row[$key]) {
                            ?>
                                <img src="<?= $img_path . $row[$key] ?>-1.webp" width="100">
                            <?php
                            }
                            break;
                        default:
                            echo $row[$key];
                    } ?>
                </td>
            <?php } ?>
            <td class="text-end no-wrap">
                <a class="btn btn-outline-primary tiny ms-1" href="<?= $linkEdit ?>"><span class="icon-pencil" title="Редактировать"></span></a>
                <?php if (!$this->data['config']['addOnly'] && $row['locked'] != 1) { ?>
                    <div class="btn btn-outline-primary tiny ms-1 btn-confirm" data-id="<?= $row['id'] ?>" data-table="<?= $this->section ?>" data-title="<?= $rowTitle ?>" data-mode="0">
                        <span class="icon-cancel" title="Удалить"></span>
                    </div>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>