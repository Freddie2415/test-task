<?php

namespace Project\Repositories;

use Core\Model;
use Exception;
use Project\Models\Task;

class TaskCrudRepository extends Repository implements ICrudRepository
{
    public function getPaginated(): array
    {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = (int)($_GET['per_page'] ?? 3);
        $skip = ($page - 1) * $perPage;
        $column = $_GET['column'] ?? 'id';
        if (!in_array($column, ['id', 'name', 'email', 'description', 'status'])) {
            $column = 'id';
        }

        $direction = strtolower($_GET['direction'] ?? 'desc');
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'asc';
        }

        $query = "SELECT COUNT(*) FROM tasks";
        $rs_result = mysqli_query(self::$mysqliConnect, $query);
        $row = mysqli_fetch_row($rs_result);
        $total = $row[0] ?? 0;
        $links = [];

        for ($i = 1; $i <= ceil($total / $perPage); $i++) {
            $links[] = $page === $i ? "#" : "?page=$i&column=$column&direction=$direction";
        }

        $query = "SELECT id, name, email, description, status, edited FROM tasks ORDER BY `$column` $direction LiMIT $skip, $perPage";
        $result = mysqli_query(self::$mysqliConnect, $query) or die(mysqli_error(self::$mysqliConnect));

        for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) ;

        $tasks = [];
        foreach ($data as $item) {
            $tasks[] = new Task($item['id'], $item['name'], $item['email'], $item['description'], $item['status'], (bool)$item['edited']);
        }

        return [
            'data' => $tasks,
            'meta' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'links' => $links
            ]
        ];
    }


    /**
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function create(array $attributes): bool
    {
        $query = "INSERT INTO tasks (name, email, description) VALUES ('{$attributes['name']}', '{$attributes['email']}', '{$attributes['description']}')";

        return $this->execute($query);
    }


    /**
     * @param $id
     * @return Task
     * @throws Exception
     */
    public function findOne($id): Task
    {
        $query = "SELECT id, name, email, description, status, edited FROM tasks WHERE `id` = $id";

        $result = mysqli_query(self::$mysqliConnect, $query) or die(mysqli_error(self::$mysqliConnect));
        $item = mysqli_fetch_assoc($result);

        if ($item == null) {
            throw new Exception('Задача не найдена!', 404);
        }

        return new Task($item['id'], $item['name'], $item['email'], $item['description'], $item['status'], (bool)$item['edited']);
    }

    /**
     * @param Task $model
     * @param array $attributes
     * @return bool
     * @throws Exception
     */
    public function update(Model $model, array $attributes): bool
    {
        $status = $attributes['status'] == true ? 'true' : 'false';

        if ($attributes['description'] !== $model->getDescription()) {
            $query = "UPDATE tasks SET name='{$attributes['name']}', email='{$attributes['email']}', description='{$attributes['description']}', status=$status, edited=true WHERE id = {$model->getId()}";
        } else {
            $query = "UPDATE tasks SET name='{$attributes['name']}', email='{$attributes['email']}', description='{$attributes['description']}', status=$status WHERE id = {$model->getId()}";
        }

        return $this->execute($query);
    }

    /**
     * @param Task $model
     * @return bool
     * @throws Exception
     */
    public function delete(Model $model): bool
    {
        $query = "DELETE FROM tasks where id = {$model->getId()}";

        return $this->execute($query);
    }
}