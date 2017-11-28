<?php
/**
 * use your namespace instead
 */
namespace /*[Namespace]*/Controllers;
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
