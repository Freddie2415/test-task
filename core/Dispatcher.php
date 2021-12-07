<?php

namespace Core;

class Dispatcher
{
    /**
     * @param Track $track
     * @return Page|mixed|void
     */
    public function getPage(Track $track)
    {
        $className = ucfirst($track->controller);
        $fullName = "\\Project\\Controllers\\$className";

        try {
            $controller = new $fullName;

            if (method_exists($controller, $track->action)) {
                $result = $controller->{$track->action}($track->params);

                if ($result) {
                    return $result;
                } else {
                    return new Page('default');
                }
            } else {
                echo "Метод <b>{$track->action}</b> не найден в классе $fullName.";
                die();
            }
        } catch (\Exception $error) {
            echo $error->getMessage();
            die();
        }
    }
}
