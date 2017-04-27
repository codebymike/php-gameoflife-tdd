<?php

class Gol
{
    private $initial_seed;
    private $iteration_seed;

    public function __construct( $seed )
    {
        $this->seed = $seed;
    }

    public function iterate()
    {
        $this->iteration_seed = $this->seed;
        $living_cells_after_iteration = array();

        //given a list of currently alive cells, get the complete neighbourhood of surrounding cells.
        $living_neighbourhood = $this->calculateCellNeighbourhood();

        foreach( $living_neighbourhood as $potential_living_cell )
        {
            $number_of_living_neighbours = $this->calculateLivingNeighbours( $potential_living_cell );

            if( ( $number_of_living_neighbours == 2 && in_array($potential_living_cell, $this->iteration_seed ) )
                || $number_of_living_neighbours == 3 )
            {
                $living_cells_after_iteration[] = $potential_living_cell;
            }
        }

        return $living_cells_after_iteration;
    }

    private function calculateLivingNeighbours( Cell $center_cell )
    {
        $neighbour_count = 0;

        foreach( $this->iteration_seed as $living_cell )
        {
            if( $center_cell->getX() >= $living_cell->getX() - 1 && 
                $center_cell->getX() <= $living_cell->getX() + 1 &&
                $center_cell->getY() >= $living_cell->getY() - 1 && 
                $center_cell->getY() <= $living_cell->getY() + 1 &&
                $center_cell != $living_cell
            ){
                $neighbour_count++;
            } 
        }

        return $neighbour_count;
    }    

    private function calculateCellNeighbourhood()
    {
        $cell_neighbourhood = array();

        foreach( $this->iteration_seed as $seed_cell )
        {
            $cell_neighbourhood = array_merge($cell_neighbourhood, $this->getCellsNeighbours( $seed_cell ));
        }

        return array_unique($cell_neighbourhood, SORT_REGULAR);
    }

    private function getCellsNeighbours( Cell $cell )
    {   
        $neighbours = array();
        $cell_range = range(-1, 1);
        $cell_x = $cell->getX();
        $cell_y = $cell->getY();

        foreach( $cell_range as $x_range )
        {
            foreach( $cell_range as $y_range )
            {
                $neighbours[] = new Cell( $cell_x + $x_range, $cell_y + $y_range );
            }
        }

        return $neighbours;
    }
}


class Cell
{
    private $x;
    private $y;

    public function __construct( $x, $y )
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function __toString()
    {
        return "({$this->x},{$this->y})";;
    }

    public function getX()
    {
        return $this->x; 
    }

    public function getY()
    {
        return $this->y; 
    }
}

