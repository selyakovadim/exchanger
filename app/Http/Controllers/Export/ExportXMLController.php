<?php

namespace App\Http\Controllers\Export;

class ExportXMLController extends ExportBaseController
{
    protected function getContentType()
    {
        return 'text/xml';
    }

    protected function getView()
    {
        return 'export.xml';
    }
}
