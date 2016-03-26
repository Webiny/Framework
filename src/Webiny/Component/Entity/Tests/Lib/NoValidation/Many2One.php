<?php
namespace Webiny\Component\Entity\Tests\lib\NoValidation;

use Webiny\Component\Entity\EntityAbstract;
use Webiny\Component\Entity\Tests\Lib\Classes;

class Many2One extends EntityAbstract
{
    protected static $entityCollection = "NoValidation_Many2One";

    protected function entityStructure()
    {
        $this->attr('char')->char()->setToArrayDefault();
        $this->attr('relations')->one2many('many2oneNew')->setEntity(Classes::ENTITY_NO_VALIDATION);
    }
}