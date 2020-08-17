<?php

class JSONDisplay extends Display
{
    var $module;

    var $act;

    public $no_template = true;

    public $param = NULL;

    public $output = NULL;

    public function __construct($module = null, $act = null)
    {
        $base_app = new BaseApp();

        if ($module && $act)
        {
            $class = $base_app->loadController($module);

            if ($class)
            {
                $method = $act;

                if (!method_exists($class, $method)) {
                    $output = new CreateError(404, 'method_not_found');
                }
                else
                {
                    $output = $class->$method($this->param);
                }
            }
            else
            {
                $output = new CreateError(404, 'class_not_found');
            }

            $this->output = $output;
        }
        return;
    }
}

?>
