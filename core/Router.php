<?php

namespace Core;

class Router
{
    /**
     * @param $routes
     * @param $uri
     * @return Track
     */
    public function getTrack($routes, $uri): Track
    {
        foreach ($routes as $route) {
            $pattern = $this->createPattern($route->path);

            /*
                Проверяем адрес URI на соответствие регулярке
                Если URI подойдет под регулярку, в $params будут параметры
            */
            $urlComponents = parse_url($uri);
            $method = $_SERVER['REQUEST_METHOD'];

            if (preg_match($pattern, $urlComponents['path'], $params) && $method === $route->method) {
                $params = $this->clearParams($params);
                return new Track($route->controller, $route->action, $params);
            }
        }

        return new Track('ErrorController', 'notFound');
    }


    /**
     * Метод преобразует путь из роута в регуляку
     * @param $path
     * @return string
     */
    private function createPattern($path): string
    {
        return '#^' . preg_replace('#/:([^/]+)#', '/(?<$1>[^/]+)', $path) . '/?$#';
    }

    /**
     * Очищаем параметры от элементов с числовыми ключами
     * @param $params
     * @return array
     */
    private function clearParams($params): array
    {
        $result = [];

        foreach ($params as $key => $param) {
            if (!is_int($key)) {
                $result[$key] = $param;
            }
        }

        return $result;
    }
}
	
	
