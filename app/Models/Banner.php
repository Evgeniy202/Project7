<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $visible = [
        'id',
        'active',
        'priority',
        'image',
        'title',
        'link',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function createBanner(array $data)
    {
        $banner = new Banner();

        $banner->active = $data['active'] ?? false;
        $banner->priority = $data['priority'] ?? 0;
        $banner->title = $data['title'];
        $banner->link = $data['link'];
        $banner->description = $data['description'] ?? null;

        if(isset($data['image']))
        {
            $banner->image = $data['image']->store('banners', 'public');
        }

        $banner->save();

        return $banner;
    }

    public static function updateBanner(array $data, $banner)
    {
        $banner->active = $data['active'] ?? false;
        $banner->priority = $data['priority'] ?? 0;
        $banner->title = $data['title'];
        $banner->link = $data['link'];
        $banner->description = $data['description'] ?? null;

        if ((!empty($data['image'])) && ($banner->image != $data['image']))
        {
            Storage::disk('public')->delete($banner->image);
            $banner->image = $data['image']->store('banners', 'public');
        }

        $banner->save();

        return $banner;
    }
}
