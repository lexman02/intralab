<?php

namespace App\Models;

use LdapRecord\Models\OpenLDAP\Group as BaseGroup;

class Group extends BaseGroup
{
    public static $objectClasses = ['top', 'apple-group', 'posixGroup'];
}
