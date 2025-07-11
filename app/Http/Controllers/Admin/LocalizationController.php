<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LocalizationController extends Controller
{
    public function adminIndex(): View
    {
        $languages = Language::all();
        return view('admin.localization.admin-index', compact('languages'));
    }

    public function frontendIndex(): View
    {
        $languages = Language::all();
        return view('admin.localization.frontend-index', compact('languages'));
    }

    public function extractLocalizationStrings(Request $request)
    {
        $directories = explode(',', $request->directory);

        $languageCode = $request->language_code;
        $fileName = $request->file_name;

        $localizationStrings = [];

        foreach ($directories as $directory) {

            $directory = trim($directory);

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

            /** Iterate over each file in the directory */
            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }

                $contents = file_get_contents($file->getPathname());

                preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $match = preg_replace('/^(frontend|admin)\./', '', $match);
                        $localizationStrings[$match] = $match;
                    }
                }
            }
        }

        $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";

        // create language sub folder if it is not exit
        if (!File::isDirectory(lang_path($languageCode))) {
            File::makeDirectory(lang_path($languageCode), 0755, true);
        }

        // dd(lang_path($languageCode.'/'.$fileName.'.php'));
        file_put_contents(lang_path($languageCode . '/' . $fileName . '.php'), $phpArray);

        toast(__('admin.Generated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateLangString(Request $request): RedirectResponse
    {

        $languageStrings = trans($request->file_name, [], $request->lang_code);

        $languageStrings[$request->key] = $request->value;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";

        file_put_contents(lang_path($request->lang_code . '/' . $request->file_name . '.php'), $phpArray);

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    // public function translateString(Request $request)
    // {
    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    // 	'x-rapidapi-host' => 'free-google-translator.p.rapidapi.com',
    // 	'x-rapidapi-key' => '44614c1712msh18d37b0579abddfp1a83ecjsn88859743402d',
    //     ])
    //         ->post('https://free-google-translator.p.rapidapi.com/external-api/free-google-translator?from=en&to=ar&query=Thank%20you%20for%20choosing%20me!', [
    //             [
    //                 "translate"=> "rapidapi",
    //             ],
    //         ]);

    //     // dd($response->body());
    //     return $response->body();
    // }


    public function translateString(Request $request)
    {
        try {
        $langCode = $request->language_code;

        $languageStrings = trans($request->file_name, [], $request->language_code);

        $keyStrings = array_keys($languageStrings);

        $text = implode(' | ', $keyStrings);

        //         $response = Http::asJson()->withHeaders([
        //             // 'x-rapidapi-host' => 'google-api31.p.rapidapi.com',
        //             // 'x-rapidapi-key' => '44614c1712msh18d37b0579abddfp1a83ecjsn88859743402d',
        //         ])->post('https://google-api31.p.rapidapi.com/translate', [
        //             'text' => $text,
        //             'to' => $langCode,
        //             'from_lang' => ''
        //         ]);

        // dd($response->body());

        //         return $response->body();
        $response = Http::asJson()->withHeaders([
            'Content-Type' => 'application/json',
            'x-rapidapi-host' => getSetting('site_api_host'),
            'x-rapidapi-key' => getSetting('site_api_key'),
        ])
            ->post("https://free-google-translator.p.rapidapi.com/external-api/free-google-translator?from=en&to=$langCode&query=$text", [
                [
                    "translate" => "rapidapi",
                ],
            ]);
        // dd($response->object());
        // dd($response->body());
        // return $response->body();

        $data = $response->object();
        $transLatedText = $data->translation ?? '';

        $transLatedValues = explode(' | ', $transLatedText);

        $updatedArray = array_combine($keyStrings, $transLatedValues);

        $phpArray = "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n";

        file_put_contents(lang_path($langCode . '/' . $request->file_name . '.php'), $phpArray);

        return response(['status' => 'success', 'message' => __('admin.Translation is completed')]);

        } catch (\Throwable $th) {
        return response(['status' => 'error', $th->getMessage()]);
        }
    }
}
// انتبه للاتنين ودا ينفع برده
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'x-rapidapi-host' => 'google-api31.p.rapidapi.com',
        //     'x-rapidapi-key' => '44614c1712msh18d37b0579abddfp1a83ecjsn88859743402d',
        // ])->withBody('{"text":"William(4.3 m) yachts eat.","to":"ar","from_lang":""}', 'application/json')
        //     ->post('https://google-api31.p.rapidapi.com/translate');
