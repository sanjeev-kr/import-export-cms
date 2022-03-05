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

use Magento\Framework\Exception\FileSystemException;
use Magento\Cms\Api\Data\PageInterface;

class ImportPage
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    private $pageFactory;

    /**
     * @var ResourceModel\Page
     */
    private $pageResource;

    /**
     * @var Magento\Framework\File\Csv
     */
    private  $csvProcessor;

    public  function __construct(
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Cms\Model\ResourceModel\Page $pageResource
    ){
        $this->csvProcessor = $csvProcessor;
        $this->pageFactory = $pageFactory;
        $this->pageResource = $pageResource;
    }

    /**
     * @param array $fileData
     * @return false|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public  function importPages(array $fileData){

        if (!isset($fileData['csvfile'][0]['path'])) 
            throw new LocalizedException(__('Invalid file path.'));
        if (!isset($fileData['csvfile'][0]['file'])) 
            throw new LocalizedException(__('Invalid file.'));

        $filename = sprintf("%s%s",$fileData['csvfile'][0]['path'], $fileData['csvfile'][0]['file']);

        if (!file_exists($filename)) 
            throw new \Magento\Framework\Exception\LocalizedException(__('Uploaded file does not exist.'));


        $this->csvProcessor->setEnclosure('"')->setDelimiter(',');
        $data = $this->csvProcessor->getData($filename);
        $headers = [];
        $pages = [];

        foreach($data as $index => $row) {
            if($index == 0){
                $headers = $row;
            }
            else
            {   $values = array_combine($headers, $row);
                $storeId = $values['store_id'] ?? 0;
                $identifier = $values['identifier'];
                $page = $this->pageFactory->create();
                $page->setStoreId($storeId);
                $this->pageResource->load($page, $identifier, PageInterface::IDENTIFIER);
                if ($page->getId()) {
                    $values[PageInterface::PAGE_ID] = $page->getId();
                }
                $page->setData($values);
                $this->pageResource->save($page);
            }
        }
    }

}
