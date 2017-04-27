<?php
require_once "gol.php";

class GolTest extends PHPUnit_Framework_TestCase
{
    public function testWhenNoLivingCellsAfterOneInterationStillNoLivingCells()
    {
        $gol = new Gol( array() );
        $this->assertEquals( array(), $gol->iterate() );
    }

    public function testWhenCellHasNoNeighboursItDies()
    {
        $seed = array( new Cell(1,1) );

        $gol = new Gol( $seed );

        $this->assertEquals( array(), $gol->iterate() );
    }

    public function testWhenCellhasOneNeighbourItDies()
    {
        $seed = array( new Cell(3,2), new Cell(4,2) );

        $gol = new Gol( $seed );

        $this->assertEquals( array(), $gol->iterate() ); 
    }

    public function testWhenACellHasTwoNeighboursItLives()
    {
        $seed = array( new Cell(1,1), new Cell(1,2), new Cell(1,3) );

        $gol = new Gol( $seed );

        $this->assertTrue( in_array(new Cell(1,2), $gol->iterate() ));
    }

    public function testWhenACellHasThreeNeighboursItLives()
    {
        $seed = array( new Cell(1,1), new Cell(1,2), new Cell(1,3), new Cell(2,2) );

        $gol = new Gol( $seed );

        $this->assertTrue( in_array( new Cell(1,2), $gol->iterate() ));
    }

    public function testWhenCellHasMoreThanThreeNeighboursItDies()
    {
        $seed = array( new Cell(1,1), new Cell(1,2), new Cell(1,3), new Cell(2,2), new Cell(2,1) );

        $gol = new Gol( $seed );

        $this->assertFalse( in_array( new Cell(1,2), $gol->iterate() ));
    }

    public function testWhenCellHasExactlyThreeNeighboursItComesToLife()
    {

        $seed = array( new Cell(1,3), new Cell(2,2), new Cell(2,4) );

        $gol = new Gol( $seed );

        $iterate = $gol->iterate();

        $this->assertTrue( in_array( new Cell(2,3), $iterate ));
    }



}
