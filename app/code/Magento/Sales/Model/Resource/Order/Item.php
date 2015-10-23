<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sales\Model\Resource\Order;

use Magento\Sales\Model\Resource\EntityAbstract as SalesResource;

/**
 * Flat sales order item resource
 */
class Item extends SalesResource
{
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'sales_order_item_resource';

    /**
     * Fields that should be serialized before persistence
     *
     * @var array
     */
    protected $_serializableFields = ['product_options' => [[], []]];

    /**
     * Model initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('sales_order_item', 'item_id');
    }

    /**
     * Perform actions before object save
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Framework\Object $object
     * @return $this
     */
    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        /**@var $object \Magento\Sales\Model\Order\Item */
        if (!$object->getOrderId() && $object->getOrder()) {
            $object->setOrderId($object->getOrder()->getId());
        }
        if ($object->getParentItem()) {
            $object->setParentItemId($object->getParentItem()->getId());
        }

        return parent::_beforeSave($object);
    }
}