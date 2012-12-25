<?php
/**
 * Test Framework for Magento for Integration with various test solutions
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   EcomDev
 * @package    EcomDev\Test
 * @copyright  Copyright (c) 2012 EcomDev BV (http://www.ecomdev.org)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Ivan Chepurnyi <ivan.chepurnyi@ecomdev.org>
 */
namespace EcomDev\Test\Container\Indexer;

/**
 * Module configuration indexer
 *
 */
class ModuleConfig extends ConfigAbstract
{
    public function index()
    {
        // Main facade stub
    }

    /**
     * Returns module nodes index
     *
     * @return array
     */
    public function indexModules()
    {
        $result = array();

        if (isset($this->getSource()->modules)) {
            foreach ($this->getSource()->modules->children() as $module) {
                if (!in_array((string)$module->active, array('true', '1'), true)) {
                    continue;
                }
                $moduleInfo = array();
                if (isset($module->version)) {
                    $moduleInfo['version'] = (string)$module->version;
                }
                $moduleInfo['codePool'] = (string)$module->codePool;
                $moduleInfo['depends'] = array();
                if (isset($module->depends)) {
                    foreach ($module->depends->children() as $dependsOnModule) {
                        $moduleInfo['depends'][] = $dependsOnModule->getName();
                    }
                }
                $result[$module->getName()] = $moduleInfo;
            }
        }

        return $result;
    }
}