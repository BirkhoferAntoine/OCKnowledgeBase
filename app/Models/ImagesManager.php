<?php


namespace App\Models;


use App\Support\Security;
use Slim\Http\ServerRequest as Request;
use Slim\Psr7\UploadedFile;
use App\Models\DatabaseModel;

class ImagesManager extends DatabaseModel
{
    private Security $_security;

    public function __construct(Security $security)
    {
        $this->_security = &$security;
    }

    private function _hasAuthorization()
    {
        $token = $this->_security->authToken();
        return $this->tokenCheck($token);
    }

    public function uploadImage(Request $request)
    {
        return $this->_uploadImage($request);
    }

    private function _uploadImage(Request $request)
    {
        $this->_security->setRequest($request);
        $auth = $this->_hasAuthorization();

        if (empty($auth))
        {
            return api_response(
                401,
                'Unauthorized',
                'Erreur, veuillez vous authentifier'
            );
        }

        $directory      = resources_path('images');
        $validExt       = array("jpg", "png", "jpeg", "bmp", "gif");
        $uploadedFiles  = $request->getUploadedFiles();
        $content        = '';

        // handle single input with multiple file uploads
        foreach ($uploadedFiles as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

                $fileExt = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

                if (($uploadedFile->getSize() > 0) && (in_array($fileExt, $validExt, true)))
                {
                    $filename = $this->_moveUploadedFile($directory, $uploadedFile);

                    if (!empty($filename)) {
                        $content        .= 'Envoi de ' . $filename . ' aboutit.<br/>';
                        $code           = 201;
                        $message        = 'Image uploaded successfully';
                    }
                } else {
                    $content    .= 'Erreur, fichier invalide';
                    $code       = 400;
                    $message    = 'Image upload failed';
                }
            }
        }

        return api_response($code, $message, $content);

    }

    private function _moveUploadedFile($directory, UploadedFile $uploadedFile, $basename = null)
    {
        $extension  = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename ?: $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename   = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}