<?php
/**
 * REST server for ferry schedule operations.
 * This one manages ports.
 *
 * ------------------------------------------------------------------------
 */
require APPPATH . '/third_party/restful/libraries/Rest_controller.php';

/**
 * Class Job
 *
 * @property Tasks tasks
 */
class Job extends Rest_Controller {



    function __construct()
    {
        parent::__construct();
        //$this->load->model('Tasks'); // Already loaded in autoload
    }
    // Handle an incoming GET ... 	returns a list of ports
    function index_get($key=null)
    {

        Logger::log("index_get($key):");
        Logger::log($_GET);

        if(!$key) {
            $this->response($this->tasks->all(), 200);
        }
        else {
            $result = $this->tasks->get($key);
            if ($result != null)
                $this->response($result, 200);
            else
                $this->response(array('error' => 'Todo item not found!'), 404);
        }

    }

    // Handle an incoming PUT - update a todo item
    function index_put($key=null)
    {
        Logger::log("index_put($key):");

        $arr = $this->_put_args;

        Logger::log($arr);


        //var_dump($arr);

        if(empty($arr)) {
            throw new Exception("index_put: no put arguments!");
        }

//        echo "index_put arguments:\n\n<br>\n\n";
//        print_r($arr);

        $record = array_merge(array('id' => $key), $arr);
        $this->tasks->update($record);
        $this->response(array('ok'), 200);
    }

    // Handle an incoming POST - add a new todo item
    function index_post($key=null)
    {

        Logger::log("index_post($key):");
        Logger::log($_POST);


        $record = array_merge(array('id' => $key), $_POST);
        $this->tasks->add($record);
        $this->response(array('ok'), 200);
    }

// Handle an incoming DELETE - cruD
    function index_delete($key=null)
    {
        Logger::log("index_delete($key):");

        $this->tasks->delete($key);
        $this->response(array('ok'), 200);
    }

}