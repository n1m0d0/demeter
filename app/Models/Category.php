<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    const ACTIVO = 1;
    const INACTIVO = 2;

    public function subcategories()
    {
        return $this->HasMany(Subcategory::class);
    }
}
