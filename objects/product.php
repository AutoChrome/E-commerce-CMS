<?php
class Product{
    var $id;
    var $name;
    var $cost;
    var $description;
    var $quantity;
    var $tags;
    var $type;
    var $section;
    function __construct($id, $name, $cost, $description, $quantity, $tags, $type, $section){
        $this->id  = $id;
        $this->name = $name;
        $this->cost = $cost;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->tags = $tags;
        $this->type = $type;
        $this->section = $section;
    }
    function getID(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getCost(){
        return $this->cost;
    }
    function getDescription(){
        return $this->description;
    }
    function getQuantity(){
        return $this->quantity;
    }
    function getTags(){
        return $this->tags;
    }
    function getTag($id){
        return $this->tags[$id];
    }
    function getType(){
        return $this->type;
    }
    function removeTag($id){
        unset($this->tags[$id]);
        $this->tags = array_values($this->tags);
    }
    function addTag($tag){
        array_push($this->tags, $tag);
    }
    function getSection(){
        return $this->section;
    }
}
?>