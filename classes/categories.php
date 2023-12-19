<?php

class categories {
    private $name;
    private $descrt;
    private $img;
    private $isHide;

    public function __construct($name, $descrt, $img, $isHide) {
        $this->name = $name;
        $this->descrt = $descrt;
        $this->img = $img;
        $this->isHide = $isHide;
    }
     
    public function getName()
    {
        return $this->name;
    }
     
    public function getDescrt()
    {
        return $this->descrt;
    }
     
    public function getImg()
    {
        return $this->img;
    }
     
    public function getIsHide()
    {
        return $this->isHide;
    }
}




?>