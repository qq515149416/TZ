<?php

namespace App\Admin\Models\News;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;


class HelpTagModel extends Model
{
    use SoftDeletes;

	protected $table = 'tz_help_tag';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $guarded = [];
    public function push_data($data)
    {
        foreach($data as $key => $val)
        {
            $this->setAttribute($key,$val);
        }
        $this->save();
    }
}
