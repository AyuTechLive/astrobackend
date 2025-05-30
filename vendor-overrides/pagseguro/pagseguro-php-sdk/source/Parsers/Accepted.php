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

namespace PagSeguro\Parsers;

use PagSeguro\Domains\Requests\Requests;

/**
 * Trait Accepted
 * @package PagSeguro\Parsers
 */
trait Accepted
{
    public static function getData(Requests $request, $properties)
    {
        $data = [];
        if (!is_null($request->acceptedPaymentMethods())) {
            $accepted = $request->acceptedPaymentMethods();
            if (!is_null($accepted['accept'])) {
                $data[$properties::ACCEPT_PAYMENT_METHOD_GROUP] =
                    implode(',', lw_current_func($accepted['accept'])->getGroups());
                if (!is_null(lw_current_func($accepted['accept'])->getNames())) {
                    $data[$properties::ACCEPT_PAYMENT_METHOD_NAME] =
                        implode(',', lw_current_func($accepted['accept'])->getNames());
                }
            }
            if (!is_null($accepted['exclude'])) {
                $data[$properties::EXCLUDE_PAYMENT_METHOD_GROUP] =
                    implode(',', lw_current_func($accepted['exclude'])->getGroups());
                if (!is_null(lw_current_func($accepted['exclude'])->getNames())) {
                    $data[$properties::EXCLUDE_PAYMENT_METHOD_NAME] =
                        implode(',', lw_current_func($accepted['exclude'])->getNames());
                }
            }
        }
        return $data;
    }
}
