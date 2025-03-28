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
 * Trait GatewaySystem
 * @package PagSeguro\Parsers\Response
 */
trait GatewaySystem
{
    private $gatewaySystem;

    /**
     * @return \PagSeguro\Domains\Responses\GatewaySystem
     */
    public function getGatewaySystem()
    {
        return $this->gatewaySystem;
    }

    /**
     * @param xmlObject $gatewaySystem
     * @return \Pagseguro\Parsers\Response\GatewaySystem
     */
    public function setGatewaySystem($gatewaySystem)
    {
        if ($gatewaySystem) {
            $this->gatewaySystem = new \PagSeguro\Domains\Responses\GatewaySystem();
            $this->gatewaySystem->setAuthorizationCode(lw_current_func($gatewaySystem->authorizationCode))
                ->setEstablishmentCode(lw_current_func($gatewaySystem->establishmentCode))
                ->setNormalizedCode(lw_current_func($gatewaySystem->normalizedCode))
                ->setNormalizedMessage(lw_current_func($gatewaySystem->normalizedMessage))
                ->setNsu(lw_current_func($gatewaySystem->nsu))
                ->setRawCode(lw_current_func($gatewaySystem->rawCode))
                ->setRawMessage(lw_current_func($gatewaySystem->rawMessage))
                ->setTid(lw_current_func($gatewaySystem->tid))
                ->setType(lw_current_func($gatewaySystem->type));
        }
        return $this;
    }
}
