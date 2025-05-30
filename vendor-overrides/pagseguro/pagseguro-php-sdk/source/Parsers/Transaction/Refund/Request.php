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

namespace PagSeguro\Parsers\Transaction\Refund;

use PagSeguro\Enum\Properties\Current;
use PagSeguro\Parsers\Error;
use PagSeguro\Parsers\Parser;
use PagSeguro\Resources\Http;

/**
 * Class Request
 * @package PagSeguro\Parsers\Transaction\Refund
 */
class Request extends Error implements Parser
{
    /**
     * @param $code
     * @param $value
     * @return array
     */
    public static function getData($code, $value)
    {
        $data = [];
        $properties = new Current;

        if (!is_null($code)) {
            $data[$properties::TRANSACTION_CODE] = $code;
        }

        if (!is_null($value)) {
            $data[$properties::REFUND_VALUE] = $value;
        }

        return $data;
    }

    /**
     * @param \PagSeguro\Resources\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        $xml = simplexml_load_string($http->getResponse());
        $result = new \PagSeguro\Parsers\Transaction\Refund\Response();
        $result->setResult(lw_current_func($xml));
        return $result;
    }

    /**
     * @param \PagSeguro\Resources\Http $http
     * @return \PagSeguro\Domains\Error
     */
    public static function error(Http $http)
    {
        $error = parent::error($http);
        return $error;
    }
}
