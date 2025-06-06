<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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

            // Skip dashboard segment karena sudah ada
            if ($segment === 'dashboard') {
                continue;
            }

            // Jika segment ini adalah action (biasanya segment ke-2), tampilkan tanpa url
            if ($key === 1 && $this->isActionSegment($segment)) {
                $breadcrumbs[] = [
                    'title' => ucfirst(str_replace('-', ' ', $segment)),
                    // tanpa url agar tidak clickable
                ];
                continue;
            }

            // Jika segment terakhir dan pola resource/action/id terenkripsi
            if ($key === count($segments) - 1 && $this->isDynamicResourceRoute($segments)) {
                $resource = $segments[0];
                $encryptedId = $segment;

                $funcName = 'get' . ucfirst($resource) . 'NameFromEncryptedId';

                if (method_exists($this, $funcName)) {
                    $title = $this->$funcName($encryptedId);
                } else {
                    $title = ucfirst($resource);
                }

                $breadcrumbs[] = [
                    'title' => $title,
                    // segment terakhir juga tanpa url
                ];
                continue;
            }

            // Segment selain action dan terakhir, buat link
            $breadcrumbs[] = [
                'title' => ucfirst(str_replace('-', ' ', $segment)),
                'url' => url($url),
            ];
        }

        return $breadcrumbs;
    }

    /**
     * Cek apakah segment ini adalah action yang umum dipakai di URL.
     * Contoh: show, edit, create, update, delete.
     */
    private function isActionSegment(string $segment): bool
    {
        $actions = ['show', 'edit', 'create', 'update', 'delete'];
        return in_array(strtolower($segment), $actions);
    }

    /**
     * Cek apakah segments URL sesuai pola resource/action/id terenkripsi.
     */
    private function isDynamicResourceRoute(array $segments): bool
    {
        if (count($segments) < 3) {
            return false;
        }

        $resource = $segments[0];
        $action = $segments[1];
        $idSegment = $segments[count($segments) - 1];

        if (!ctype_alpha($resource) || !ctype_alpha($action)) {
            return false;
        }

        try {
            // decrypt dengan urldecode karena kemungkinan id terenkripsi di-url-kan
            Crypt::decrypt(urldecode($idSegment));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Contoh fungsi untuk mendapatkan nama project dari id terenkripsi.
     * Buat fungsi serupa untuk resource lain jika diperlukan.
     */
    private function getProjectNameFromEncryptedId(string $encryptedId): string
    {
        try {
            $id = Crypt::decrypt(urldecode($encryptedId));
            $project = Project::find($id);
            return $project ? $project->name : 'Unknown Project';
        } catch (DecryptException $e) {
            return 'Invalid Project';
        }
    }
}
