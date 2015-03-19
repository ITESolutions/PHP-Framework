<?php

$string = '<p>This is a test. {i}{b}Blah{/b} <!--TEST--> Lorem Ipsum{/i} and some more <!--PLACEHOLDER-->';

$data = array(
    'placeholder' => 'IT FUCKIN WORKS!',
    'test' => 'YES!!!'
    );
$string = str_ireplace(array(
            '{b}',
            '{/b}',
            '{i}',
            '{/i}'
        ), array(
            '<strong>',
            '</strong>',
            '<em>',
            '</em>'
        ), $string);

foreach ($data as $key => $value) {
            $string = str_ireplace('<!--' . strtoupper($key) . '-->', $value, $string);
        }

echo $string;

//preg_match_all($expression, $string, $matches);
//var_dump($matches[1]);
//preg_match_all($ex, $string, $matches);
//var_dump($matches[1]);