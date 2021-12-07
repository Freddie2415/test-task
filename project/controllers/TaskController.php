<?php

namespace Project\Controllers;

use Core\Controller;
use Core\Page;
use Exception;
use Project\Repositories\TaskCrudRepository;

class TaskController extends Controller
{
    /**
     * @var TaskCrudRepository
     */
    private $taskRepository;

    public function __construct()
    {
        parent::__construct();

        $this->taskRepository = new TaskCrudRepository();
    }

    public function index(): Page
    {
        $this->title = "Task List";

        $tasks = $this->taskRepository->getPaginated();

        $page = $_GET['page'] ?? 1;
        $direction = $_GET['direction'] ?? 'desc';
        $direction = $direction === 'desc' ? 'asc' : 'desc';

        $sort = [
            'id' => "/?page=$page&column=id&direction=$direction",
            'name' => "/?page=$page&column=name&direction=$direction",
            'email' => "/?page=$page&column=email&direction=$direction",
            'description' => "/?page=$page&column=description&direction=$direction",
            'status' => "/?page=$page&column=status&direction=$direction",
        ];

        return $this->render('task/index', [
            'tasks' => $tasks,
            'sort' => $sort,
        ]);
    }


    public function store()
    {
        try {
            $validData = $this->validate([
                'name' => ['required'],
                'email' => ['required', 'email'],
                'description' => ['required'],
            ]);

            $this->taskRepository->create($validData);

            $this->sendSuccessMessage("Задача успешно добавлена");
        } catch (Exception $e) {
            $this->sendErrorMessage($e->getMessage());
        }

        $this->redirect('/');
    }

    public function show($params): Page
    {
        try {
            $task = $this->taskRepository->findOne($params['taskId']);

            $this->title = "Задача #" . $task->getId();
        } catch (Exception $e) {
            return $this->render('error/notFound');
        }

        return $this->render('task/show', ['task' => $task]);
    }

    public function update($params)
    {
        $id = $params['taskId'];

        try {

            $task = $this->taskRepository->findOne($params['taskId']);
            $validData = $this->validate([
                'name' => ['required'],
                'email' => ['required', 'email'],
                'description' => ['required'],
                'status' => ['boolean']
            ]);

            if (!$this->hasUser()) {
                throw new Exception("Пожалуйста авторизуйтесь!", 401);
            }

            $this->taskRepository->update($task, $validData);

            $this->sendSuccessMessage("Изменения успешно сохранены!");
        } catch (Exception $e) {
            $this->sendErrorMessage($e->getMessage());
        }


        $this->redirect("/tasks/$id/");
    }

    public function delete($params)
    {
        try {
            if (!$this->hasUser()) {
                throw new Exception("Пожалуйста авторизуйтесь!", 401);
            }

            $task = $this->taskRepository->findOne($params['taskId']);

            $this->taskRepository->delete($task);

            $this->sendSuccessMessage("Задача успешно удалена!");
        } catch (Exception $e) {
            $this->sendErrorMessage($e->getMessage());
        }

        $this->redirect();
    }


}