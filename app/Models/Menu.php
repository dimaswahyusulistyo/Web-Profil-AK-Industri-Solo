<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';

    protected $fillable = [
        'nama_menu', 'parent_id', 'menu_type', 'link_type', 'page_id', 'url_halaman', 'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function page()
    {
        return $this->belongsTo(KontenBiasa::class, 'page_id');
    }

    public function getDepth(): int
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return $depth;
    }

    public function getParentPath(): string
    {
        $path = [];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->nama_menu);
            $parent = $parent->parent;
        }

        return implode(' → ', $path);
    }

    public static function getTreeSortedIds($parentId = null, &$ids = [])
    {
        $items = self::where('parent_id', $parentId)->orderBy('urutan')->get();
        foreach ($items as $item) {
            $ids[] = $item->id;
            self::getTreeSortedIds($item->id, $ids);
        }
        return $ids;
    }
}
