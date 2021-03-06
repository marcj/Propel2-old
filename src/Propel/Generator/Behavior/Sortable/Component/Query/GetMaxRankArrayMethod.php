<?php

namespace Propel\Generator\Behavior\Sortable\Component\Query;

use gossi\codegen\model\PhpParameter;
use Propel\Generator\Behavior\Sortable\SortableBehavior;
use Propel\Generator\Builder\Om\Component\BuildComponent;
use Propel\Generator\Builder\Om\Component\NamingTrait;

/**
 *
 * @author Marc J. Schmidt <marc@marcjschmidt.de>
 */
class GetMaxRankArrayMethod extends BuildComponent
{
    use NamingTrait;

    public function process()
    {
        /** @var SortableBehavior $behavior */
        $behavior = $this->getBehavior();
        $useScope = $behavior->useScope();

        $body = "
\$this->addSelectColumn('MAX(' . {$this->getEntityMapClassName()}::RANK_COL . ')');";
        if ($useScope) {
            $body .= "
\$this->filterByNormalizedListScope(\$scope);";
        }

        $body .= "
\$dataFetcher = \$this->doSelect();

return \$dataFetcher->fetchColumn();
";
        $methodSignature = [];
        if ($useScope) {
            $methodSignature[] = PhpParameter::create('scope')->setType('array');
        }

        $this->addMethod('getMaxRankArray')
            ->setParameters($methodSignature)
            ->setDescription("Get the highest rank by a scope with a array format")
            ->setType('integer')
            ->setTypeDescription("Highest position")
            ->setBody($body)
        ;

    }
}