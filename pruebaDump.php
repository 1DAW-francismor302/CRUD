<?php

    function dump($var){
        if(is_object($var)){
            $reflect = new ReflectionClass ($var);
            $props = $reflect -> getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty:: IS_PROTECTED);
            $methods = $reflect -> getMethods(ReflectionProperty::IS_PUBLIC | ReflectionProperty:: IS_PROTECTED);
            echo '<pre>';
            echo 'PROPIEDADES: ';
            var_dump($props);
            echo 'MÉTODOS: ';
            var_dump($methods);
            echo '</pre>';

        }else{
            echo '<pre>'.print_r($var,1).'</pre>';
        }
    }

    class Name {
        public $name = "Carmelo";
        protected $edad = 18;
        private $dinero = 3000;

        public function firstMethod() { }
        protected function secondMethod() { }
        private function thirdMethod() { }
    }

    $name = new Name();

    dump($name);
    

?>