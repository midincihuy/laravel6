<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Menu extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'id', 'parent_id', 'text', 'label', 'can', 'url', 'icon',
    ];
  
    public function submenu()
    {
      return $this->hasMany('App\Menu', 'parent_id')->select(['id','text','label','can','url','icon']);
    }
}
