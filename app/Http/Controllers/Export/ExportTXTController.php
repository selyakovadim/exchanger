<?php

namespace App\Http\Controllers\Export;

class ExportTXTController extends ExportBaseController
{
    protected function getContentType()
    {
        return 'text/plain';
    }

    protected function getView()
    {
        return 'export.txt';
    }
}
