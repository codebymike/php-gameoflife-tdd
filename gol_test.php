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

    public function testWhenCellsAreSpacedApart()
    {
        $seed = array(
            new Cell(3,2),
            new Cell(2,2),
            new Cell(2,3),

            new Cell(6,2),
            new Cell(5,2),
            new Cell(5,3),
        );

        $expected = array(
            new Cell(2,2),
            new Cell(2,3),
            new Cell(3,2),
            new Cell(3,3),
            new Cell(4,2),
            new Cell(4,3),
            new Cell(5,2),
            new Cell(5,3),
            new Cell(6,2),
            new Cell(6,3),
        );

        $gol = new Gol( $seed );

        $iterate = $gol->iterate();

        $this->assertTrue( $this->arrays_are_similar($expected, $iterate) );
    }

    public function testWhenThereAreTwoIterations()
    {
        $seed = array(
            new Cell(3,2),
            new Cell(2,2),
            new Cell(2,3),

            new Cell(6,2),
            new Cell(5,2),
            new Cell(5,3),
        );

        $expected = array(
            new Cell(2,2),
            new Cell(2,3),
            new Cell(3,1),
            new Cell(3,4),
            new Cell(4,1),
            new Cell(4,4),
            new Cell(5,1),
            new Cell(5,4),
            new Cell(6,2),
            new Cell(6,3),
        );

        $gol = new Gol( $seed );

        $iterate1 = $gol->iterate();
        $iterate2 = $gol->iterate();

        $this->assertTrue( $this->arrays_are_similar($expected, $iterate2) );
    }

    public function testWhenThereAreThreeIterations()
    {
        $seed = array(
            new Cell(3,2),
            new Cell(2,2),
            new Cell(2,3),

            new Cell(6,2),
            new Cell(5,2),
            new Cell(5,3),
        );

        $expected = array(
            new Cell(2,2),
            new Cell(2,3),
            new Cell(3,1),
            new Cell(3,4),
            new Cell(4,0),
            new Cell(4,1),
            new Cell(4,2),
            new Cell(4,3),
            new Cell(4,4),
            new Cell(4,5),
            new Cell(5,1),
            new Cell(5,4),
            new Cell(6,2),
            new Cell(6,3),
        );

        $gol = new Gol( $seed );

        $iterate1 = $gol->iterate();
        $iterate2 = $gol->iterate();
        $iterate3 = $gol->iterate();

        $this->assertTrue( $this->arrays_are_similar($expected, $iterate3) );
    }

    private function arrays_are_similar($a, $b)
    {
        // if the indexes don't match, return immediately
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        // we know that the indexes, but maybe not values, match.
        // compare the values between the two arrays
        foreach($a as $foo) 
        {
            if( !in_array($foo, $b) )
            {
                return false;
            }
        }

        // we have identical indexes, and no unequal values
        return true;
    }

}
