<?php
/*
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By: Thach The Dang.
 *
 */

declare(strict_types=1);
namespace Magenest\EavTest\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddAvatarCustomer implements DataPatchInterface
{
    private $moduleDataSetup;
    private $customerSetupFactory;
    private $eavConfig;
    private $attributeResource;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeResource $attributeResource
     * @param Config $eavConfig
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeResource $attributeResource,
        Config $eavConfig,
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        // $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
//        $attributeSetId = $customerSetup->getDefaultAttributeSetId($customerEntity->getEntityTypeId());
//        $attributeGroupId = $customerSetup->getDefaultAttributeGroupId($customerEntity->getEntityTypeId(),$attributeSetId);

        // Add the attribute
        $customerSetup->addAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            'avatar',
            [
                'label' => 'Avatar',
                'input' => 'image',
                'type' => 'varchar',
                'backend' => '',
                'user_defined' => true,
                'required' => false,
                'position' => 333,
                'visible' => true,
                'system' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
            ]
        );
        // Add attribute to default attribute set and group
        $customerSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            'avatar'
        );
        // Get the newly created attribute's model
        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, 'avatar');

        // Make attribute visible in Admin customer form
        $attribute->setData('used_in_forms', [
            'adminhtml_customer', 'customer_account_edit', 'customer_account'
        ]);
        // Save attribute using its resource model
        $this->attributeResource->save($attribute);
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
