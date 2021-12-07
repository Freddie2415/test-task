<div class="album py-5 bg-light">
    <div class="container">
        <form method="post">
            <legend>Авторизация</legend>
            <div class="mb-3">
                <label for="login" class="form-label">Логин</label>
                <input type="text" value="<?= $_SESSION['FLASH_MESSAGE']['login'] ?? '' ?>"
                       id="login" name="login"
                       class="form-control"
                       placeholder="admin">
                <?php if (isset($_SESSION['FLASH_MESSAGE']['loginError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['loginError'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input value="<?= $_SESSION['FLASH_MESSAGE']['password'] ?? '' ?>" type="text" id="name" name="password"
                       class="form-control"
                       placeholder="123">
                <?php if (isset($_SESSION['FLASH_MESSAGE']['passwordError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['passwordError'] ?></div>
                <?php endif; ?>
            </div>
            <?php if (isset($_SESSION['FLASH_MESSAGE']['successMessage'])): ?>
                <div class="alert alert-success" role="alert">
                    <?= $_SESSION['FLASH_MESSAGE']['successMessage'] ?? '' ?>
                </div>
            <?php endif ?>
            <?php if (isset($_SESSION['FLASH_MESSAGE']['errorMessage'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_SESSION['FLASH_MESSAGE']['errorMessage'] ?? '' ?>
                </div>
            <?php endif ?>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</div>