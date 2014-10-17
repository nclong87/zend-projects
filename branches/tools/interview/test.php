<?php
class A {
    private $i;
    public function __construct() {
        $this->i = 0;
    }

    public function incr() {
        $this->i++;
    }
    public function getI() {
        return $this->i;
    }
}

function test() {
    $a = new A();
    $a->incr();
}

echo 10 + 07;
die;

function get_sum() {
    global $var;
    $var = 5;
}
$var = 10;
get_sum();
echo $var;


die;
$str = 123;
echo "Value = \$str";
die;


//begin run
$a = new A();
test();
test();
echo 'i='.$a->getI();