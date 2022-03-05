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

namespace Sanjeev\ImportExportCms\Controller\Adminhtml\Cms;

use Sanjeev\ImportExportCms\Controller\Adminhtml\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Export extends Action implements HttpPostActionInterface
{

    protected $exportPage;

    protected $exportBlock;

    protected $fileFactory;

    public function __construct(Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Sanjeev\ImportExportCms\Model\ExportPage $exportPage,
        \Sanjeev\ImportExportCms\Model\ExportBlock $exportBlock
    )
    {
        parent::__construct($context);
        $this->exportPage = $exportPage;
        $this->exportBlock = $exportBlock;
        $this->fileFactory = $fileFactory;
    }
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $type = $this->getRequest()->getParam("type");
        $selected = $this->getRequest()->getParam("selected",[]);
        if ($type == 'page') {
            if($filePath = $this->exportPage->exportPages($selected))
            {
                $downloadedFileName = basename($filePath);
                $content['type'] = 'filename';
                $content['value'] = $filePath;
                $content['rm'] = 1;
                return $this->fileFactory->create($downloadedFileName, $content, DirectoryList::VAR_DIR);
            }
        }
        if ($type == 'block') {
            if($filePath = $this->exportBlock->exportBlocks($selected))
            {
                $downloadedFileName = basename($filePath);
                $content['type'] = 'filename';
                $content['value'] = $filePath;
                $content['rm'] = 1;
                return $this->fileFactory->create($downloadedFileName, $content, DirectoryList::VAR_DIR);
            }
        }
    }
}
