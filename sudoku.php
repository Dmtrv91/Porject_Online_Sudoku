<?php

class sudoku{
    public $matrix;
    public $changed;
    public function __construct() {
        $this->matrix = array_fill(0, 4, array_fill(0, 4, 0));
        $this->changed = false;
    }
    
    public function print(){
        for ($row = 0; $row < 4; $row++) {
            for ($column = 0; $column < 4; $column++) {
                if (rand(0, 1) == 1) {
                    echo '<input type="number" class="field" min="1" max="4" name="' . $row . $column . '"value="">';
                } else {
                    echo '<input type="number" readonly="readonly" class="field" min="1" max="4" name="' . $row . $column . '"value="' . $this->matrix[$row][$column] . '">';
                }
            }
            echo '<br>';
        }
    }
    
    public function init(){
        $this->matrix = array_fill(0, 4, array_fill(0, 4, 0));
    }
    
    public function generate(){
        $this->fillDiagonal();
        $this->placeOne();
        $tries = 1;
        
        while(true){
            $this->changed = false;
            $this->placeCandidates();
            $this->placeZeroes();

            if($this->changed == false){
                break;
            }
            $tries++;
            
            if($tries >= 5){
                $tries->init();
                $tries->fillDiagonal();
                $this->placeOne();
                $tries = 0;
            }
        }
    }
    
    function fillDiagonal(){
        $nums = [1, 2, 3, 4];
        
        for($row = 0, $col = 0; $row < 4; $row++, $col++){
            $arg2 = count($nums) - 1;
            $index = rand(0, $arg2);
            $num = $nums[$index];
            $this->matrix[$row][$col] = $num;
            array_splice($nums, $index, 1);
        }
    }
    
    function placeOne(){
        $nums = [1, 2, 3, 4];
        
        while(true){
            $index = rand(0, count($nums) - 1);
            $num = $nums[$index];

            if($this->checkVertical($num,0, 1) && $this->checkHorizontal($num, 0, 0)){
                $this->matrix[0][1] = $num;
                break;
            }else{
                array_splice($nums, $index, 1);
            }
        }
    }
    
    function checkHorizontal($num, $row, $col){
        for($c = 0; $c < 4; $c++){
            if($c == $col){
                continue;
            }
            if($this->matrix[$row][$c] == $num){
                return false;
            }
        }
        return true;
    }
    
    function checkVertical($num, $row, $col){
        for($r = 0; $r < 4; $r++){
            if($r == $row){
                continue;
            }
            if($this->matrix[$r][$col] == $num){
                return false;
            }
        }
        return true;
    }
    
    function placeCandidates(){
        $nums = [1, 2, 3, 4];

        for($row = 0; $row < 4; $row++){
            for($col = 0; $col < 4; $col++){
                if($this->matrix[$row][$col] === 0){
                    $this->matrix[$row][$col] = ' ';

                    foreach($nums as $num){
                        if($this->checkVertical($num, $row, $col) && $this->checkHorizontal($num, $row, $col)){
                            $this->matrix[$row][$col] .= ' ' . $num;
                            $this->matrix[$row][$col] = trim($this->matrix[$row][$col]);
                            $this->changed = true;
                        }
                    }
                }
            }
        }
    }
    
    function placeZeroes(){
        for($row = 0; $row < 4; $row++){
            for($col = 0; $col < 4; $col++){
                if(!is_numeric($this->matrix[$row][$col])){
                    $this->matrix[$row][$col] = 0;
                    $this->changed = true;
                }
            }
        }
    }

    function checkSolution()
    {
        $data = array_values($_POST);
        $i = 0;
        
        for ($row = 0; $row < 4; $row++) {
            for ($column = 0; $column < 4; $column++) {
                $this->matrix[$row][$column] = $data[$i++];
            }
        }

        for ($row = 0; $row < 4; $row++) {
            for ($column = 0; $column < 4; $column++) {
                $num = $this->matrix[$row][$column];
                if(!$this->checkHorizontal($num, $row, $column)|| !$this->checkVertical($num, $row, $column)|| $num == 0 || $num == ''){
                    $class= 'wrong';
                }
                else{
                    $class = 'right';
                }

                echo '<input class="field '.$class.'" value="' . $num . '">';
            }

            echo '<br>';
        }
    }
}
?>