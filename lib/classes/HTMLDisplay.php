<?php

class HTMLDisplay extends Display
{
    var $module;

    var $act;

    public $no_template = false;

    public $param = NULL;

    public $output = NULL;

    public function init($module = null, $act = null)
    {
        $base_app = new BaseApp();

        if (($module && !$act) ||
            ($module && $act))
        {
            $class = $base_app->loadView($module);

            if ($class)
            {
                $default_view = $class->default_view;
                $method = $act ? $act : $default_view;
                
                if (!method_exists($class, $method)) {
                    $method = $default_view;
                }
            }
            else
            {
                $output = new CreateError(404, 'class_not_found');
            }
        }
        else
        {
            $module = DEFAULT_CLASS;
            $class = $base_app->loadView($module);
            $method = DEFAULT_HOME;
        }
        
        if (isset($method))
        {
            $this->module = $module;
            $this->method = $method;
            
            $output = $class->$method($this->param);
        }

        $this->output = $output;
        return;
    }
}

?>
