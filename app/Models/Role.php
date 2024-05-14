<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'access_rights'];

    const PERMISSION_ROLES = 'roles';
    const PERMISSION_SERVICE_FEES = 'service_fees';
    const PERMISSION_USERS = 'users';
    const PERMISSION_COMPANIES = 'companies';
    const PERMISSION_COMPANIES_ACCOUNTS = 'company_accounts';
    const PERMISSION_COMPANIES_BRANCHES = 'company_branches';
    const PERMISSION_COMPANIES_TRUCKS = 'company_trucks';
    const PERMISSION_COMPANIES_TRAILERS = 'company_trailers';
    const PERMISSION_COMPANIES_DRIVERS = 'company_drivers';
    const PERMISSION_COMPANIES_CALL_OUTS = 'company_call_outs';
    const PERMISSION_CONTROLLERS = 'controllers';
    const PERMISSION_SP = 'service_providers';
    const PERMISSION_SP_BRANCHES = 'service_providers_branches';
    const PERMISSION_SP_FEES = 'service_providers_fees';
    const PERMISSION_SP_ACCOUNTS = 'service_providers_accounts';
    const PERMISSION_ACCCOUNTANTS = 'accountants';
    const PERMISSION_REPORTS = 'reports';

    public static $permission = [
        self::PERMISSION_ROLES => 'Roles',
        self::PERMISSION_SERVICE_FEES => 'Service Fees',
        self::PERMISSION_USERS => 'Users',
        self::PERMISSION_ACCCOUNTANTS => 'Accoutant Users',
        self::PERMISSION_COMPANIES => 'Company Users',
        self::PERMISSION_CONTROLLERS => 'Controller Users',
        self::PERMISSION_SP => 'Service Provider Users',
        self::PERMISSION_COMPANIES_ACCOUNTS => 'Companies',
        self::PERMISSION_COMPANIES_BRANCHES => 'Companies Branches',
        self::PERMISSION_COMPANIES_TRUCKS => 'Trucks',
        self::PERMISSION_COMPANIES_TRAILERS => 'Trailers',
        self::PERMISSION_COMPANIES_DRIVERS => 'Drivers',
        self::PERMISSION_COMPANIES_CALL_OUTS => 'Call Outs',
        self::PERMISSION_SP_ACCOUNTS => 'Service Providers',
        self::PERMISSION_SP_BRANCHES => 'Service Providers Branches',
        self::PERMISSION_SP_FEES => 'Fees',
        self::PERMISSION_REPORTS => 'Reports',
    ];
}