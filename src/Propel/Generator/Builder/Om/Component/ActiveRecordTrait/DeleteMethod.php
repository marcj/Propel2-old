<?php

namespace Propel\Generator\Builder\Om\Component\ActiveRecordTrait;

use Propel\Generator\Builder\Om\Component\BuildComponent;
use Propel\Generator\Builder\Om\Component\NamingTrait;

/**
 * Adds a the delete method for ActiveRecord interface.
 *
 * @author Marc J. Schmidt <marc@marcjschmidt.de>
 */
class DeleteMethod extends BuildComponent
{
    use NamingTrait;

    public function process()
    {
        $body = "
{$this->getRepositoryAssignment()}
\$repository->remove(\$this);";

        $this->addMethod('delete')
            ->setDescription('Deletes the entity immediately')
            ->setBody($body);
    }

}