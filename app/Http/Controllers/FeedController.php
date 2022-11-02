<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class FeedController extends Controller
{

    /**
     * Export products feed
     * @param string $type
     */
    public function export($type = 'json')
    {

        return match ($type) {
            'json' => $this->jsonExport(),
            'xml' => $this->xmlExport(),
            'default' => ResponseHelper::notFound()
        };
    }

    /**
     * 
     */
    private function jsonExport()
    {
        return 'json';
    }

    private function xmlExport()
    {
        return 'xml';
    }
}
