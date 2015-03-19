<?php

namespace Framework\Cura\Controllers;
use Framework\Cura\helpers as helpers;

class TasksController extends ControllerAbstract
{
    public function defaultAction() {
        if (helpers\Session::exists('tasks')) {
            \Framework\Cura\Cura::Notify(helpers\Session::flash('tasks'));
        }
        
        $objects = \Framework\Cura\Models\Task::getAll();

        foreach ($objects as $object) {
           $tasks[] = new \Framework\Cura\Models\Task($object);
        }
        
        foreach ( $tasks as $task) {
            $task->renderWith(function ($data) {
                echo '<p>' .$data['task_name'] .  '</p>';
            });
        }
        new \Framework\Cura\Views\View();
    }
    
    public function CreateNewTaskAction() {
        if (helpers\Input::exists()) {
        $valid = helpers\Validation::check(array(
            'task_name' => array(
                'name' => 'Task Name',
                'required' => true
            ),
            'due' => array(
                'name' => 'Due Date',
                'required' => true
            )
        ));
        
        
        if (empty($valid->errors())) {
                $task = \Framework\Cura\Models\ModelAbstract::getFromPost('Task');
                if ($task->save()) {
                    helpers\Session::flash('tasks', 'Task Saved');
                    helpers\Redirect::to('/tasks');
                }
            } else {
                foreach ($valid->errors() as $error) {
                    \Framework\Cura\Cura::Notify($error);
                }
            }
        }

        new \Framework\Cura\Views\View();
    }
}
