<div class="album py-5 bg-light">
    <div class="container">
        <form method="post" action="/">
            <legend>Добавьте задачу...</legend>
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" value="<?= $_SESSION['FLASH_MESSAGE']['name'] ?? '' ?>" id="name" name="name"
                       class="form-control"
                       placeholder="Введите имя">
                <?php if (isset($_SESSION['FLASH_MESSAGE']['nameError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['nameError'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input value="<?= $_SESSION['FLASH_MESSAGE']['email'] ?? '' ?>" type="text" id="email" name="email"
                       class="form-control"
                       placeholder="Введите Email">
                <?php if (isset($_SESSION['FLASH_MESSAGE']['emailError'])): ?>
                    <div><?= $_SESSION['FLASH_MESSAGE']['emailError'] ?></div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание задачи</label>
                <textarea name="description" class="form-control" placeholder="Введите описание задачи" id="description"
                          rows="3"><?= $_SESSION['FLASH_MESSAGE']['description'] ?? '' ?></textarea>
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
            <button type="submit" class="btn btn-primary">Добавить задачу</button>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">
                    <a href="<?= $sort['id'] ?>">#ID</a>
                </th>
                <th scope="col">
                    <a href="<?= $sort['name'] ?>">Имя пользователя</a>
                </th>
                <th scope="col">
                    <a href="<?= $sort['email'] ?>">Email</a>
                </th>
                <th scope="col">
                    <a href="<?= $sort['description'] ?>">Описание</a>
                </th>
                <th scope="col">
                    <a href="<?= $sort['status'] ?>">Статус</a>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tasks['data'] as $task): ?>
                <tr>
                    <th scope="row"><a href="/tasks/<?= $task->getId() ?>/"><?= $task->getId() ?></a></th>
                    <td><?= $task->getName() ?></td>
                    <td><?= $task->getEmail() ?></td>
                    <td><?= $task->getDescription() ?></td>
                    <td><?= $task->getStatusText() ?></td>
                    <?php if (isset($_SESSION['username'])): ?>
                        <td>
                            <form action="/tasks/<?= $task->getId() ?>/delete/" method="POST">
                                <button>Удалить</button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (isset($tasks['meta']['links']) && count($tasks['meta']['links']) > 1): ?>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= count($tasks['meta']['links']); $i++): ?>
                        <li class="page-item <?= $tasks['meta']['page'] == $i ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $tasks['meta']['links'][$i - 1] ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>