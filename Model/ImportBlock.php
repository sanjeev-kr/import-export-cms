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

namespace Sanjeev\ImportExportCms\Model;

use Magento\Cms\Api\Data\BlockInterface;
use Magento\Framework\Exception\LocalizedException;

class ImportBlock
{
    /**
     * @var \Magento\Cms\Model\BlockFactory
     */
    private $blockFactory;

    /**
     * @var Magento\Cms\Model\ResourceModel\Block
     */
    private $blockResource;

    /**
     * @var Magento\Framework\File\Csv
     */
    private  $csvProcessor;

    /**
     * @param \Magento\Framework\File\Csv $csvProcessor
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param \Magento\Cms\Model\ResourceModel\Block $blockResource
     */
    public  function __construct(
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Cms\Model\ResourceModel\Block $blockResource
    ){
        $this->csvProcessor = $csvProcessor;
        $this->blockFactory = $blockFactory;
        $this->blockResource = $blockResource;
    }

    /**
     * @param array $fileData
     * @return false|string
     * @throws LocalizedException
     */
    public  function importBlocks(array $fileData){

        if (!isset($fileData['csvfile'][0]['path'])) 
            throw new LocalizedException(__('Invalid file path.'));
        if (!isset($fileData['csvfile'][0]['file'])) 
            throw new LocalizedException(__('Invalid file.'));

        $filename = sprintf("%s%s",$fileData['csvfile'][0]['path'], $fileData['csvfile'][0]['file']);

        if (!file_exists($filename)) 
            throw new LocalizedException(__('Uploaded file does not exist.'));


        $this->csvProcessor->setEnclosure('"')->setDelimiter(',');
        $data = $this->csvProcessor->getData($filename);
        $headers = [];
        
        foreach($data as $index => $row) {
            if($index == 0){
                $headers = $row;
            }
            else
            {   $values = array_combine($headers, $row);
                $storeId = $values['store_id'] ?? 0;
                $identifier = $values['identifier'];
                $block = $this->blockFactory->create();
                $block->setStoreId($storeId);
                $this->blockResource->load($block, $identifier, BlockInterface::IDENTIFIER);
                if ($block->getId()) {
                    $values[BlockInterface::BLOCK_ID] = $block->getId();
                }
                $block->setData($values);
                $this->blockResource->save($block);
            }
        }
    }

}
