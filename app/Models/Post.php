<?php

namespace App\Models;

use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends AppBaseModel
{
    use AttachmentTrait;
    use HasFactory;

    protected $fillable = ['title', 'body'];
}
