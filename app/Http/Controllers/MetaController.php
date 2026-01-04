<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Models\Category;

class MetaController extends Controller
{
    

    public function sources()
    {
       
        return response()->json($this->sourcesData());
    }

   
    public function categories()
    {
        return response()->json($this->categoriesData());
    }

    protected function sourcesData()
    {
        return Source::query()
            ->where('active', true)
            ->orderBy('name', 'asc')
            ->get([
                'id',               
                'name',
                'slug',
                'api_url',
            ]);
    }

    protected function categoriesData()
    {
        return Category::query()            
            ->orderBy('name')
            ->get([
                'id',
                'slug',
                'name'
            ]);
    }
}
