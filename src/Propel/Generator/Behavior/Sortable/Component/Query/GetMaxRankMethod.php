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
class GetMaxRankMethod extends BuildComponent
{
    use NamingTrait;

    public function process()
    {
        /** @var SortableBehavior $behavior */
        $behavior = $this->getBehavior();
        $useScope = $behavior->useScope();

        list($methodSignature, $buildScope) = $behavior->generateScopePhp();

        $body = "
\$this->addSelectColumn('MAX(' . {$this->getEntityMapClassName()}::RANK_COL . ')');";
        if ($useScope) {
            $body .= "
$buildScope
\$this->filterByNormalizedListScope(\$scope);";
        }

        $body .= "
\$dataFetcher = \$this->doSelect();

return \$dataFetcher->fetchColumn();
";

        $this->addMethod('getMaxRank')
            ->setParameters($methodSignature)
            ->setDescription("Get the highest rank")
            ->setType('integer')
            ->setTypeDescription("Highest position")
            ->setBody($body)
        ;

    }
}