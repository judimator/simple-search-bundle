<?php

namespace Ju\SimpleSearchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ju\SimpleSearchBundle\DependencyInjection\Compiler\CompilerPass;

class JuSimpleSearchBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CompilerPass());
    }
}
