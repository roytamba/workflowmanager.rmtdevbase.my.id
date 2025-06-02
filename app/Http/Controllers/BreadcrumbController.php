<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BreadcrumbController extends Controller
{
    public function getBreadcrumbs(Request $request)
    {
        $segments = $request->segments();

        $breadcrumbs = [
            [
                'title' => 'Dashboard',
                'url' => url('/'),
            ]
        ];

        $url = '';
        foreach ($segments as $key => $segment) {
            $url .= '/' . $segment;

            // Jangan tambahkan segment 'dashboard' lagi kalau sudah ada Dashboard di awal
            if ($segment == 'dashboard') {
                continue;
            }

            if ($key == count($segments) - 1) {
                $breadcrumbs[] = [
                    'title' => ucfirst(str_replace('-', ' ', $segment)),
                ];
            } else {
                $breadcrumbs[] = [
                    'title' => ucfirst(str_replace('-', ' ', $segment)),
                    'url' => url($url),
                ];
            }
        }

        return $breadcrumbs;
    }
}
