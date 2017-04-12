<?php

class Gol
{
    private $seed;

    public function __construct( $seed )
    {
        $this->seed = $seed;
    }

    public function iterate()
    {
        $living_cells = array();
        $neighbour_cells = array();

        foreach( $this->seed as $cell )
        {
            $neighbour_count = 0;
            $neighbour_cells = array_merge($neighbour_cells, $this->getCellNeighbours( $cell ));

            foreach( $this->seed as $neighbour )
            {
                if( $neighbour->getX() >= $cell->getX() - 1 && 
                    $neighbour->getX() <= $cell->getX() + 1 &&
                    $neighbour->getY() >= $cell->getY() - 1 && 
                    $neighbour->getY() <= $cell->getY() + 1 &&
                    $neighbour !== $cell
                ){
                    $neighbour_count++;
                }  
            }

            if( $neighbour_count === 2 || $neighbour_count === 3  )
            {
                $living_cells[] = $cell;
            }
        }

        //enliven cells with 3 neighbours
        foreach( $this->countCellOccurances( $neighbour_cells ) as $cell_key => $cell_count )
        {
            if( $cell_count == 3 )
            {
                list( $new_cell_x, $new_cell_y ) = explode("_", $cell_key);
                $living_cells[] = new Cell( $new_cell_x, $new_cell_y );
            }
        }

        return $living_cells;
    }

    private function countCellOccurances( Array $cells )
    {   
        $cell_counts = array();

        foreach( $cells as $cell )
        {
            // $cell_as_key = print_r($cell, true); // Doesn't work?
            $cell_as_key = $cell->getX() . "_" . $cell->getY() ;
            $cell_counts[ $cell_as_key ]++;
        }

        return $cell_counts;
    }

    private function getCellNeighbours( Cell $cell )
    {   
        $neighbours = array();

        $cell_x = $cell->getX();
        $cell_y = $cell->getY();

        array_push($neighbours, 
            new Cell( $cell_x - 1, $cell_y - 1 ),  // top left
            new Cell( $cell_x, $cell_y - 1 ),      // top
            new Cell( $cell_x + 1, $cell_y - 1 ),  // top right

            new Cell( $cell_x - 1, $cell_y ),      // left
            new Cell( $cell_x + 1, $cell_y ),      // right

            new Cell( $cell_x - 1, $cell_y + 1 ),  // bottom left
            new Cell( $cell_x, $cell_y + 1 ),      // bottom
            new Cell( $cell_x + 1, $cell_y + 1 )  // bottom right
        );

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
        return $this->x . "_" . $this->y;
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