<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    /**
     * Tên của khóa chính trong bảng.
     *
     * @var string
     */
    protected $primaryKey = 'template_id';

    /**
     * Các trường được phép gán hàng loạt.
     *
     * @var array
     */
    protected $fillable = ['name', 'subject', 'body'];
}
