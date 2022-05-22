<?php

/**
 * auth file for rest api
 */

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;

class TestController extends BaseController
{
	public function test() {
		//return $this->sendError('Entered Client Code does not match with any user.');
		 return $this->sendResponse(array(), 'Success');
	}
}
