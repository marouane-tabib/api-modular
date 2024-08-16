<?php

namespace App\Models;

use App\Models\Concerns\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class Model extends BaseModel implements ContractsAuditable
{
    use HasFactory;
    use HasSearch;
    use Auditable;
}
