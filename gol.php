<?php

class Gol
{
    private $living_cells;

    public function __construct( $seed )
    {
        $this->living_cells = $seed;
    }

    public function iterate()
    {
        $living_cells_post_iteration = array();

        foreach( $this->calculateCellNeighbourhood() as $potential_living_cell )
        {
            $number_of_living_neighbours = $this->calculateLivingNeighbours( $potential_living_cell );

            if( $this->cellShouldLive( $potential_living_cell, $number_of_living_neighbours ) )
            {
                $living_cells_post_iteration[] = $potential_living_cell;
            }
        }

        $this->living_cells = $living_cells_post_iteration;

        return $this->living_cells;
    }

    private function cellShouldLive( $cell, $living_neighbour_count )
    {
        return $living_neighbour_count == 3 || 
            ( $living_neighbour_count == 2 && in_array($cell, $this->living_cells ) );
    }

    private function calculateLivingNeighbours( Cell $center_cell )
    {
        $neighbour_count = 0;

        foreach( $this->living_cells as $living_cell )
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

        foreach( $this->living_cells as $seed_cell )
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
        return "({$this->x},{$this->y})";
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

