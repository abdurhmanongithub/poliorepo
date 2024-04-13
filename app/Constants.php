<?php

namespace App;


class Constants
{
    const ATTRIBUTE_TYPES = [
        'text',
        'numeric',
        'image',
    ];
    const ROLE_APPROVER = 'Approver';
    const RESEARCHER_USER = 0;
    const EXTERNAL_USER = 1;
    const USER_TYPES = [
        Constants::RESEARCHER_USER => 'Researcher User',
        Constants::EXTERNAL_USER => "External User",
    ];
}
