<?php
/**
 * use your namespace instead
 */
namespace Adil\WPPlugin\Controllers;
/**
*
*/
class HomeController extends Controller
{
    public function index()
    {
        return $this->view('home.php');
    }
}
