<?php

namespace Propel\Generator\Behavior\Sortable\Component\Repository;

use Propel\Generator\Behavior\Sortable\SortableBehavior;
use Propel\Generator\Builder\Om\Component\BuildComponent;
use Propel\Generator\Builder\Om\Component\NamingTrait;

/**
 *
 * @author Marc J. Schmidt <marc@marcjschmidt.de>
 */
class InsertAtTopMethod extends BuildComponent
{
    use NamingTrait;

    public function process()
    {
        $body = "
\$this->insertAtRank(\$entity, 1);

return \$this;
";

        $this->addMethod('insertAtTop')
            ->addSimpleParameter('entity', 'object')
            ->setDescription('Insert in the first rank. The modifications are not persisted until the object is saved.')
            ->setType('$this|' . $this->getRepositoryClassName())
            ->setBody($body)
        ;

    }
}