<?php 

namespace Classes;

class Car{
    protected $id;
    protected $name;
    protected $category;
    protected $price;
    protected $availability;

    public function __construct($id,$name,$category,$price,$availability){
        $this->id           = $id;
        $this->name         = $name;
        $this->category     = $category;
        $this->price        = $price;
        $this->availability = $availability;
    }

    public function create_car($pdo,$name,$category,$price,$availability){
        
    }
}