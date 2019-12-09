<?php


namespace Light\Views;

use Light\Cookies\CookieHandler;
use Light\Config\ConfigHandler;
use Light\Lang\LangHandler;

class ViewHandler
{

    /**
     * ViewHandler constructor.
     */
    private function __construct(){}

    /**
     * Get A data From the Config file and extract it
     *
     * @param $type
     * @param string $structure
     * @return array|null
     */
    private function get_and_explode($type ,$structure = 'default'): ?array
    {
        $configs = ConfigHandler::get('View');

        $structure = explode(' ', $configs[$type][$structure]);

        return $structure;
    }

    /**
     * Render A view
     */
    public static function render($view_name, $data = [], $structure = "default"): void
    {
        if (!isset($data['lang_name']))
            $data['lang_name'] = CookieHandler::get('lang');

        $data['lang'] = static::get_lang($data['lang_name'], $data['lang_file']);

        $template_structure = static::get_and_explode('structure', $structure);

        foreach ($template_structure as $file){

            # if it's a assets structure like header:style then execute get_assets()
            preg_match_all("/([\w]+):([\w]+)/i", $file, $asset_structure);

            if (!empty($asset_structure[0])){

                $asset_type = $asset_structure[1][0];
                $asset_structure = $asset_structure[2][0];

                static::get_assets($asset_type, $asset_structure);

                continue;
            }

            # if it's a content file replace it with the file which controller called

            if ($file == 'content'){

                require_once ROOT . DS . 'Views' . DS . trim($view_name) . '.view.php';
                echo "\n\t";

                continue;
            }

            # require the file
            require_once ROOT . DS . 'Views' . DS . trim($file) . '.view.php';
            echo "\n\t";

        }

    }

    /**
     * Get assets Files
     */
    public static function get_assets($type, $structure): void
    {
        switch ($type){

            case 'css':

                $css_files = static::get_and_explode($type, $structure);

                foreach ($css_files as $file){

                    $file_path = "public/assets/css/{$file}.css";

                    $file_path = str_replace("\\", "/", $file_path);

                    echo "<link rel=\"stylesheet\" href=\"{$file_path}\" /> \n\t";

                }

            break;

            case 'js':

                $js_files = static::get_and_explode('js', $structure);

                foreach ($js_files as $file){
                    $file_path = "public/assets/js/{$file}.js";

                    $file_path = str_replace("\\", "/", $file_path);

                    echo "<script src=\"{$file_path}\"></script> \n\t";
                }

            break;

        }
    }

    private function get_lang($lang, $lang_file): ?array
    {
        $lang = LangHandler::get_lang_data($lang, $lang_file);

        return $lang;
    }
}