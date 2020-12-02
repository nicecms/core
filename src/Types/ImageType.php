<?php

namespace Nice\Core\Types;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nice\Core\Attribute;
use Nice\Core\Item;
use Nice\Core\Types\BaseType;

class ImageType extends BaseType
{
    public function key()
    {
        return 'image';
    }

    /**
     * @param UploadedFile $data
     * @param Attribute|null $attibute
     * @param Item|null $item
     * @return string|void
     */
    public function storable($data, $attibute = null, $item = null)
    {

        if (!$data) {
            return null;
        }

        $file = $data;

        $disk = $attibute->param('disk', config('nice.storage_disk'));

        $directory = $attibute->param('directory', config('nice.storage_directory'));

        $ext = $data->extension();

        if ($item->entity()->hasUrl()) {
            $name = $item->url;

        } else {
            $name = $item->makeSlug();

        }

        $name = $attibute->param('prefix', '') . $name;

        $name = $name . substr(md5(Str::random()), 0, 6);

        $name = $name . "." . $ext;

        $path = Storage::disk($disk)->putFileAs($directory, $file, $name);

        $url = Storage::disk($disk)->url($path);

        return $url;

    }

    public function isInputFile()
    {
        return true;
    }

}
