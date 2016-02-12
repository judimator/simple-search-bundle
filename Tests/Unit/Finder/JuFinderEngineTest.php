<?php

namespace Ju\SimpleSearchBundle\Tests\Unit\Finder;

use Ju\SimpleSearchBundle\Engine\EngineCollection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JuFinderEngineTest extends WebTestCase
{

    public function testEngineCollection()
    {
        $collection = new EngineCollection();
        $mock1 = $this->getMockForAbstractClass('\\Ju\\SimpleSearchBundle\\Engine\\SearchEngineInterface');
        $collection->add('ju_test1', $mock1);
        $mock2 = $this->getMockForAbstractClass('\\Ju\\SimpleSearchBundle\\Engine\\SearchEngineInterface');
        $collection->add('ju_test2', $mock2);

        $this->assertSame($mock1, $collection->get('ju_test1'));

        $collection->setDefault('ju_test2');

        $this->assertSame($mock2, $collection->get());
    }

}
