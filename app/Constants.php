<?php

namespace App;


class Constants
{
    const ATTRIBUTE_TYPES = [
        'text',
        'numeric',
        'image',
    ];
    const EXPORT_TYPE_CSV = 'csv';
    const EXPORT_TYPE_EXCEL = 'xlsx';
    const EXPORT_TYPE_PDF = 'pdf';
    const EXPORT_TYPE_HTML = 'html';

    const EXPORT_TYPES = [
        Constants::EXPORT_TYPE_CSV => 'CSV',
        Constants::EXPORT_TYPE_EXCEL => 'EXCEL',
        Constants::EXPORT_TYPE_PDF => 'PDF',
        Constants::EXPORT_TYPE_HTML => 'HTML',
    ];

}
