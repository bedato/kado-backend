<?php

/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Original Author <author@example.com>
 * @author     Another Author <another@example.com>
 * @copyright  1997-2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        NetOther, Net_Sample::Net_Sample()
 * @since      File available since Release 1.2.0
 * @deprecated File deprecated in Release 2.0.0
 */

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\SearchMerchantRequest;
use App\Repositories\Merchant\MerchantsRepositoryInterface;
use App\Http\Resources\MerchantResource;

class MerchantsController extends ApiController
{
    protected $merchantRepository;

    /**
     * MerchantsController constructor.
     *
     * @param MerchantsRepositoryInterface $merchantsRepository - Data repository
     */
    public function __construct(
        MerchantsRepositoryInterface $merchantsRepository
    ) {
        $this->merchantsRepository = $merchantsRepository;
    }

    /**
     * Get Merchant list
     *
     * @param SearchMerchantRequest $request - Request validator
     *
     * @return \App\Http\Resources\MerchantResource
     */
    public function index(SearchMerchantRequest $request): MerchantResource
    {
        $merchant = $this->merchantsRepository->getByToken(
            $request->header('X-Access-Token')
        );

        return new MerchantResource($merchant);
    }
}
