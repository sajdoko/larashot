<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\Image\Manipulations;


/**
 * Class HomeController.
 */
class ScreenshotController extends Controller {

  public function generate(Request $request) {
    $domain = ($request->get('domain')) ? "http://" . $this->clean_domain($request->get('domain')) : null;
    $strategy = ($request->get('strategy')) ? $request->get('strategy') : null;
    $quality = ($request->get('quality')) ? (int) $request->get('quality') : 20;
    if (!$domain || !$strategy) {
      return abort(404, 'bad request');
    }
    $screenshot_file_name = $this->clear_domain($domain) . '.jpeg';

    if ($strategy == 'mobile') {
      $screenshot = Browsershot::url($domain)
        ->ignoreHttpsErrors()
        ->noSandbox()
        ->setDelay(2000) // 2 sec vonese
        ->setScreenshotType('jpeg', $quality) // 0-100 image quality
        ->deviceScaleFactor(1) // 1-3 pixel density
        ->scale(2)
        ->userAgent('Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1')
        ->windowSize(375, 812)
        // ->mobile()
        ->base64Screenshot();
    } else if ($strategy == 'desktop') {
      $screenshot = Browsershot::url($domain)
        ->ignoreHttpsErrors()
        ->noSandbox()
        ->setDelay(2000) // 2 sec vonese
        ->setScreenshotType('jpeg', $quality) // 0-100 image quality
        ->deviceScaleFactor(1) // 1-3 pixel density
        ->scale(1)
        ->windowSize(1280, 800)
        ->base64Screenshot();
    } else {
      $screenshot = "";
    }

    $screenshot = base64_decode($screenshot);
    return response($screenshot)
      ->header('Content-Type', 'image/jpeg');
  }

  private function clean_domain($domain) {
    $domain = trim($domain);
    $clean = preg_replace('#^http(s)?://#', '', $domain);
    $clean = preg_replace('/^www\./', '', $clean);
    $clean_arr = explode('/', $clean);
    $clean = $clean_arr[0];
    $strip = ['~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '=', '+', '[', '{', ']',
      '}', '\\', '|', ';', ':', '"', "'", '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8211;', '&#8212;',
      'â€”', 'â€“', ',', '<', '>', '/', '?', ' '];
    $clean = trim(str_replace($strip, '', strip_tags($clean)));
    $clean = (function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower(utf8_encode($clean));
    $clean = strtolower($clean);

    return $clean;
  }

  private function clear_domain($domain) {
    $clean = preg_replace('#^http(s)?://#', '', $domain);
    $clean = preg_replace('/^www\./', '', $clean);
    $clean = preg_replace('/\./', '', $clean);
    $strip = ['~', '`', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '=', '+', '[', '{', ']',
      '}', '\\', '|', ';', ':', '"', "'", '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8211;', '&#8212;',
      'â€”', 'â€“', ',', '<', '>', '/', '?', ' '];
    $clean = trim(str_replace($strip, '', strip_tags($clean)));
    $clean = (function_exists('mb_strtolower')) ? mb_strtolower($clean, 'UTF-8') : strtolower(utf8_encode($clean));
    $clean = strtolower($clean);

    return $clean;
  }
}
