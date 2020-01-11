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
    private $development = false;

    public function __construct($development = false)
    {
        $this->$development = $development;
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
                    $routes["/$controller_name/$action_name"] = array("Controller" => $controller_class, "Action" => $action_name);
                }
            }
        }

        foreach(array_keys($routes) as $route)
        {
            if($route == $_SERVER["REQUEST_URI"])
            {
                $controller_class = $routes[$route]["Controller"];
                $action_name = $routes[$route]["Action"];

                // Execute action from the controller
                $tmp_class = new $controller_class();
                $tmp_class->$action_name();
            }
        }
    }

    public static function path_builder()
    {
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