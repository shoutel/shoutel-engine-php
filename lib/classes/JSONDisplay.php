<?php

class JSONDisplay extends Display
{
    var $module;

    var $act;

    public $no_template = true;

    public $param = NULL;

    public $output = NULL;

    public function init($module = null, $act = null)
    {
        $base_app = new BaseApp();

        if (($module && !$act) ||
            ($module && $act))
        {
            $class = $base_app->loadController($module);

            if ($class)
            {
				$default_view = '_jsonApiIndex';
                $method = $act ? $act : null;

                if (!$method) {
                    $method = $default_view;
				}

				$obj = new stdClass();
				$obj->module = $module;
				$obj->method = $method;

				if (!$this->getDisplayApiPermission($obj))
				{
					$output = new CreateMsg(403, 'forbidden');
				}
				else
				{
					if (!method_exists($class, $method)) {
						$output = new CreateMsg(404, 'method_not_found');
					}
					else
					{
						$output = $class->$method($this->param);
					}
				}
            }
            else
            {
                $output = new CreateMsg(404, 'class_not_found');
            }

            $this->output = $output;
        }
        return;
    }
}

?>
