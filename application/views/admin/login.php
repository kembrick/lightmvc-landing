<div class="d-flex flex-column min-vh-100 min-vw-100">
    <div class="d-flex flex-grow-1 justify-content-center align-items-center">
        <form method="post">
            <div class="shadow p-5 rounded-2 bg-primary">
                <div class="mb-3">
                    <label for="login" class="col-sm-2 col-form-label">Пользователь</label>
                    <input type="text" class="form-control" id="login" name="login" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Пароль</label>
                    <input type="password" class="form-control" id="password" name="password" required maxlength="100">
                </div>
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" id="checkRemember" name="remember">
                    <label class="form-check-label" for="checkRemember">Запомнить меня</label>
                </div>
                <button class="btn w-100 btn-primary btn-lg mt-4" type="submit" <?= $this->locked ? 'disabled' : '' ?>>Отправить</button>
            </div>
        </form>
    </div>
</div>
<?php if ($this->error) { ?><div class="alert alert-danger text-center m-5 fixed-bottom"><?= $this->error ?></div><?php } ?>
<style>
.bg-primary { background-color: #afc4ce !important; }
.btn-primary { background-color: #4d91b1 !important; }
.btn-primary, .btn-primary:hover, .btn-primary:focus, .btn-primary:active { border-color: transparent !important; }
.btn-primary:hover { background-color: #116e9a !important; }
.form-check-input:checked {
    background-color: #116e9a;
    border-color: #4d91b1;
}
</style>