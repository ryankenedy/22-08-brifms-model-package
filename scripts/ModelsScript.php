<?php

namespace PcsIndonesia\FmsbriPackage\Scripts;

class ModelsScript
{
    public static function delete(array $paths)
    {
        foreach ($paths as $path) {
            if (file_exists(app_path("Models/$path"))) {
                unlink(app_path("Models/$path"));
            }
        }
    }
}