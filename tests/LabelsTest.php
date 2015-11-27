<?php
namespace Algorithms\Tests;

class LabelsTest extends \PHPUnit_Framework_TestCase
{
    public function testLabel()
    {
        $point = new \Algorithms\GraphTools\Point(1, 'label');
        $this->assertNotEmpty($point);
        $this->assertNotEmpty($point->getID());
        $this->assertNotEmpty($point->getLabel());

        $creator = new \Algorithms\GraphTools\Creator;
        $creator->addPoint($point);
        $creator->addPoint(2);
        $creator->addPoint('another label');

        $this->assertNotEmpty($creator->getPoint('label'));
        $this->assertNotEmpty($creator->getPoint('another label'));

        $id = $creator->getPoint('label')
                      ->getID();
        $this->assertEquals($creator->getPoint($id)
                                    ->getLabel(),
                            'label');
        $this->assertEmpty($creator->getPoint(2)
                                   ->getLabel());
    }
}
