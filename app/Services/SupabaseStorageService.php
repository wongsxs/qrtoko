<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class SupabaseStorageService
{
    protected ?string $url;

    protected ?string $key;

    protected string $bucket;

    public function __construct()
    {
        $this->url = rtrim((string) env('SUPABASE_URL'), '/');
        $this->key = env('SUPABASE_KEY');
        $this->bucket = (string) env('SUPABASE_BUCKET', 'media');
    }

    /**
     * Upload an uploaded file to Supabase Storage or fallback to local disk.
     */
    public function upload(UploadedFile $file, string $folder = 'uploads'): ?string
    {
        if ($this->url && $this->key) {
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = Str::random(40).'.'.$extension;
            $path = trim($folder, '/').'/'.$filename;
            $endpoint = "{$this->url}/storage/v1/object/{$this->bucket}/{$path}";

            try {
                $response = Http::withHeaders([
                    'apikey' => $this->key,
                    'Authorization' => 'Bearer '.$this->key,
                    'Content-Type' => $file->getMimeType() ?: 'application/octet-stream',
                    'x-upsert' => 'true',
                ])->withBody(
                    (string) file_get_contents($file->getRealPath()),
                    $file->getMimeType() ?: 'application/octet-stream'
                )->post($endpoint);

                if ($response->successful()) {
                    return "{$this->url}/storage/v1/object/public/{$this->bucket}/{$path}";
                }

                Log::error('Supabase Storage upload failed: '.$response->body());
            } catch (Throwable $e) {
                Log::error('Supabase Storage exception: '.$e->getMessage());
            }
        }

        return $file->store($folder, 'public');
    }

    /**
     * Delete a file from Supabase Storage or local storage disk.
     */
    public function delete(?string $pathOrUrl): bool
    {
        if (! $pathOrUrl) {
            return false;
        }

        if ($this->url && str_starts_with($pathOrUrl, $this->url)) {
            $prefix = "{$this->url}/storage/v1/object/public/{$this->bucket}/";
            if (str_starts_with($pathOrUrl, $prefix)) {
                $objectPath = substr($pathOrUrl, strlen($prefix));
                $endpoint = "{$this->url}/storage/v1/object/{$this->bucket}/{$objectPath}";

                try {
                    $response = Http::withHeaders([
                        'apikey' => $this->key,
                        'Authorization' => 'Bearer '.$this->key,
                    ])->delete($endpoint);

                    return $response->successful();
                } catch (Throwable $e) {
                    Log::error('Supabase Storage delete error: '.$e->getMessage());
                }
            }
        }

        if (Storage::disk('public')->exists($pathOrUrl)) {
            return Storage::disk('public')->delete($pathOrUrl);
        }

        return false;
    }
}
