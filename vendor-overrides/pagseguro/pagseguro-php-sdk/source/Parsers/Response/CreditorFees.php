<?php
/**
 * 2007-2016 [PagSeguro Internet Ltda.]
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author    PagSeguro Internet Ltda.
 * @copyright 2007-2016 PagSeguro Internet Ltda.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */

namespace PagSeguro\Parsers\Response;

/**
 * Trait CreditorFees
 * @package PagSeguro\Parsers\Response
 */
trait CreditorFees
{
    /**
     * @var
     */
    private $creditorFees;

    /**
     * @return mixed
     */
    public function getCreditorFees()
    {
        return $this->creditorFees;
    }
    
    /**
     * @param $creditorFees
     * @return $this
     */
    public function setCreditorFees($creditorFees)
    {
        $creditor = new \PagSeguro\Domains\CreditorFees();

        if (!is_null($creditorFees->intermediationRateAmount)) {
            $creditor->setIntermediationRateAmount(lw_current_func($creditorFees->intermediationRateAmount));
        }

        if (!is_null($creditorFees->intermediationFeeAmount)) {
            $creditor->setIntermediationFeeAmount(lw_current_func($creditorFees->intermediationFeeAmount));
        }

        if (!is_null($creditorFees->installmentFeeAmount)) {
            $creditor->setInstallmentFeeAmount(lw_current_func($creditorFees->installmentFeeAmount));
        }

        if (!is_null($creditorFees->operationalFeeAmount)) {
            $creditor->setOperationalFeeAmount(lw_current_func($creditorFees->operationalFeeAmount));
        }

        if (!is_null($creditorFees->commissionFeeAmount)) {
            $creditor->setCommissionFeeAmount(lw_current_func($creditorFees->commissionFeeAmount));
        }

        $this->creditorFees = $creditor;
        return $this;
    }
}
