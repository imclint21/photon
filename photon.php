<?php
/**
 * Photo PHP Framework 1.0
 * Photon is a Lightweight PHP Framework 💡
 * 
 * @author Clint.Network
 * @link https://github.com/clintnetwork/photon
 * @version 1.0
 */
class Photon
{
    private $routes = [];
    private $development_mode = false;

    public function __construct($development_mode = false)
    {
        $this->development_mode = $development_mode;
    }

    /**
     * Initialize the framework
     */
    public function illuminate()
    {
        $controller_files = scandir(__DIR__ . "/controllers");

        foreach($controller_files as $controller)
        {
            if(StringManipulation::endsWith($controller, ".php"))
            {
                include __DIR__ . "/controllers/$controller";
                $controller_name = pathinfo(strtolower($controller), PATHINFO_FILENAME);
                $controller_class = pathinfo(ucfirst($controller), PATHINFO_FILENAME);
                foreach(get_class_methods($controller_class) as $action_name)
                {
                    // TODO: fix problem with project subfolder
                    $this->routes["/$controller_name/$action_name"] = array("Controller" => $controller_class, "Action" => $action_name);

                    $rc = new ReflectionMethod($controller_class, $action_name);
                    if (preg_match_all('/@(\w+)\s+(.*)\r?\n/m', $rc->getDocComment(), $matches))
                    {
                        $result = array_combine($matches[1], $matches[2]);
                        if(isset($result["route"]))
                        {
                            $this->routes[trim($result["route"])] = array("Controller" => $controller_class, "Action" => $action_name);
                            unset($this->routes["/$controller_name/$action_name"]);
                        }
                    }
                }
            }
        }

        if($this->development_mode)
        {
            Photon::inject_debug();
        }

        $has_output = false;
        foreach(array_keys($this->routes) as $route)
        {
            if($route == $_SERVER["REQUEST_URI"])
            {
                $controller_class = $this->routes[$route]["Controller"];
                $action_name = $this->routes[$route]["Action"];

                // Execute action from the controller
                $tmp_class = new $controller_class();
                $tmp_class->$action_name();

                $has_output = true;
            }
        }

        if(!$has_output && !$this->development_mode)
        {
            header('HTTP/1.1 404 Not Found');
        }
    }

    public static function path_builder()
    {
    }

    public static function inject_debug()
    {
        echo <<<HTML
<div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', Helvetica, Arial, sans-serif; position: fixed; bottom: 0; right: 0; padding: 10px; color: #333333;">
    Photon Framework | <span style="color: #0e5a90;">Development Mode</span>
</div>
HTML;
    }

    public static function debug($what)
    {
        echo "<pre>";
        print_r($what);
        echo "</pre>";
    }

    public static function get_caller($index = 1)
    {
        return debug_backtrace()[$index];
    }
}

class StringManipulation
{
    public static function startsWith($haystack, $needle)
    {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }
    
    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
    
        return (substr($haystack, -$length) === $needle);
    }
}

function view()
{
    $get_caller = Photon::get_caller(2);
    include __DIR__ . "/views/" . strtolower($get_caller["class"]) . "/" . $get_caller["function"] . ".php";
}
?>