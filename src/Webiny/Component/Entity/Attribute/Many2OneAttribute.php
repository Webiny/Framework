<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Entity\Attribute;

use Webiny\Component\Entity\Entity;
use Webiny\Component\Entity\Validation\ValidationException;
use Webiny\Component\StdLib\StdLibTrait;


/**
 * Many2One attribute
 * @package Webiny\Component\Entity\AttributeType
 */
class Many2OneAttribute extends AttributeAbstract
{
    use StdLibTrait;

    protected $entityClass = null;

    protected $updateExisting = false;

    /**
     * @var null|\Closure
     */
    protected $setNull = null;

    /**
     * Get masked entity value when instance is being converted to string
     *
     * @return mixed|null|string
     */
    public function __toString()
    {
        if ($this->isNull($this->value) && !$this->isNull($this->defaultValue)) {
            return (string)$this->defaultValue;
        }

        if ($this->isNull($this->value)) {
            return '';
        }

        return $this->getValue()->getMaskedValue();
    }

    /**
     * Get related entity ID
     * @return CharAttribute
     */
    public function getId()
    {
        $value = $this->getValue();
        if ($value) {
            return $value->getId();
        }

        return null;
    }

    /**
     * Allow update of existing entity
     *
     * By default, only new Many2One records are created but updates are not allowed.
     *
     * @param bool|true $flag
     *
     * @return $this
     */
    public function setUpdateExisting($flag = true)
    {
        $this->updateExisting = $flag;

        return $this;
    }

    /**
     * Is update of existing entity allowed?
     * @return bool
     */
    public function getUpdateExisting()
    {
        return $this->updateExisting;
    }

    /**
     * Get value that will be stored to database
     *
     * @return string
     */
    public function getDbValue()
    {
        $value = $this->getValue();
        if ($this->isNull($value)) {
            return $this->processToDbValue(null);
        }

        // If what we got is a defaultValue - create or load an actual entity instance
        if ($value === $this->defaultValue) {
            if ($this->isArray($value) || $this->isArrayObject($value)) {
                $this->value = new $this->entityClass;
                $this->value->populate($value);
            }

            if (Entity::getInstance()->getDatabase()->isMongoId($value)) {
                $this->value = call_user_func_array([
                    $this->entityClass,
                    'findById'
                ], [$value]);
            }
        }

        if ($this->getValue()->id === null || $this->updateExisting) {
            $this->getValue()->save();
        }

        // Return a simple Entity ID string
        return $this->processToDbValue($this->getValue()->id);
    }

    /**
     * Set entity class for this attribute
     *
     * @param string $entityClass
     *
     * @return $this
     */
    public function setEntity($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get entity class for this attribute
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entityClass;
    }

    /**
     * Get attribute value
     *
     * @return bool|null|\Webiny\Component\Entity\EntityAbstract
     */
    public function getValue()
    {
        if (!$this->isInstanceOf($this->value, $this->entityClass) && !empty($this->value)) {
            $data = null;
            if ($this->isArray($this->value) || $this->isArrayObject($this->value)) {
                $data = $this->value;
                $this->value = isset($data['id']) ? $data['id'] : false;
            }

            $this->value = call_user_func_array([
                $this->entityClass,
                'findById'
            ], [$this->value]);

            if ($this->value) {
                $this->value->populate($data);
            } elseif ($data) {
                $this->value = new $this->entityClass;
                $this->value->populate($data);
            }
        }

        if (!$this->value && !$this->isNull($this->defaultValue)) {
            return $this->processGetValue($this->defaultValue);
        }

        return $this->processGetValue($this->value);
    }

    /**
     * Set attribute value
     *
     * @param null $value
     * @param bool $fromDb
     *
     * @return $this
     * @throws \Webiny\Component\Entity\EntityException
     */
    public function setValue($value = null, $fromDb = false)
    {
        if (!$this->canAssign()) {
            return $this;
        }

        $this->validate($value);

        if (is_array($value) && isset($value['id']) && !$fromDb) {
            // Verify that given ID exists
            $exists = call_user_func_array([
                $this->entityClass,
                'findById'
            ], [$value['id']]);

            if (!$exists) {
                unset($value['id']);
            }

            if (!$this->updateExisting && $this->value != null) {
                $value = isset($value['id']) ? $value['id'] : null;
            }
        }

        if(!$fromDb){
            $value = $this->processSetValue($value);
        }

        // Execute setNull callback
        if ($this->setNull && is_null($value) && $this->value) {
            $callable = $this->setNull;
            if ($callable == 'delete') {
                $this->getValue()->delete();
            } else {
                $callable($this->getValue());
            }
        }

        $this->value = $value;

        return $this;
    }

    /**
     * This method allows us to chain getAttribute calls on related entities.
     * Ex: $person->getAttribute('company')->getAttribute('name')->getValue(); // This will output company name
     *
     * @param $name
     *
     * @return AttributeAbstract
     */
    public function getAttribute($name)
    {
        return $this->getValue()->getAttribute($name);
    }

    /**
     * This method allows us to use simplified access to attributes (no autocomplete).
     * Ex: $person->company->name // Will output company name
     *
     * @param $name
     *
     * @return AttributeAbstract
     */
    public function _get($name)
    {
        return $this->getAttribute($name);
    }

    /**
     * Perform validation against given value
     *
     * @param $value
     *
     * @throws ValidationException
     * @return $this
     */
    protected function validate(&$value)
    {
        $mongoId = Entity::getInstance()->getDatabase()->isMongoId($value);
        $abstractEntityClass = '\Webiny\Component\Entity\EntityAbstract';

        if (!$this->isNull($value) && !is_array($value) && !$this->isInstanceOf($value, $abstractEntityClass) && !$mongoId) {
            $this->expected('entity ID, instance of ' . $abstractEntityClass . ' or null', gettype($value));
        }

        return $this;
    }

    public function onSetNull($callable)
    {
        $this->setNull = $callable;

        return $this;
    }
}