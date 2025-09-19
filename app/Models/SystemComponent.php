<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Class SystemComponent
 *
 * @version January 14, 2022, 8:54 pm UTC
 *
 * @property string $comp_name
 * @property int $_lft
 * @property int $_rgt
 * @property int $comp_type
 * @property string $route_name
 * @property int $parent_id
 * @property string $comp_ar_label
 */
class SystemComponent extends AppBaseModel
{
    use NodeTrait , SoftDeletes;

    public $table = 'system_components';

    public $fillable = [
        'comp_name',
        '_lft',
        '_rgt',
        'comp_type',
        'route_name',
        'parent_id',
        'prefix',
        'comp_ar_label',
        'is_active',
        'icon_name',
        'config',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'comp_name' => 'string',
        '_lft' => 'integer',
        '_rgt' => 'integer',
        'comp_type' => 'integer',
        'route_name' => 'string',
        'prefix' => 'string',
        'parent_id' => 'integer',
        'comp_ar_label' => 'string',
        'deleted_at' => 'datetime',
        'config' => 'array',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'comp_name' => 'required',
        'comp_type' => 'required',
        'route_name' => 'required',
    ];

    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetSystemName($query, $id)
    {
        $node = self::find($id);
        $parents = self::whereAncestorOf($node)->get();

        $filtered = $parents->where('comp_type', '=', 1)->pluck('route_name')->first();

        return $filtered;
    }

    public function parentData()
    {
        return $this->belongsTo(\App\Models\SystemComponent::class, 'parent_id', 'id');
    }

    public function getConfig(): array
    {
        return json_decode($this->config, true);
    }

    public function getReportTemplateName(): string
    {
        $config = $this->getConfig();

        return $config['reportTemplate'];
    }

    public function getReportButtonsArray(): array
    {
        $config = $this->getConfig();

        return $config['reportButtons'];
    }

    public function getReportNumber(): string
    {
        return $this->id + 10000;
    }
}
