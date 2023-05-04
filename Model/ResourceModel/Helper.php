<?php
/**
 * Copyright 2022 Sanjeev Kumar
 * NOTICE OF LICENSE
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category  Sanjeev
 * @package   Sanjeev_ImportExportCms
 * @copyright Copyright (c) 2022
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */


namespace Sanjeev\ImportExportCms\Model\ResourceModel;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\PageInterface;

class Helper extends \Magento\Framework\DB\Helper
{
    /**
    * @var \Magento\Framework\EntityManager\MetadataPool
    */
    protected $metadataPool;

    /**
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     * @param string $modulePrefix
     */
    public function __construct(
    \Magento\Framework\App\ResourceConnection $resource,
    \Magento\Framework\EntityManager\MetadataPool $metadataPool,
    $modulePrefix = 'exportimportcms')
    {
        parent::__construct($resource, $modulePrefix);
        $this->metadataPool = $metadataPool;
    }

    public function getPages(array $pageIds = [], $columns = ['*']): array
    {
        $connection = $this->getConnection();
        $select = $connection->select();
        $cmsPageTable = $this->_resource->getTableName("cms_page");
        $storeTable = $this->_resource->getTableName("cms_page_store");
        $entityMetadata = $this->metadataPool->getMetadata(PageInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select->from(['main' => $cmsPageTable], $columns);
        $select->joinLeft(['store' => $storeTable],'store.'.$linkField.'=main.'.$linkField,['store_id']);

        if(count($pageIds) > 0) {
            $select->where('main.'.$linkField.' IN (?)', $pageIds);
        }
        return $connection->fetchAll($select);
    }

    public function getBlocks(array $blockIds = []): array
    {
        $connection = $this->getConnection();
        $select = $connection->select();
        $cmsBlockTable = $this->_resource->getTableName("cms_block");
        $storeTable = $this->_resource->getTableName("cms_block_store");
        $entityMetadata = $this->metadataPool->getMetadata(BlockInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select->from(['main' => $cmsBlockTable],['*']);
        $select->joinLeft(['store' => $storeTable],'store.'.$linkField.'=main.'.$linkField,['store_id']);

        if(count($blockIds) > 0) {
            $select->where('main.'.$linkField.' IN (?)', $pageIds);
        }
        return $connection->fetchAll($select);
    }

}
