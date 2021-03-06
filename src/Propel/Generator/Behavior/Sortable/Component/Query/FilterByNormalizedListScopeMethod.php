<?php

namespace Propel\Generator\Behavior\Sortable\Component\Query;

use Propel\Generator\Behavior\Sortable\SortableBehavior;
use Propel\Generator\Builder\Om\Component\BuildComponent;
use Propel\Generator\Builder\Om\Component\NamingTrait;
use Propel\Generator\Model\Field;

/**
 *
 * @author Marc J. Schmidt <marc@marcjschmidt.de>
 */
class FilterByNormalizedListScopeMethod extends BuildComponent
{
    use NamingTrait;

    public function process()
    {
        /** @var SortableBehavior $behavior */
        $behavior = $this->getBehavior();

        $body = '';

        if ($behavior->hasMultipleScopes()) {
            foreach ($behavior->getScopes() as $idx => $scope) {
                $body .= "
    \$this->\$method({$this->getEntityMapClassName()}::".Field::CONSTANT_PREFIX.strtoupper($scope).", \$scope[$idx], Criteria::EQUAL);
";
            }
        } else {
            $body .= "
    \$this->\$method({$this->getEntityMapClassName()}::".Field::CONSTANT_PREFIX.strtoupper(current($behavior->getScopes())).", \$scope, Criteria::EQUAL);
";
        }

        $body .= "
return \$this;
";

        $this->addMethod('filterByNormalizedListScope')
            ->addSimpleParameter('scope' , $behavior->hasMultipleScopes() ? 'array' : 'integer|string')
            ->addSimpleParameter('method', 'string', 'add')
            ->setDescription("Filters by a normalized form of \$scope. Primarily internal used.")
            ->setTypeDescription("The current query, for fluid interface")
            ->setType('$this|' . $this->getQueryClassName())
            ->setBody($body)
        ;

    }
}