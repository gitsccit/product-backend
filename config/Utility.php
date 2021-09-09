<?php
declare(strict_types=1);

namespace ProductBackend\Core;

use Cake\Core\Configure;
use Cake\Http\Session;
use Cake\Routing\Router;

class Utility
{
    static public function getFileName($id, $width = null, $height = null)
    {
        $session = new Session();
        $fileFetcher = Configure::read('Fetchers.file');
        $file = $fileFetcher($id);
        $allowedSizes = $session->read('options.files.resize');
        $allowedSizes = explode(',', $allowedSizes);
        if ($width) {
            foreach ($allowedSizes as $size) {
                if ($width <= $size) {
                    $width = (int)$size;
                    break;
                }
            }
        }
        if ($height) {
            foreach ($allowedSizes as $size) {
                if ($height <= $size) {
                    $height = (int)$size;
                    break;
                }
            }
        }

        $fileName = $id;
        if ($width) {
            $fileName = "{$fileName}_$width";

            if ($height) {
                $fileName = "{$fileName}x$height";
            }
        }

        $extension = get_file_extension_from_mime_type($file['mime_type']['name']);
        $fileName = $fileName . $extension;

        return $fileName;
    }

    static public function getFileUrl($id, $width = null, $height = null)
    {
        if (empty($id)) {
            return 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
        }

        return Router::url('/files/' . self::getFileName($id, $width, $height));
    }
}