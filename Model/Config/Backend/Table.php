<?php
/**
 * IDEALIAGroup srl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@idealiagroup.com so we can send you a copy immediately.
 *
 * @category   MSP
 * @package    MSP_CashOnDelivery
 * @copyright  Copyright (c) 2016 IDEALIAGroup srl (http://www.idealiagroup.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MSP\CashOnDelivery\Model\Config\Backend;


class Table extends \Magento\Config\Model\Config\Backend\File
{
    /**
     * @var \MSP\CashOnDelivery\Api\CashondeliveryTableInterface
     */
    protected $cashondeliveryTableInterface;

    const UPLOAD_DIR = '/msp/';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory
     * @param \Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface $requestData
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @para \MSP\CashOnDelivery\Api\CashondeliveryTableInterface $cashondeliveryTableInterface
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Config\Model\Config\Backend\File\RequestData\RequestDataInterface $requestData,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \MSP\CashOnDelivery\Api\CashondeliveryTableInterface $cashondeliveryTableInterface,
        array $data = []


    ) {
        $this->cashondeliveryTableInterface = $cashondeliveryTableInterface;
        parent::__construct($context, $registry, $config, $cacheTypeList,$uploaderFactory, $requestData, $filesystem, $resource, $resourceCollection, $data);

    }

    public function beforeSave()
    {
        $result = parent::beforeSave();

        if(!empty($result->getData('value'))){
            $this->cashondeliveryTableInterface->saveFromFile($result->getData('value'));
        }

        return $result;
    }

    /**
     * Getter for allowed extensions of uploaded files
     *
     * @return array
     */
    protected function _getAllowedExtensions()
    {
        return ['csv'];
    }
}
