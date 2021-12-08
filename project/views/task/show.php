<div class="album py-5 bg-light">
    <div class="container">
        <form method="post" action="<?= \Core\Route::generateUrl("tasks/{$task->getId()}/update/") ?>">
            <legend>Изменение задачи...</legend>
            <div class="mb-3">
                <label for="id" class="form-label">#ID</label>
                <input type="text" value="<?= $task->getId() ?>" id="id" name="id" class="form-control" disabled>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" value="<?= $_SESSION['FLASH_MESSAGE']['name'] ?? $task->getName() ?>" id="name"
                       name="name"
                       class="form-control"
                       placeholder="Введите имя">
                <?php if (isset($_SESSION['FLASH_MESSAGE']['nameError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['nameError'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input value="<?= $_SESSION['FLASH_MESSAGE']['email'] ?? $task->getEmail() ?>" type="text" id="email"
                       name="email"
                       class="form-control"
                       placeholder="Введите Email">
                <?php if (isset($_SESSION['FLASH_MESSAGE']['emailError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['emailError'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание задачи</label>
                <textarea name="description" class="form-control" placeholder="Введите описание задачи" id="description"
                          rows="3"><?= $_SESSION['FLASH_MESSAGE']['description'] ?? $task->getDescription() ?></textarea>
                <?php if (isset($_SESSION['FLASH_MESSAGE']['descriptionError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['descriptionError'] ?></div>
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
            <div class="mb-3 form-check">
                <input id="status" name="status" class="form-check-input"
                       value="true"
                       type="checkbox" <?= $task->getStatus() ? 'checked' : '' ?> >
                <label class="form-check-label" for="status">
                    Выполнено
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить задачу</button>
        </form>
    </div>
</div>