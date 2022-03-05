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

declare(strict_types=1);

namespace Sanjeev\ImportExportCms\Controller\Adminhtml\Cms;

use Sanjeev\ImportExportCms\Controller\Adminhtml\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;


class Save extends Action implements HttpPostActionInterface
{
    protected $importBlock;

    protected $importPage;
    /**
     * Save constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context,
        \Sanjeev\ImportExportCms\Model\ImportBlock $importBlock,
        \Sanjeev\ImportExportCms\Model\ImportPage $importPage
    ) {
        parent::__construct($context);
        $this->importBlock = $importBlock;
        $this->importPage = $importPage;
    }

    /**
     * run the action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();
        try
        {
            if(isset($params['import_type']) && in_array($params['import_type'],['cms_page','cms_block'])){

                if($params['import_type'] == 'cms_page'){

                   $this->importPage->importPages($params);
                   $this->messageManager->addSuccessMessage(__("Pages successfully imported."));
                }
                else
                {
                    $this->importBlock->importBlocks($params);
                    $this->messageManager->addSuccessMessage(__("Blocks successfully imported."));
                }
            }
            else
            {
                $this->messageManager->addErrorMessage(__("Please select import type."));
            }

        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was a problem saving the Template.'.$e->getMessage()));
        }
        $resultRedirect->setPath('*/*/import');
        return $resultRedirect;
    }
}
