<?php
class App
{
    protected $controller = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        if (!empty($url[0]))
        {
            $candidate = ucfirst($url[0]) . 'Controller';
            if (file_exists(ROOT_PATH . '/app/controllers/' . $candidate . '.php'))
            {
                $this->controller = $candidate;
                unset($url[0]);
            }
            else
            {
                $this->notFound();
                return;
            }
        }

        $this->controller = new $this->controller();
        if (!empty($url[1]))
        {
            if (method_exists($this->controller, $url[1]))
            {
                $this->method = $url[1];
                unset($url[1]);
            }
            else
            {
                $this->notFound();
                return;
            }
        }

        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL(): array
    {
        if (isset($_GET['url']))
        {
            $url = rtrim($_GET['url'], '/');
            return explode('/', filter_var($url, FILTER_SANITIZE_URL));
        }
        return [];
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 Not Found</h1>';
    }
}
